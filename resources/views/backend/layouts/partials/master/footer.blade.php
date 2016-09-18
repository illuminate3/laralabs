<!-- Main Footer -->
<footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
        {{-- TODO Version number from config or another file --}}
        {!! trans('general.copyright.version', ['v' => '1.0.0']) !!}
    </div>

    <!-- Default to the left -->
    <strong>{!! trans('general.copyright.credits', [
        'name' => 'MarvinLabs',
        'url' => 'http://marvinlabs.com',
        'year' => date('Y'),
    ]) !!}</strong> {!! trans('general.copyright.notice') !!}
</footer>