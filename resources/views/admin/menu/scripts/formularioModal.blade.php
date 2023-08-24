<script>
    $(document).ready(function () {



        //funcoes com escopo global quer podem ser chamadas dentro de qualquer outro escopo
        function carregaFormularioModal(id, id_div)
        {
            $.ajax({
                url: "{{route('admin.menu.formularioModal')}}",
                data: {
                    "id": id
                },
                type: "GET",
                success: function (data) {
                    //insere a partial view no elemento passado como parametro
                    $('#'+id_div).html(data);
                    //carrega os selects
                    $('select').formSelect();
                    //inicializa modal
                    var options = {};
                    var elems = document.querySelectorAll('#modalMenu');
                    var instances = M.Modal.init(elems, options);
                    //abre modal
                    var modal = document.getElementById('modalMenu');
                    var instance = M.Modal.getInstance(modal);
                    instance.open();

                    M.updateTextFields();

                },
                error: function (data)
                {
                    alert(data.responseText);
                }

            });
        }

        $(document).on('click','.inclui-menu', function () {
            carregaFormularioModal(null,'container_modal');
        });

        $(document).on('click','.edita-menu', function (event) {
            carregaFormularioModal($(this).data('id'),'container_modal');
        });


        //Chamada ajax para gravar formulários dos formulários modais
        $(document).on('click','.salvar-menu', function()
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

                        window.location.href = "{{route('admin.menu.organizaMenu')}}";
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
