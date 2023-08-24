<script type="text/javascript">
(function() {
	let nomeMes = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
    for(let i = 1; i <= nomeMes.length; i++) {
        $("#{{$nomeCampo}}").append(new Option(nomeMes[i-1], i, false, false));
    }
}());
</script>
