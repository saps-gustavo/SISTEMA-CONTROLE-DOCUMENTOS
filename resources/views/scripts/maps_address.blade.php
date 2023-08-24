<script>
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'),{zoom: 15});
        var geocoder = new google.maps.Geocoder();
        geocodeAddress(geocoder, map);
    }
    function geocodeAddress(geocoder, resultsMap) {                
        var address = "{{ $dados->end_tipo }} {{ $dados->end_logradouro }} {{ $dados->end_num }} {{ $dados->end_bairro }} {{ $dados->end_cidade }} {{ $dados->end_uf }}";
        geocoder.geocode({'address': address}, function(results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                resultsMap.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                map: resultsMap,
                position: results[0].geometry.location
                });
            } 
            else {
                alert('Ocorreu um erro no processamento de geocodificação. (' + status + ')');
            }
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAO_VxhteTrN0PusTjT7KazyKewRKjQdZo&callback=initMap""></script>