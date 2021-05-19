@php
XeFrontend::js('assets/core/xe-ui-component/js/xe-page.js')->load();
XeFrontend::js('assets/core/xe-ui-component/js/xe-modal.js')->load();
@endphp

<div class="container-fluid container-fluid--part">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel-group">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">{{xe_trans('xe::multilingualInput')}}</h3>
                        </div>
                    </div>
                    <div class="panel-heading">
                        {{---todo: 좌측 분류, 우측 검색영역--}}
                        {{--<div class="pull-left">--}}
                            {{--<div class="btn-group btn-fillter" role="group">--}}
                                {{--<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">--}}
                                    {{--<span class="caret"></span>--}}
                                {{--</button>--}}
                                {{--<ul class="dropdown-menu" role="menu">--}}
                                    {{--<li class="active"><a href="#">전체</a></li>--}}
                                    {{--<li><a href="#">board</a></li>--}}
                                    {{--<li><a href="#">comment_service</a></li>--}}
                                    {{--<li><a href="#">user</a></li>--}}
                                    {{--<li><a href="#">xe</a></li>--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="pull-right">
                            <div class="input-group search-group">
                                <form>
                                    <input type="hidden" name="namespace" value="{{ $selected_namespace ?: '' }}">
                                    {{--<div id="namespace" data-namespace="{{ $selected_namespace ?: '' }}">--}}
                                        <div class="input-group-btn" id="__xe_namespace">
                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">{{ $selected_namespace ?: xe_trans('xe::all') }} <span class="caret"></span></button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="#" data-namespace="">{{ xe_trans('xe::all') }}</a></li>
                                                @foreach ( $namespaces as $namespace )
                                                <li><a href="#" data-namespace="{{ $namespace }}">{{ $namespace }}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="search-input-group">
                                            <input type="text" class="form-control" name="keyword" aria-label="Text input with dropdown button" placeholder="{{xe_trans('xe::enterKeyword')}}" value="{{ $selected_keyword }}">
                                            <button class="btn-link" id="btn-search" type="submit">
                                                <i class="xi-search"></i><span class="sr-only">{{ xe_trans('xe::search') }}</span>
                                            </button>
                                        </div>
                                    {{--</div>--}}
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        @foreach( $searchList as $search )
                            <?php $keyString = ($search->namespace ? $search->namespace.'::' : '').$search->item; ?>
                        <form>
                        <div class="form-group">
                            <label for="item-title">{{ $keyString }}</label>
                            @include('lang.editorbox', [
                                'name' => $keyString,
                                'langKey' => $keyString,
                                'lines' => $search->lines,
                                'multiline' => $search->multiline,
                            ])
                            <div class="input-group clearfix">
                                <button type="button" class="btn btn-primary pull-right save" data-line-id="{{ $search->id }}">
                                    {{ xe_trans('xe::save') }}
                                </button>
                            </div>
                        </div>
                        </form>
                        @endforeach
                    </div>
                    <div class="panel-footer">
                        <div class="pull-left">
                            {!! $pagination->render() !!}
                        </div>
                        <div class="pull-right">
                            <button type="button" class="btn btn-default" id="__xe_lang-import">{{ xe_trans('xe::import') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.jQuery(function ($) {
        // @FIXME 네가 왜 여기서 나와
        $('button.save').click(function (e) {
            var url = XE.config.getters['router/origin'] + '/' + XE.config.state.router.settingsPrefix + '/lang/save'
            var data = $(this).closest('form').serialize();

            window.XE.put(url, data).then(function (response) {
                XE.toast('success', XE.Lang.trans('xe::saved'));
            }).catch(function (error) {
                XE.toast('danger', XE.Lang.trans('xe::failed'));
            })
        });

        $("#__xe_namespace .dropdown-menu li a").click(function () {
            var selText = $(this).text();
            var selNamespace = $(this).data('namespace');
            $(this).parents('.input-group-btn').find('.dropdown-toggle').html(selText + ' <span class="caret"></span>');
            $(this).closest('form').find('input[name="namespace"]').val(selNamespace);
            $('.open .dropdown-toggle').dropdown('toggle');
            return false;
        });

      $('#__xe_lang-import').click(function () {
        var url = '{{ route('settings.lang.import') }}';
        window.XE.pageModal(url);

        return false
      });
    });
</script>

