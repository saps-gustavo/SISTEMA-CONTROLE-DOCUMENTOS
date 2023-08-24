<script type="text/javascript">
	$(document).on('click','.btn-excluir', function()
	{
		var elemento = $(this);

		$("#div-loading-body").show();

		$.ajax({
			data: { _token: "{{ csrf_token() }}", id_funcionalidade:elemento.data("id")},
			url: "{{ route('admin.funcionalidade.excluir') }}",
			type: "POST",
			dataType: "json",
			success: function(json){

				if(json.status == true)
				{
					window.location.href = "{{route('admin.funcionalidade')}}";
				}
				else
				{
					$("#div-loading-body").hide();
					$.alert({
						title: 'Alerta',
						type: 'red',
						content: json.mensagem
					});
				}

			},
			error: function (json)
			{
				$("#div-loading-body").hide();
				$.alert({
					title: 'Alerta',
					content: json.mensagem,
					type: 'red'
				});
                }
            });
	});
</script>
