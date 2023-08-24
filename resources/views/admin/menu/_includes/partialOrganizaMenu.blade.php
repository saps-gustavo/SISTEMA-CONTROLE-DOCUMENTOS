@foreach($menus as $menu)
    @if(isset($menu->filhos) && $menu->filhos->count() > 0 )
    <li class="dd-item" data-id="{{$menu->id_menu}}">
        <div class="dd-handle">{{$menu->label_menu}}</div>
        <div class="acoes">
            <a class="black-text link-js edita-menu" data-id="{{$menu->id_menu}}"> <i class="tiny material-icons">create</i></a>
            <span>&nbsp; &nbsp; &nbsp;</span>

            <a class="grey-text exclui-menu-disable" data-id="{{$menu->id_menu}}"> <i class="tiny material-icons" >delete_forever</i></a>
        </div>

        <ol class="dd-list">
            @include('admin.menu._includes.partialOrganizaMenu', ['menus' => $menu->filhos])
        </ol>
    </li>

    @else

        <li class="dd-item" data-id="{{$menu->id_menu}}">
            <div class="dd-handle">{{$menu->label_menu}}</div>
            <div class="acoes">
                <a class="black-text link-js edita-menu" data-id="{{$menu->id_menu}}"> <i class="tiny material-icons">create</i></a>
                <span>&nbsp; &nbsp; &nbsp;</span>

                <a class="red-text link-js exclui-menu" data-id="{{$menu->id_menu}}"> <i class="tiny material-icons" >delete_forever</i></a>
            </div>

        </li>


    @endif
@endforeach
