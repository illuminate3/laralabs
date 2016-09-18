@foreach($items as $item)
    <li @lm-attrs($item) class="@unless($item->link) header @endunless @if($item->hasChildren()) treeview @endif {{ $item->nickname() }}" @lm-endattrs>
        {{-- Is item a link or a simple header? --}}
        @if($item->link)
            <a href="{!! $item->url !!}" @lm-attrs($item->link) @if($item->hasChildren()) class="dropdown-toggle" data-toggle="dropdown" @endif @lm-endattrs>
                {{-- Item left icon --}}
                @php($icon = $item->data('icon'))
                @php($iconClass = $item->data('icon-class'))
                @if (isset($icon))
                    <span class="fa fa-{{ $icon }} {{ $iconClass or '' }}"></span>
                @endif

                {{-- Item title --}}
                @php($titleClass = $item->data('title-class'))
                <span class="{{ $titleClass or '' }}">{!! $item->title !!}</span>

                {{-- Item label --}}
                @php($label = $item->data('label'))
                @php($labelClass = $item->data('label-class'))
                @if (isset($label))
                    <span class="label pull-right {{ $labelClass or 'label-default' }}">
                        {{ $label }}
                    </span>
                @endif

                {{-- Item toggle if has children --}}
                @if($item->hasChildren())
                    <i class="fa fa-angle-left pull-right"></i>
                @endif
            </a>
        @else
            {!! $item->title !!}
        @endif

        {{-- Child items --}}
        @if($item->hasChildren())
            <ul class="treeview-menu">
                @include('backend.layouts.partials.navigation.menu-item', array('items' => $item->children()))
            </ul>
        @endif
    </li>
@endforeach