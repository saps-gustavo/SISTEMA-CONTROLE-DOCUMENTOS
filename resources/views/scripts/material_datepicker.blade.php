<!-- <script type="text/javascript">
    $(document).ready(function() {
        $('.datepicker').pickadate({
            selectMonths: true,
            selectYears: 5
        });
    });
</script> -->

<script> 
    $(document).ready(function() {
	    // Inicializa calendário
	    $('.datepicker').each(function() {
			var ano_atual = new Date().getFullYear();
	        $(this).datepicker({
				format: 'dd/mm/yyyy',
				formatSubmit: 'yyyy-mm-dd',
				defaultDate: '',
				yearRange: [1900, ano_atual],
				i18n:{
					months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
					monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
					weekdays: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sabádo'],
					weekdaysAbbrev: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
					weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
					today: 'Hoje',
					clear: 'Limpar',
					close: 'Pronto',
					labelMonthNext: 'Próximo mês',
					labelMonthPrev: 'Mês anterior',
					labelMonthSelect: 'Selecione um mês',
					labelYearSelect: 'Selecione um ano',
					selectMonths: true,
					selectYears: 15,
					cancel: 'Cancelar',
					clear: 'Limpar'
				}
			});
			// Pega o valor atual e seta do componente (quando abrir a tela, vir com a data do input já selecionada)
			var date =$(this).val();
			var date = date.split("/").reverse().join(",");
			$(this).datepicker('setDate', date)
	    });
    });
</script>