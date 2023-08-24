<script type="text/javascript">
	$(document).on('click','.btn-excluir', function()
	{
		var elemento = $(this);
		$.ajax({
			data: { _token: "{{ csrf_token() }}", id_menu:elemento.data("id")},
			url: "{{ route('admin.menu.excluir') }}",
			type: "POST",
			dataType: "json",
			success: function(json){

				if(json.status == true)
				{
					/*$.alert({
						title: 'Mensagem',
						content: json.mensagem,
						type: 'green'
					});*/
					window.location.href = "{{route('admin.menu.organizaMenu')}}";
				}
				else
				{
					$.alert({
						title: 'Alerta',
						type: 'red',
						content: json.mensagem
					});
				}

			},
			error: function (json)
			{
				$.alert({
					title: 'Alerta',
					content: json.mensagem,
					type: 'red'
				});
                //debug
                /*var w = window.open();
                html = resposta.responseText;
                $(w.document.body).html(html);*/
                }
            });
	});

    $(document).on('click', '.exclui-menu', function () {
        carregaFormularioModalExcluir($(this).data('id'), 'container_modal_excluir','modalRemover');
    });

    //funcoes com escopo global quer podem ser chamadas dentro de qualquer outro escopo
    function carregaFormularioModalExcluir(id, id_div, id_modal)
    {
        $.ajax({
            url: "{{route('admin.menu.formularioModalExcluir')}}",
            data: {
                "id": id
            },
            type: "GET",
            success: function (data) {
                //insere a partial view no elemento passado como parametro
                $('#'+id_div).html(data);
                //inicializa modal
                var options = {};
                var elems = document.querySelectorAll('#'+id_modal);
                var instances = M.Modal.init(elems, options);
                //abre modal
                var modal = document.getElementById(id_modal);
                var instance = M.Modal.getInstance(modal);
                instance.open();

                M.updateTextFields();

            },
            error: function (data) {
                alert(data.responseText);
            }

        });
    }
</script>
