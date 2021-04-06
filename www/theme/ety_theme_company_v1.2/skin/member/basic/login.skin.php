<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="<?php echo G5_THEME_URL?>/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<style>
.card-container.card{max-width:350px;padding:40px 40px}.btn{font-weight:700;height:36px;-moz-user-select:none;-webkit-user-select:none;user-select:none;cursor:default}.card{background-color:#f7f7f7;padding:20px 25px 30px;margin:0 auto 25px;margin-top:50px;-moz-border-radius:2px;-webkit-border-radius:2px;border-radius:2px;-moz-box-shadow:0 2px 2px rgba(0,0,0,.3);-webkit-box-shadow:0 2px 2px rgba(0,0,0,.3);box-shadow:0 2px 2px rgba(0,0,0,.3)}.profile-img-card{width:96px;height:96px;margin:0 auto 10px;display:block;-moz-border-radius:50%;-webkit-border-radius:50%;border-radius:50%}.profile-name-card{font-size:16px;font-weight:700;text-align:center;margin:10px 0 0;min-height:1em}.reauth-email{display:block;color:#404040;line-height:2;margin-bottom:10px;font-size:14px;text-align:center;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;box-sizing:border-box}.form-signin #login_id,.form-signin .form-signin button,.form-signin input[type=email],.form-signin input[type=password],.form-signin input[type=text]{width:100%;display:block;margin-bottom:10px;z-index:1;position:relative;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;box-sizing:border-box}.form-signin .form-control:focus{border-color:#6891a2;outline:0;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 8px #6891a2;box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 8px #6891a2}.btn.btn-signin{background-color:#6891a2;padding:0;font-weight:700;font-size:14px;height:36px;-moz-border-radius:3px;-webkit-border-radius:3px;border-radius:3px;border:none;-o-transition:all 218ms;-moz-transition:all 218ms;-webkit-transition:all 218ms;transition:all 218ms}.btn.btn-signin:active,.btn.btn-signin:focus,.btn.btn-signin:hover{background-color:#0c6121}.forgot-password{color:#6891a2}.forgot-password:active,.forgot-password:focus,.forgot-password:hover{color:#0c6121} .register{margin-top:10px}
</style>
<form name="flogin" class="form-signin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post">
<input type="hidden" name="url" value="<?php echo $login_url ?>">
<div class="container">
	<div class="card card-container">
		<img id="profile-img" class="profile-img-card" src="<?php echo G5_THEME_URL?>/img/profile_image.png" />
		<p id="profile-name" class="profile-name-card"></p>
		<form class="form-signin">
			<span id="login_id" class="reauth-email"></span>
			<input type="text" name="mb_id" id="login_id" class="form-control" placeholder="아이디" required autofocus>
			<input type="password" name="mb_password" id="login_pw" class="form-control" placeholder="패스워드" required>
			<div id="remember" class="checkbox">
				<label>
					<input type="checkbox" name="auto_login" id="login_auto_login"> 자동로그인
				</label>
			</div>
			<button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">LOGIN</button>
		</form><!-- /form -->
		<a href="#" class="forgot-password" onclick="this.form.submit()"></a>
		<div class="register">
			<a href="<?php echo G5_BBS_URL ?>/password_lost.php" target="_blank" id="login_password_lost">정보찾기</a>
			<a href="./register.php">회원가입</a>
		</div>
		<?php
		// 소셜로그인 사용시 소셜로그인 버튼
		@include_once(get_social_skin_path().'/social_login.skin.php');
		?>



	</div><!-- /card-container -->

	

</div><!-- /container -->
</form>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="<?php echo G5_THEME_URL?>/assets/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
$(function(){
    $("#login_auto_login").click(function(){
        if (this.checked) {
            this.checked = confirm("자동로그인을 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?");
        }
    });
});

function flogin_submit(f)
{
    return true;
}
</script>
<!-- } 로그인 끝 -->


