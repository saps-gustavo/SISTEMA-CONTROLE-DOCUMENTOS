@foreach($menus as $menu)
    @if(isset($menu->filhos) && $menu->filhos->count() > 0 )
        <li>
            <ul class="collapsible collapsible-accordion">
                <li><a class="collapsible-header waves-teal"><i class="material-icons">{{$menu->icone_menu}}</i><span class="label-menu">{{$menu->label_menu}}</span><i class="material-icons dropdown right">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul>
        {{-- chama recursivamente a própria view --}}
        @include('layouts._includes.menuPartial', ['menus' => $menu->filhos])
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
    @else
        <li>
            <a href="{{ $menu->url_menu ? route((string)$menu->url_menu) : '' }}" class="{{$menu->classe_menu}} @if(!isset($menu->target_menu)) dispara-loading @endif" target="{{$menu->target_menu}}"><i class="material-icons">{{$menu->icone_menu}}</i>{{$menu->label_menu}}</a>
        </li>
    @endif
@endforeach
