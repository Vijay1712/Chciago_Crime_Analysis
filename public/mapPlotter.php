<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<!DOCTYPE html>
<html>
  <head>
    <link href="css/stylegetstarted.css" type="text/css" rel="stylesheet">
    <link rel="icon" href="assets/8TGbXkpzc.gif">
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

  <style>
  #map{
    height:400px;
    width:50%;
    margin-left:auto;
    margin-right:auto;
    padding: 50px;
  }
</style>

  </head>
  <body>
    <div class="container">
          <h1>CrimeWatch</h1>
     <div class="container2">
  	<p>Chicago</p>
     </div>
   </div>

   <h2 style = "margin-top:0;">Search an area to see its safety level</h2>

   <input id="pac-input" class="controls" type="text" placeholder="Search Box">
  <div id="map"></div> <br><br>
  <a class = "getstarted" href="index.php">Back to home</a>
    <script>
      var map;
      var lng;
      var lat;
      var cnt;
      function initAutocomplete() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat:  41.8818, lng: -87.6231},
          zoom: 13,
          mapTypeId: 'roadmap'
        });


        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];


          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));
            geocode(place.name);
            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
          // sendToPHP(lat,lng);
        });

      function geocode(name){
        axios.get('https://maps.googleapis.com/maps/api/geocode/json',{
            params:{
              address: name,
              key: 'AIzaSyB9MKvHqtXcdh5IRq7UwXlrP6Z0LC4lR1Q'
              }
            })
      .then(function(response){
          console.log(response);
          lat = response.data.results[0].geometry.location.lat;
          lng = response.data.results[0].geometry.location.lng;
               $.ajax({
                url: "server.php",
                type: 'GET',
                data: {"lat": lat, "lng": lng },
                cache: false,
                success: function(msg) {
                    cnt = msg;
                    var myCircle = new google.maps.Circle({
                      strokeColor: (cnt>2500? 'red' : 'green'),
                      strokeOpacity: 0.8,
                      strokeWeight: 2,
                      fillColor: (cnt>2500?'red' : 'green'),
                      fillOpacity: 0.35,
                      map: map,
                      center: new google.maps.LatLng(lat,lng),
                      radius : 800
                    });
                    console.log(cnt);}
            });
      })
      .catch(function(error){
      console.log(error);
      });
      }
    }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB9MKvHqtXcdh5IRq7UwXlrP6Z0LC4lR1Q&libraries=places&callback=initAutocomplete"
         async defer></script>
  </body>
  </html>
