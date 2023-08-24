
<div id="modalHabilidade" class="modal">
    <div class="modal-content">
        <a href="#" class="btn-floating waves-effect waves-light grey right modal-action modal-close"><i class="material-icons">clear</i></a>
        <h5>Adicionar Nova Habilidade</h5>
        <div class="row">
            <form class="col s12" action="{{ route('admin.habilidade.salvarAjax') }}" method="post">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col s12">
                        <span id="topform-error-modal" class="help-alert"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col m12">
                        <input id="name" type="text" name="name" value="" >
                        <label for="name" class="">Nome (*)</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col m12">
                        <input id="title" type="text" name="title" value="">
                        <label for="title" class="">Título </label>
                    </div>
                </div>
                @can('habilidade_adicionar')
                    <button class="btn btn-default waves-effect waves-light right salvar-habilidade" type="button" name="action" style="margin-left: 10px;">Salvar
                    </button>
                @endcan
            </form>
        </div>
    </div>
</div>
