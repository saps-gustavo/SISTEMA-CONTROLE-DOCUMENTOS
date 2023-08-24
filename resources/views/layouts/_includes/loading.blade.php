<style>
    .loading-fade-full{
        position: fixed; /* posição absoluta ao elemento pai, neste caso o BODY */
        /* Posiciona no meio, tanto em relação a esquerda como ao topo */
        width: 100%; /* Largura da DIV */
        height: 100%; /* Altura da DIV */
        /* A margem a esquerda deve ser menos a metade da largura */
        /* A margem ao topo deve ser menos a metade da altura */
        /* Fazendo isso, centralizará a DIV */
        margin-left: 0px;
        margin-top: 0px;
        background-color: #000;
        opacity: 0.6;
        text-align: center; /* Centraliza o texto */
        z-index: 10000; /* Faz com que fique sobre todos os elementos da página */
    }
    .centraliza-loading {
        margin-left: auto;
        margin-right: auto;
        margin-top: 40vh;
    }
</style>

<div class="loading-fade-full" id="div-loading-body">
    <div class="preloader-wrapper active centraliza-loading">
        <div class="spinner-layer spinner-green-only">
            <div class="circle-clipper left">
                <div class="circle"></div>
            </div>
            <div class="gap-patch">
                <div class="circle"></div>
            </div>
            <div class="circle-clipper right">
                <div class="circle"></div>
            </div>
        </div>
    </div>
</div>