<script>
$(document).ready(function() {


    //Chamada ajax para gravar formulários dos formulários modais
    $(document).on('click','.salvar-habilidade', function()
    {
        //identifica o formulário que foi clicado
        var form = $(this).closest('form');
        //chamada ajax
        $.ajax({
            url     : form.attr("action"),
            type    : form.attr("method"),
            data    : form.serialize(),
            dataType: "json",
            success : function ( json )
            {
                if(json.status == true)
                {
                    // $.alert({
                    //     title: 'Mensagem',
                    //     type: 'green',
                    //     content: json.mensagem,
                    // });

                    var instance = M.Modal.getInstance(document.getElementById('modalHabilidade'));
                    instance.close();

                    //recarrega o select de habilidades
                    carregaSelectHabilidades(json.id);

                    limpaCampos();
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
                for(indice in data.responseJSON.errors){
                    errors += data.responseJSON.errors[indice] + '<br>';
                }
                //caso a resposta do JSON venha vazia pega-se o conteúdo de resposta e abre numa nova janela (útil para debug)
                /*if(jQuery.type(data.responseJSON)=='undefined')
                {
                var w = window.open();
                html = data.responseText;
                $(w.document.body).html(html);
            }*/
            //apresenta os erros ao usuário
            form.find('#topform-error-modal').html(errors);

            //move o scroll do modal para que o erro seja mostrado
            form.closest('.modal').scrollTop(0);

        }
    });
});



});
</script>
