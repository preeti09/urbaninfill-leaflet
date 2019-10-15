@extends('master')
@section('title','Detail Information')
@section('content')
<div class="card">
	<div class="col-6">
    <button id="delete-button" class="btn btn-primary">delete-button</button>
        <div class="map" id="map"></div>

        </div>
    </div>
@endsection

@section('script')
<script src=" {{ url('/js/MapLibrary.js') }}"></script>
<script>
/*initMap();
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 24.886, lng: -70.269},
          zoom: 5,
        });

        var triangleCoords = [
          {lat: 25.774, lng: -80.19},
          {lat: 18.466, lng: -66.118},
          {lat: 32.321, lng: -64.757}
        ];

        var bermudaTriangle = new google.maps.Polygon({paths: triangleCoords});

        google.maps.event.addListener(map, 'click', function(e) {
            console.log(e.latLng);
          var resultColor =
              google.maps.geometry.poly.containsLocation(e.latLng, bermudaTriangle) ?
              'blue' :
              'red';

          var resultPath =
              google.maps.geometry.poly.containsLocation(e.latLng, bermudaTriangle) ?
              // A triangle.
              "m 0 -1 l 1 2 -2 0 z" :
              google.maps.SymbolPath.CIRCLE;

          new google.maps.Marker({
            position: e.latLng,
            map: map,
            icon: {
              path: resultPath,
              fillColor: resultColor,
              fillOpacity: .2,
              strokeColor: 'white',
              strokeWeight: .5,
              scale: 10
            }
          });
        });
      }*/

var drawingManager;
var all_overlays = [];
var selectedShape;
var colors = ['#1E90FF', '#FF1493', '#32CD32', '#FF8C00', '#4B0082'];
var selectedColor;
var colorButtons = {};

function clearSelection() {
  if (selectedShape) {
    selectedShape.setEditable(false);
    selectedShape = null;
  }
}

function setSelection(shape) {
  clearSelection();
  selectedShape = shape;
  shape.setEditable(true);
  selectColor(shape.get('fillColor') || shape.get('strokeColor'));
}

function deleteSelectedShape() {
  if (selectedShape) {
    selectedShape.setMap(null);
  }
}

function deleteAllShape() {
  for (var i = 0; i < all_overlays.length; i++) {
    all_overlays[i].overlay.setMap(null);
  }
  all_overlays = [];
}

function selectColor(color) {
  selectedColor = color;
  for (var i = 0; i < colors.length; ++i) {
    var currColor = colors[i];
    colorButtons[currColor].style.border = currColor == color ? '2px solid #789' : '2px solid #fff';
  }

  // Retrieves the current options from the drawing manager and replaces the
  // stroke or fill color as appropriate.
  var polylineOptions = drawingManager.get('polylineOptions');
  polylineOptions.strokeColor = color;
  drawingManager.set('polylineOptions', polylineOptions);

  var rectangleOptions = drawingManager.get('rectangleOptions');
  rectangleOptions.fillColor = color;
  drawingManager.set('rectangleOptions', rectangleOptions);

  var circleOptions = drawingManager.get('circleOptions');
  circleOptions.fillColor = color;
  drawingManager.set('circleOptions', circleOptions);

  var polygonOptions = drawingManager.get('polygonOptions');
  polygonOptions.fillColor = color;
  drawingManager.set('polygonOptions', polygonOptions);
}




function initialize() {
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 10,
    center: new google.maps.LatLng(22.344, 114.048),
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    disableDefaultUI: true,
    zoomControl: true
  });

  var polyOptions = {
    strokeWeight: 0,
    fillOpacity: 0.45,
    editable: true
  };
  // Creates a drawing manager attached to the map that allows the user to draw
  // markers, lines, and shapes.
  drawingManager = new google.maps.drawing.DrawingManager({
    drawingMode: google.maps.drawing.OverlayType.POLYGON,
    markerOptions: {
      draggable: true
    },
    polylineOptions: {
      editable: true
    },
    rectangleOptions: polyOptions,
    circleOptions: polyOptions,
    polygonOptions: polyOptions,
    map: map
  });

  google.maps.event.addListener(drawingManager, 'overlaycomplete', function(e) {
    all_overlays.push(e);
    if (e.type != google.maps.drawing.OverlayType.MARKER) {
      // Switch back to non-drawing mode after drawing a shape.
      drawingManager.setDrawingMode(null);

      // Add an event listener that selects the newly-drawn shape when the user
      // mouses down on it.
      var newShape = e.overlay;
      newShape.type = e.type;
      google.maps.event.addListener(newShape, 'click', function() {
        setSelection(newShape);
      });
      setSelection(newShape);
    }
  });

  // Clear the current selection when the drawing mode is changed, or when the
  // map is clicked.
  google.maps.event.addListener(drawingManager, 'drawingmode_changed', clearSelection);
  google.maps.event.addListener(map, 'click', clearSelection);
  google.maps.event.addDomListener(document.getElementById('delete-button'), 'click', deleteSelectedShape);
  google.maps.event.addDomListener(document.getElementById('delete-all-button'), 'click', deleteAllShape);

  buildColorPalette();
}
google.maps.event.addDomListener(window, 'load', initialize);

/*var map;
var elevator;
var polygonArray = [];
var myOptions = {
    zoom: 9,
    center: new google.maps.LatLng("{{$lat}}","{{$long}}")
};

map = new google.maps.Map($('#map')[0], myOptions);  

marker;
    //console.log(locations);

    marker = new google.maps.Marker({
        position: new google.maps.LatLng("{{$lat}}", "{{$long}}"),
        map: map,
        animation: google.maps.Animation.DROP
    });

    var drawingManager = new google.maps.drawing.DrawingManager({
      drawingControl: true,
      drawingControlOptions: {
        position: google.maps.ControlPosition.TOP_CENTER,
        drawingModes: ['circle', 'polygon', 'polyline', 'rectangle','marker']
      },
      
      circleOptions: {
        fillColor: '#ffff00',
        fillOpacity: 1,
        strokeWeight: 5,
        clickable: false,
        editable: true,
        zIndex: 1
      }
    });
drawingManager.setMap(map);

google.maps.event.addListener(drawingManager, 'polygoncomplete', function(polygon) {
    // console.log(polygon);
        for (var i = 0; i < polygon.getPath().getLength(); i++) {
           polygonArray[i]= polygon.getPath().getAt(i).toUrlValue(6) ;
           console.log("LatLong "+[i]+": "+polygonArray[i]);
           // 
        }
        polygonArray.push(polygon);
    
});

google.maps.event.addListener(drawingManager, 'circlecomplete', function(circle) {
  var radius = circle.getRadius();
  console.log(circle.getCenter());
});
google.maps.event.addListener(drawingManager, 'markercomplete', function(marker) {
  
  console.log(marker.getPosition());
});
google.maps.event.addListener(drawingManager, 'polylinecomplete', function(line) {
  
  console.log(line.getPath());
});
google.maps.event.addListener(drawingManager, 'rectanglecomplete', function(rectangle) {
  
  console.log(rectangle);
});*/

// console.log(polygonArray);
/*<?php foreach($polys as $key => $polygun){  if($key === 0){ ?>
    
$.ajax({
    url:"/getGeoKey",
    type:"get",
    data :{geoId:"{{$polygun->geo_key}}"},
    success:function(res){
        var wkts = [
            res
        ];

        //function to add points from individual rings
        var addPoints = function(ptsArray, data){
            //first spilt the string into individual points
            var pointsData=data.split(",");
            
            
            //iterate over each points data and create a latlong
            //& add it to the cords array
            var len=pointsData.length;
            for (var i=0;i<len;i++)
            {
                 var xy=pointsData[i].split(" ");

                var pt=new google.maps.LatLng(xy[1],xy[0]);
                ptsArray.push(pt);
            }


        }

        var createPoly = function(wkt) {
            //using regex, we will get the indivudal Rings
            var regex = /\(([^()]+)\)/g;
            var Rings = [];
            var results;
            while( results = regex.exec(wkt) ) {
                Rings.push( results[1] );
            }
            
            var ptsArray=[];
            
            var polyLen=Rings.length;
            
            //now we need to draw the polygon for each of inner rings, but reversed
            for(var i=0;i<polyLen;i++){
                addPoints(ptsArray, Rings[i]);
            }
            
            var poly = new google.maps.Polygon({
                paths: ptsArray,
                strokeColor: 'red',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: 'red',
                fillOpacity: 0.35
              });
            return poly;
        };
              
        // console.log("Creating polygons from wkts: %o: ", wkts);

            var wkt = wkts ;
            // console.log("Creating polygon from wkt: %o: ", wkt);
            var poly = createPoly(wkt);
            poly.setMap(map);
    }
})
<?php } } ?>*/


</script>
@endsection