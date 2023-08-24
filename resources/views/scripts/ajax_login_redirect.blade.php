<script>
//redireciona para a pagina de login quando ha uma chamada ajax com o login expirado
$(document).ready(function () {

	$(document).ajaxError(function(event, jqxhr, settings, exception) {

		
		if (exception == 'Unauthorized') {	       
	        alert('Login Expirado!');
	        window.location = '/login';
	    }
	    else
	    {
	    	$.ajax({
	    		url: "{{route('admin.usuario.testaLogin')}}",
	    		dataType: 'text',
	    		type: 'GET',
	    		error: function(event, jqxhr, settings, exception) {
	    		}
	    	});
	    }
	});

});

</script>