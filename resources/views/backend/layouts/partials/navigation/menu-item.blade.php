@foreach($items as $item)
    <li @lm-attrs($item) @if($item->hasChildren()) class="dropdown" @endif @lm-endattrs>
        <a href="{!! $item->url !!}">{!! $item->title !!} </a>
        @if($item->hasChildren())
            <ul class="dropdown-menu">
                @include('backend.layouts.partials.navigation.menu-item', array('items' => $item->children()))
            </ul>
        @endif
    </li>
@endforeach