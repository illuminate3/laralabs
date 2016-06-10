<div class="row">
    <div class="@if(isset($panelClasses)) {{ $panelClasses }} @else col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4 @endif">
        <div class="panel auth-form">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-8 col-xs-offset-2 col-sm-6 col-sm-offset-3">
                        {{-- Company logo --}}
                        <div class="auth-logo">
                            <a href="{{ route('frontend.home') }}"><img src="{{ url('/img/auth/logo.png') }}" alt="{{ trans('views.auth.logo_alt') }}" class="img-responsive center-block"></a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        {{-- Form --}}
                        @include($formPartial)
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                {{-- Footer links --}}
                @if (isset($footerLinks))
                    <div class="row">
                        @php($colSpan = 12 / count($footerLinks))
                        @foreach ($footerLinks as $link)
                            <div class="col-sm-{{ $colSpan }} text-center">
                                <a href="{{ $link['url'] }}" class="footer-link btn btn-link btn-block">{!! $link['label'] !!}</a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>