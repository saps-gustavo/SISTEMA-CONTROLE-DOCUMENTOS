<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('change','input.funcionalidade-input',function(){
			var div = $(this).closest('.funcionalidade-section');
			var funcInput = div.find('.funcionalidade-input');
			if(funcInput.prop('checked')){
				div.find('.habilidade-input').prop('checked', 'checked');
			}else{
				div.find('.habilidade-input').prop('checked', false);
			}
		});
		$(document).on('change','input.habilidade-input',function(){
			var funcSec = $(this).closest('.funcionalidade-section');
			var funcInput = funcSec.find('.funcionalidade-input');
			if(!funcInput.prop('checked')){
				funcInput.prop('checked', 'checked');
			}
			if (!$(this).prop('checked')) {
				if(!funcSec.find(".habilidade-input:checked").length > 0){
					funcInput.prop('checked', false);
				}
			}
		});
		$(document).on('change','input.habilidade-negar',function(){
			if($(this).prop('checked')){
				tituloHabilidade = $('#'+$(this).prop('value')).closest('label').find('span.titulo-habilidade');
				tituloHabilidade.addClass("habilidade-negada");
			}else{
				tituloHabilidade = $('#'+$(this).prop('value')).closest('label').find('span.titulo-habilidade');
				tituloHabilidade.removeClass("habilidade-negada");
			}
		});
	});
</script>