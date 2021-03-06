<?php
/**
 * RegisterController.php
 *
 * PHP version 7
 *
 * @category    Controllers
 * @package     App\Http\Controllers\Auth
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\HttpException;
use XeConfig;
use XeDB;
use XeDynamicField;
use XeFrontend;
use XePresenter;
use XeTheme;
use Xpressengine\User\EmailBroker;
use Xpressengine\User\Exceptions\DisplayNameAlreadyExistsException;
use Xpressengine\User\Exceptions\EmailAlreadyExistsException;
use Xpressengine\User\Exceptions\InvalidConfirmationCodeException;
use Xpressengine\User\Exceptions\InvalidDisplayNameException;
use Xpressengine\User\Exceptions\PendingEmailAlreadyExistsException;
use Xpressengine\User\Models\User;
use Xpressengine\User\Repositories\RegisterTokenRepository;
use Xpressengine\User\TermsHandler;
use Xpressengine\User\UserHandler;
use Xpressengine\User\UserInterface;
use Xpressengine\User\UserRegisterHandler;

/**
 * Class RegisterController
 *
 * @category    Controllers
 * @package     App\Http\Controllers\Auth
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
class RegisterController extends Controller
{
    use RedirectsUsers;

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * @var UserHandler
     */
    protected $handler;

    /**
     * @var EmailBroker
     */
    protected $emailBroker;

    /**
     * @var TermsHandler
     */
    protected $termsHandler;

    /**
     * redirect path
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * RegisterController constructor.
     */
    public function __construct()
    {
        $this->auth = app('auth');
        $this->handler = app('xe.user');
        $this->emailBroker = app('xe.auth.email');
        $this->termsHandler = app('xe.terms');

        XeTheme::selectSiteTheme();
        XePresenter::setSkinTargetId('user/auth');

        $this->middleware('auth', ['only' => ['getRegisterAddInfo', 'postRegisterAddInfo']]);
        $this->middleware('guest', [
            'except' => ['getLogin', 'getLogout', 'getConfirm', 'getRegisterAddInfo', 'postRegisterAddInfo']
        ]);
    }

    /**
     * Show the application registration form.
     *
     * @param Request $request request
     * @return \Xpressengine\Presenter\Presentable
     */
    public function getRegister(Request $request)
    {
        // ?????? ?????? ?????? ??????
        if (!$this->checkJoinable()) {
            return redirect()->back()->with(
                ['alert' => ['type' => 'danger', 'message' => xe_trans('xe::joinNotAllowed')]]
            );
        }

        $request->session()->forget('user_agree_terms');

        //????????? ???????????? ?????? ?????? ?????? ?????? ??????
        $agreeType = app('xe.config')->getVal(
            'user.register.term_agree_type',
            UserRegisterHandler::TERM_AGREE_WITH
        );
        $terms = $this->termsHandler->fetchEnabled();

        $isAllRequireTermAgree = true;
        $requireTerms = $this->termsHandler->fetchRequireEnabled();
        foreach ($requireTerms as $requireTerm) {
            if ($request->has($requireTerm->id) === false) {
                $isAllRequireTermAgree = false;
                break;
            }
        }

        if ($agreeType === UserRegisterHandler::TERM_AGREE_PRE && count($terms) > 0 &&  //?????? ?????? ????????? ?????? ?????? ?????? ??????
            (
                $isAllRequireTermAgree === false || //?????? ????????? ????????? ?????? ????????? ??????
                ($requireTerms->count() === 0 && $request->session()->has('pass_agree') === false))
                //????????? ?????? ????????? ??????????????? session??? ?????? ????????? ?????? ???????????? ?????? ??????
        ) {
            return \XePresenter::make('register.agreement', compact('terms'));
        }

        return $this->getRegisterForm($request);
    }

    /**
     * ??????????????? ???????????? ?????? ?????? ?????? ????????? ?????? ??? ?????? validation ??????
     *
     * @param Request $request request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postTermAgree(Request $request)
    {
        $terms = $this->termsHandler->fetchRequireEnabled();

        $rule = [];
        foreach ($terms as $term) {
            $rule[$term->id] = 'bail|accepted';
        }

        $this->validate(
            $request,
            $rule,
            ['*.accepted' => xe_trans('xe::pleaseAcceptRequireTerms')]
        );

        $request->session()->flash('pass_agree');

        return redirect()->route('auth.register', $request->except('_token'));
    }

    /**
     * Show the application registration form.
     *
     * @param Request $request request
     * @return \Xpressengine\Presenter\Presentable
     */
    protected function getRegisterForm(Request $request)
    {
        $config = app('xe.config')->get('user.register');

        // ???????????? ????????? ????????????
        $parts = $this->handler->getRegisterParts();
        $activated = array_keys(array_intersect_key(array_flip($config->get('forms', [])), $parts));

        $parts = collect($parts)->filter(function ($part, $key) use ($activated) {
            return in_array($key, $activated) || $part::isImplicit();
        })->sortBy(function ($part, $key) use ($activated) {
            return array_search($key, $activated);
        })->map(function ($part) use ($request) {
            return new $part($request);
        });

        $rules = $parts->map(function ($part) {
            return $part->rules();
        })->collapse()->all();

        XeFrontend::rule('join', $rules);

        $userAgreeTerms = [];
        $enableTerms = $this->termsHandler->fetchEnabled();
        foreach ($enableTerms as $enableTerm) {
            if ($request->has($enableTerm->id) === true) {
                $userAgreeTerms[] = $enableTerm->id;
            }
        }

        if (count($userAgreeTerms) > 0) {
            $request->session()->put('user_agree_terms', $userAgreeTerms);
        }

        expose_trans('xe::passwordIncludeNumber');
        expose_trans('xe::passwordIncludeCharacter');
        expose_trans('xe::passwordIncludeSpecialCharacter');

        return \XePresenter::make('register.create', compact('config', 'parts'));
    }

    /**
     * ??????????????? ????????? ?????? ?????? ??????
     *
     * @param Request                 $request         request
     * @param RegisterTokenRepository $tokenRepository RegisterTokenRepository instance
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     *
     * @deprecated since 3.0.8 ???????????? ?????? ??? ????????? ?????? ?????? ??????
     */
    public function postRegisterConfirm(Request $request, RegisterTokenRepository $tokenRepository)
    {
        $this->validate($request, ['email' => 'required|email']);

        $email = $request->get('email');

        try {
            $this->handler->validateEmail($email);
        } catch (\Exception $e) {
            throw new HttpException(400, xe_trans('xe::emailAlreadyExists'));
        }

        $mail = $this->handler->pendingEmails()->findByAddress($email);

        if ($mail === null) {
            \DB::beginTransaction();
            try {
                $mailData = ['address' => $email];
                $user = new User();
                $user->id = app('xe.keygen')->generate();
                $mail = $this->handler->createEmail($user, $mailData, false);
            } catch (\Exception $e) {
                \DB::rollBack();
                throw $e;
            }
            \DB::commit();
        }

        $token = $tokenRepository->create('email', ['email' => $email, 'user_id' => $mail->user_id]);
        $this->emailBroker->sendEmailForRegister($mail, $token);

        return redirect()->route('auth.register', ['token' => $token['id']])->with(
            ['alert' => ['type' => 'success', 'message' => xe_trans('xe::msgEmailSendComplete')]]
        );
    }

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request request
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function postRegister(Request $request)
    {
        // validation
        if (!$this->checkJoinable()) {
            return redirect()->back()->with(
                ['alert' => ['type' => 'danger', 'message' => xe_trans('xe::joinNotAllowed')]]
            );
        }

        $config = app('xe.config')->get('user.register');

        // ???????????? ????????? ????????????
        $parts = $this->handler->getRegisterParts();
        $activated = array_keys(array_intersect_key(array_flip($config->get('forms', [])), $parts));

        $parts = collect($parts)->filter(function ($part, $key) use ($activated) {
            return in_array($key, $activated) || $part::isImplicit();
        })->map(function ($part) use ($request) {
            return new $part($request);
        });

        $parts->each(function ($part) {
            $part->validate();
        });

        $userData = $request->except(['_token']);

        // set default join group
        $joinGroup = $config->get('joinGroup');
        if ($joinGroup !== null) {
            $userData['group_id'] = [$joinGroup];
        }

        if ($request->session()->has('user_agree_terms') === true) {
            $userData['user_agree_terms'] = $request->session()->pull('user_agree_terms');
        } elseif ($request->has('agree') === true) {
            $enableTermIds = [];
            $enableTerms = $this->termsHandler->fetchEnabled();
            foreach ($enableTerms as $term) {
                $enableTermIds[] = $term->id;
            }

            $userData['user_agree_terms'] = $enableTermIds;
        }

        XeDB::beginTransaction();
        try {
            $user = $this->handler->create($userData);
        } catch (\Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        //????????? ?????? ??? ?????? ????????? ?????? ?????? ??? ???????????? ??? ?????? ?????? ??????
        if ($user->status === User::STATUS_PENDING_EMAIL) {
            $this->sendApproveEmail($user);
        }

        // login
        if (app('config')->get('xe.user.registrationAutoLogin') === true) {
            $this->auth->login($user);

            switch ($user->status) {
                case User::STATUS_PENDING_ADMIN:
                    return redirect()->route('auth.pending_admin');
                    break;

                case User::STATUS_PENDING_EMAIL:
                    return redirect()->route('auth.pending_email');
                    break;
            }
        }

        return redirect()->intended(($this->redirectPath()));
    }

    /**
     * Indicate able to join
     *
     * @return boolean
     */
    protected function checkJoinable()
    {
        return XeConfig::getVal('user.register.joinable') === true;
    }

    /**
     * ????????? ????????? ???????????? ??? ???????????? ?????? ?????? ??????
     *
     * @param Request $request request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getSendApproveEmail(Request $request)
    {
        $address = $request->get('email');
        $email = $this->handler->pendingEmails()->findByAddress($address);

        $user = $email->user;
        $this->handler->deleteEmail($email);

        $this->sendApproveEmail($user);

        return redirect('/')->with('alert', ['type' => 'success', 'message' => xe_trans('xe::msgEmailSendComplete')]);
    }

    /**
     * ???????????? ?????? ?????? ??????
     *
     * @param UserInterface $user userItem
     *
     * @return void
     */
    protected function sendApproveEmail(UserInterface $user)
    {
        $tokenRepository = app('xe.user.register.tokens');

        $mail = $this->handler->createEmail($user, ['address' => $user->email], false);
        $token = $tokenRepository->create('register', ['email' => $user->email, 'user_id' => $user->id]);
        $this->emailBroker->sendEmailForRegisterApprove($mail, $token);
    }

    /**
     * ???????????? ?????? ???????????? ????????? ?????? ??????
     *
     * @param Request                 $request         request
     * @param RegisterTokenRepository $tokenRepository register token repository
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function postApproveEmail(Request $request, RegisterTokenRepository $tokenRepository)
    {
        $tokenId = $request->get('token');
        if (!$token = $tokenRepository->find($tokenId)) {
            throw new HttpException(400, xe_trans('xe::msgTokenIsInvalid'));
        }

        $emailAddress = $token->email;
        $email = $this->handler->pendingEmails()->findByAddress($emailAddress);

        $code = $request->get('code');

        XeDB::beginTransaction();
        try {
            //????????? ?????? ??????
            $this->emailBroker->approvalEmail($email, $code);

            //?????? ?????? ??????
            $user = $email->user;
            $this->handler->update($user, ['status' => User::STATUS_ACTIVATED]);

            //register token ??????
            $tokenRepository->delete($tokenId);
        } catch (InvalidConfirmationCodeException $e) {
            XeDB::rollback();
            throw new HttpException(Response::HTTP_FORBIDDEN, xe_trans('xe::invalidConfirmationCode'), $e);
        } catch (Exception $e) {
            XeDB::rollback();
            throw $e;
        }
        XeDB::commit();

        return \XePresenter::make('confirm_email', compact('user'));
    }

    /**
     * Show additional form for user.
     *
     * @return \Xpressengine\Presenter\Presentable
     */
    public function getRegisterAddInfo()
    {
        $fields = $this->getAdditionalField();

        XeFrontend::rule('add-info', $fields->map(function ($field) {
            return $field->getRules();
        })->collapse()->all());

        $userData = array_merge(request()->all(), \Auth::user()->getAttributes());

        return XePresenter::make('register.add-info', compact('fields', 'userData'));
    }

    /**
     * Register additional information of user.
     *
     * @param Request $request request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRegisterAddInfo(Request $request)
    {
        $fields = $this->getAdditionalField();
        $rules =$fields->map(function ($field) {
            return $field->getRules();
        })->collapse();

        $inputs = $this->validate($request, $rules->all());

        $this->handler->update(auth()->user(), $inputs);

        return redirect($this->redirectPath());
    }

    /**
     * Returns additional dynamic fields
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getAdditionalField()
    {
        return collect(XeDynamicField::gets('user'))->filter(function ($field) {
            if (!$field->isEnabled()) {
                return false;
            }

            $rules = implode('|', $field->getRules());
            $rules = array_map('\Illuminate\Support\Str::snake', explode('|', $rules));

            return in_array('required', $rules);
        });
    }

    /**
     * Validate Email
     *
     * @param Request $request request
     * @return \Xpressengine\Presenter\Presentable
     * @throws Exception
     */
    public function validateEmail(Request $request)
    {
        $email = $request->input('email');
        $email = trim($email);
        $exceptId = $request->input('except_id', null);

        $valid = true;
        $message = 'xe::usableEmailAddress';

        try {
            $this->validate($request, [ 'email' => 'email' ]);

            // ?????? ???????????? ???????????? ????????? ??????
            $useEmailConfirm = app('xe.config')->getVal('user.register.guard_forced') === true;
            if ($useEmailConfirm) {
                if ($request->user()->getPendingEmail() !== null) {
                    throw new PendingEmailAlreadyExistsException();
                }
            }

            // ???????????? ???????????? ????????? ??????
            try {
                $uniqueRule = Rule::unique('user', 'email');

                if (isset($input['except_id'])) {
                    $uniqueRule->ignore($exceptId);
                }

                $this->validate($request, [ 'email' => $uniqueRule ]);
            } catch (\Exception $e) {
                throw new EmailAlreadyExistsException();
            }
        } catch (EmailAlreadyExistsException $e) {
            $valid = false;
            $message = $e->getMessage();
        } catch (PendingEmailAlreadyExistsException $e) {
            $valid = false;
            $message = $e->getMessage();
        } catch (\Exception $e) {
            $valid = false;
            throw $e;
        }

        return XePresenter::makeApi(
            ['type' => 'success', 'message' => xe_trans($message), 'email' => $email, 'valid' => $valid]
        );
    }

    /**
     * Validate display name
     *
     * @param Request $request request
     * @return \Xpressengine\Presenter\Presentable
     * @throws Exception
     */
    public function validateDisplayName(Request $request)
    {
        $displayName = $request->get('display_name');
        $displayName = trim($displayName);
        $message = 'xe::usableDisplayName';

        $valid = true;
        try {
            $this->handler->validateDisplayName($displayName);
        } catch (DisplayNameAlreadyExistsException $e) {
            $valid = false;
            $message = $e->getMessage();
        } catch (InvalidDisplayNameException $e) {
            $valid = false;
            $message = $e->getMessage();
        } catch (\Exception $e) {
            $valid = false;
            throw $e;
        }

        return XePresenter::makeApi(
            ['type' => 'success', 'message' => xe_trans($message), 'displayName' => $displayName, 'valid' => $valid]
        );
    }
}
