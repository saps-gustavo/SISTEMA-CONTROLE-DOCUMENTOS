<script type="text/javascript">

    $(document).ready(function() {
        $("#id_entidade").change(function(ev){
            BuscaLancamentosEntidade(this);
        });
    });

    function RelatorioDoacao(){

        var inicio = $("#datainicio").val();
        var fim = $("#datafim").val();
        var tipo_relatorio = $("#tipo_relatorio").val();

        var url = "";

        if(inicio != ""){
            var dia  = inicio.split("/")[0];
            var mes  = inicio.split("/")[1];
            var ano  = inicio.split("/")[2];

            inicio = ano + '-' + ("0"+mes).slice(-2) + '-' + ("0"+dia).slice(-2) + ' 00:00:00';
        }

        if(fim != ""){
            var dia  = fim.split("/")[0];
            var mes  = fim.split("/")[1];
            var ano  = fim.split("/")[2];

            fim = ano + '-' + ("0"+mes).slice(-2) + '-' + ("0"+dia).slice(-2) + ' 23:59:59';
        }

        switch(tipo_relatorio){
            case "0": // Doações
                url = "{{ route('relatorio.doacao') }}";
                break;
            case "1": // Famílias
                url = "{{ route('relatorio.familia') }}";
                break;
            case "2": // Lançamento
                url = "{{ route('relatorio.lancamento') }}";
                break;
            case "3": // Produtos
                url = "{{ route('relatorio.produto') }}";
                break;
            default:
                $.alert({
					title: 'Alerta',
					content: 'Não foi possível identificar o tipo de relatório.',
					type: 'red'
				});
        }
        
        window.location.href = url + '\\' + inicio + '\\' + fim;
    
    }
	
</script>
