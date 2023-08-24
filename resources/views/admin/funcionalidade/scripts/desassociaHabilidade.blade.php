<script type="text/javascript">
    $(document).ready(function() {
        //Chamada ajax para gravar formulários dos formulários modais
	   	$(document).on('click','.desassocia-habilidade', function()
	    {
	        //identifica o formulário que foi clicado
	        var form = $(this).closest('form');
            var id_habilidade = $(this).data('id');
	        //chamada ajax
	        $.ajax({
		        url     : "{{route('admin.funcionalidade.associaHabilidade')}}",
		        type    : "POST",
		        data    :
                        {
                            "id_habilidade": $(this).data('id'),
                            "_token": "{{csrf_token()}}"
                        },
		        dataType: "json",
		        success : function ( json )
		        {
		            if(json.status == true)
		            {
		            	// $.alert({
   						//  	title: 'Mensagem',
   						//  	type: 'green',
    					// 	content: json.mensagem,
						// });
                        carregaTabelaHabilidades({{$funcionalidade->id_funcionalidade}});
                        carregaSelectHabilidades(id_habilidade);
		            }
		            else
		            {
		            	$.alert({
   						 	title: 'Alerta',
   						 	type: 'red',
    						content: json.mensagem,
						});
		            }

		        },
		        error   : function ( data )
		        {
		           //captura os erros vindos da request
		           var errors = '';
		            for(indice in data.responseJSON){
		                errors += data.responseJSON[indice] + '<br>';
		            }
		            //caso a resposta do JSON venha vazia pega-se o conteúdo de resposta e abre numa nova janela (útil para debug)
		            /*if(jQuery.type(data.responseJSON)=='undefined')
		            {
		                var w = window.open();
		                html = data.responseText;
		                $(w.document.body).html(html);
		            }*/
		            //apresenta os erros ao usuário
		            form.find('#topform-error').html(errors);

		            //move o scroll do modal para que o erro seja mostrado
		            form.scrollTop(0);

		        }
	        })
	    });
    });
</script>
