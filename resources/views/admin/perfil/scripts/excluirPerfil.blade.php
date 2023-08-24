<script type="text/javascript">
	$(document).on('click','.btn-excluir', function()
	{
		var elemento = $(this);

		$("#div-loading-body").show();

		$.ajax({
			data: { _token: "{{ csrf_token() }}", id_perfil:elemento.data("id")},
			url: "{{ route('admin.perfil.excluir') }}",
			type: "POST", 
			dataType: "json",
			success: function(json){

				if(json.status == true)
				{
					window.location.href = "{{route('admin.perfil')}}";
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