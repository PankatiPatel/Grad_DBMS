
var i = 0;
var mapPoint = [];
function initialize() {

  
    // get jason.encode from php file using get attribute
    var xmlhttp = new XMLHttpRequest(); 
        xmlhttp.onload = function() { 
          if (this.readyState == 4 && this.status == 200) { 
        var dataSet = JSON.parse(this.responseText); 

            console.log(dataSet);
            
    var mapOptions = {
            zoom: 4,

            center: new google.maps.LatLng(39.521741, -96.848224),
            mapTypeId: google.maps.MapTypeId.ROADMAP
   };

   var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

   var infowindow = new google.maps.InfoWindow();

var markerIcon = {
  scaledSize: new google.maps.Size(80, 80),
  origin: new google.maps.Point(0, 0),
  anchor: new google.maps.Point(32,65),
  labelOrigin: new google.maps.Point(40,33)
};


 
    var location;
    var mySymbol;
    var marker, m;

    // put all the vendor infromation in an array 
    for(let i =0; i < dataSet.length; i++)
    {
        var row = [dataSet[i].vendor_id, dataSet[i].name, dataSet[i].latitude, dataSet[i].Longitude];
        mapPoint.push(row);
    }

    console.log(mapPoint);
     var MarkerLocations= mapPoint;

for (m = 0; m < MarkerLocations.length; m++) {

    location = new google.maps.LatLng(MarkerLocations[m][2], MarkerLocations[m][3]),
    marker = new google.maps.Marker({ 
  map: map, 
  position: location, 
  icon: markerIcon,	
  label: {
   text: MarkerLocations[m][0] ,
color: "black",
    fontSize: "16px",
    fontWeight: "bold"
  }
});

  google.maps.event.addListener(marker, 'click', (function(marker, m) {
    return function() {
      infowindow.setContent("Vendor Name: " + MarkerLocations[m][1]);
      infowindow.open(map, marker);
    }
  })(marker, m));
}
          }

        }
        xmlhttp.open("GET", "vendor_map.php", true); 
        xmlhttp.send();
}

google.maps.event.addDomListener(window, 'load', initialize);