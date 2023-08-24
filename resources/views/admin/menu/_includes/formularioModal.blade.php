<div id="modalMenu" class="modal">
    <div class="modal-content">
        <a href="#" class="btn-floating waves-effect waves-light grey right modal-action modal-close"><i class="material-icons">clear</i></a>
        <h5>Cadastro de Menu @if(isset($menu->id_menu)) - Editar Menu {{$menu->label_menu}} @else - Adicionar Novo @endif</h5>
        <div class="row">
            <form class="col s12" action="{{ route('admin.menu.salvarAjax') }}" method="post">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col s12">
                        <span id="topform-error-modal" class="help-alert"></span>
                    </div>
                </div>

                <input type="hidden" value="{{$menu->id_menu}}" id="id_menu" name="id_menu"></input>

                <div class="row">
                    <div class="input-field col s6">
                        <input id="label_menu" type="text" name="label_menu" value="{{$menu->label_menu}}" autofocus>
                        <label for="name" class="">Label (*)</label>
                    </div>

                    <div class="input-field col s6">
                        <span class="grey-text">Rota</span>
                        <select class="browser-default" id="url_menu" name="url_menu">
                            <option value=''>Selecione a URL</option>
                            @foreach($rotas as $rota)
                                <option value="{{$rota->getName() ?? $rota->uri()}}"
                                    @if($rota->getName() == $menu->url_menu OR $rota->uri() == $menu->url_menu) selected @endif
                                    >{{$rota->getName() ?? $rota->uri()}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s6">
                        <input id="icone_menu" type="text" name="icone_menu" value="{{$menu->icone_menu}}" >
                        <label for="icone_menu" class="">Ícone</label>
                    </div>

                    <div class="input-field col s6">
                        <input id="classe_menu" type="text" name="classe_menu" value="{{$menu->classe_menu}}">
                        <label for="classe_menu" class=""> Classes </label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s6">
                        <span class="grey-text">Funcionalidade</span>
                        <select class="browser-default" id="id_funcionalidade" name="id_funcionalidade">
                            <option value=''>Selecione a Funcionalidade</option>
                            @foreach($funcionalidades as $func)
                                <option value="{{$func->id_funcionalidade}}"
                                    @if($func->id_funcionalidade == $menu->id_funcionalidade) selected @endif
                                    >{{$func->nome_funcionalidade}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="input-field col s6">
                        <input id="target_menu" type="text" name="target_menu" value="{{$menu->target_menu}}">
                        <label for="target_menu" class=""> Target </label>
                    </div>
                </div>

                <button class="btn btn-default waves-effect waves-light right salvar-menu" type="button" name="action" style="margin-left: 10px;">Salvar
                </button>
            </form>
        </div>
    </div>
</div>
