
 let lat = parseFloat(cordenadas[0]['LATITUD']);
 let lng = parseFloat(cordenadas[0]['LONGITUD']);
 let direccion = cordenadas[0]['street_other'];

 console.log(direccion);

 initMap(lat,lng,direccion);


 function initMap(lat, lng, direccion) {

     var marker;
     let map;

     if (lat == null && lng == null) {
         var myLatLng = {
             lat: 19.398894572801836,
             lng: -99.15639584258695
         };

     } else {
         var myLatLng = {
             lat: lat,
             lng: lng
         };

     }
     map = new google.maps.Map(document.getElementById("map"), {
         center: myLatLng,
         zoom: 13,
     });

     var infowindow = new google.maps.InfoWindow({
         content: '<strong>'+direccion+'</strong>'
     });

     marker = new google.maps.Marker({
         position: myLatLng,
         map: map,
        
         title: "Ubicacion"

     });

     marker.addListener('click', function() {
         infowindow.open(map, marker);
     });




 }