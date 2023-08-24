<script type="text/javascript">
	$(document).on('click','.btn-excluir', function()
	{
		var elemento = $(this);

		var modal_values = elemento.data("id").split("|");

		var id = modal_values[0];
		var uniqid = modal_values[1];

		$("#div-loading-body").show();

		$.ajax({
			data: { _token: "{{ csrf_token() }}", id: id, uniqid: uniqid },
			url: "{{ route('sedh.tipo_termos_administrativos.excluir') }}",
			type: "POST",
			dataType: "json",
			success: function(json){

				if(json.status == true)
				{
					window.location.href = "{{route('sedh.tipo_termos_administrativos')}}";
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
