<script>
	$(document).ready(function()
	{

		var updateOutput = function(e)
	    {
	        var list   = e.length ? e : $(e.target),
	            output = list.data('output');
	        if (window.JSON) {
	            output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
	        } else {
	            output.val('JSON browser support required for this demo.');
	        }
	    };

	    // activate Nestable for list 1
	    $('#nestable').nestable()
	    .on('change', updateOutput);


	    // output initial serialised data
	    updateOutput($('#nestable').data('output', $('#nestable-output')));


	    // $('#nestable-menu').on('click', function(e)
	    // {
	    //     var target = $(e.target),
	    //         action = target.data('action');
		// 	console.log('action');
	    //     if (action === 'expand-all') {
	    //         $('.dd').nestable('expandAll');
	    //     }
	    //     if (action === 'collapse-all') {
	    //         $('.dd').nestable('collapseAll');
	    //     }
	    // });

	    $(document).on('click','.btn-organiza-menu', function () {

	    	//identifica o formulário que foi clicado
	        var form = $(this).closest('form');
	        //chamada ajax
	        $.ajax({
		        url     : form.attr("action"),
		        type    : form.attr("method"),
		        data    : form.serialize(),
		        dataType: "json",
	    		success: function (json)
	    		{
	    			//percorreJson(json);
	    			if(json.status == true)
					{
						 $.alert({
						     title: 'Mensagem',
						     type: 'green',
						     content: json.mensagem,
						 });
						window.location.href = "{{route('admin.menu.organizaMenu')}}";
					}
					else
					{
			    		$.alert({
   						 	title: 'Alerta',
   						 	type: 'red',
    						content: json.mensagem
    					});    					//alert(json.mensagem);
    				}
				},
	    		error: function (json) {

	    		}
	    	});
	    });

	    var percorreJson = function (json)
	    {
	    	if(json && json.length > 0)
	    	{
	    		for(var i = 0; i < json.length; i++)
    			{
			    	var obj = json[i];
				    console.log(obj.id);
				    if(obj.children  && obj.children.length > 0)
				    	percorreJson(obj.children);
				}
	    	}
	    }
	});
</script>
