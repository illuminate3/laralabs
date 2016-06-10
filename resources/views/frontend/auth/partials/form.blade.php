<div class="row">
    <div class="@if(isset($panelClasses)) {{ $panelClasses }} @else col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4 @endif">
        <div class="panel auth-form">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        {{-- Company logo --}}
                        <div class="auth-logo">
                            <a href="{{ route('frontend.home') }}"><img src="{{ url('/img/auth/logo.png') }}" alt="{{ trans('views.auth.logo-alt') }}" class="img-responsive"></a>
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
                        <div class="col-xs-12 text-center">
                            <ul class="list-unstyled list-inline">
                                @foreach ($footerLinks as $link)
                                    <li><a href="{{ $link['url'] }}" class="footer-link">{!! $link['label'] !!}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>