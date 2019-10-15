var GetMap = function(mapDiv, options){
    var _map;
    var _markers =[];
    var _marker;
    var trafficLayer;
    var _polylines = [];
    var _infoWindow = new google.maps.InfoWindow();
    var _bounds = new google.maps.LatLngBounds();
    var _geocoder = new google.maps.Geocoder;
    var _markerClusters=[];
    var _zoomtmr = null;
    var _dragtmr = null;
    var _streetViewService = new google.maps.StreetViewService();
    var _options = {
        mapDiv : mapDiv,
        mapOptions: {
              center:{lat: 39.0757883, lng: -84.17496540000002},
              zoom:options.zoom,
              minZoom:options.minZoom,
              heading: 90,
              tilt: 45,
              fullscreenControl:false,
              fullscreenControlOptions: {
                  position: google.maps.ControlPosition.RIGHT_BOTTOM
              },
              mapTypeControl:options.satelite,
              mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.DEFAULT,
                    position: google.maps.ControlPosition.TOP_RIGHT
              },
              zoomControl: true,
                zoomControlOptions: {
                  position: google.maps.ControlPosition.RIGHT_TOP
              },
              streetViewControl: options.street_view,
              streetViewControlOptions: {
                  position: google.maps.ControlPosition.RIGHT_BOTTOM
              }
        }
    };

    if (options) {
        _LoadOptions(options);
        this.options = _options.mapOptions;
     }

    function _Init(_options){
        _map = new google.maps.Map(document.getElementById(_options.mapDiv));

        _map.setOptions(_options.mapOptions);

        if(_options.mapOptions.sitetype=='web')
            {
                // _map.controls[google.maps.ControlPosition.RIGHT_TOP].push(document.getElementById('store_info_modal'));
                // _map.controls[google.maps.ControlPosition.RIGHT_CENTER].push(document.getElementById('change_language'));
                // _map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(document.getElementById('traffic_icon'));
            }else{
                _map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(document.getElementById('traffic_icon'));
            }

        if(_options.mapOptions.callback != undefined)
        {
            google.maps.event.addListenerOnce(_map, 'idle', function(){

                if(typeof _options.mapOptions.callback == 'function')
                    _options.mapOptions.callback.call();
            });

        }
        if(_options.mapOptions.dragend)
        {
            google.maps.event.addListener(_map, 'dragend', function(){
                  if(activeZoom){
                    if(typeof _markers[3] !=='undefined' &&  _markers[3].length == 0)
                        getMoreRecords();
              }
            });
        }
        if(_options.mapOptions.change_zoom)
        {
            google.maps.event.addListener(_map, 'zoom_changed', function(){


                if(activeZoom){
                    if(_map.getZoom() < 16 && typeof _markers[3] !=='undefined' && _markers[3].length == 0)
                        getMoreRecords();
              }

            });
        }
        if(_options.mapOptions.Geolocation)
            _Geolocation(_options.mapOptions.Geolocation);

        if(_options.mapOptions.AutoComplete)
            _AutoComplete(_options.mapOptions.AutoComplete);

        if(_options.mapOptions.legend)
            {
                var legend = document.getElementById(_options.mapOptions.legend);
                console.log("legend-------------",legend)
                _map.controls[google.maps.ControlPosition.TOP_LEFT].push(legend);

            }
     }

    function _LoadOptions(options) {
        for (optionName in options) {
            _options.mapOptions[optionName] = options[optionName];
        }
        if(options.initMap)
            _Init(_options);
    }

    function _GetStreetView(latlng, radius, divname){
     _streetViewService.getPanorama({location: latlng, radius: radius}, function(data, status){
         if(status === 'OK')
             {
                 $('#'+divname).css('min-height','400px');
                 var panorama = new google.maps.StreetViewPanorama(document.getElementById(divname));
                 panorama.setPano(data.location.pano);
                  panorama.setPov({
                    heading: 270,
                    pitch: 0
                  });
                  panorama.setVisible(true);
             }
         else {
          $('#'+divname).css('min-height','0px').html('<h2>'+lang_json.no_streetview_msg+'</h2>');
        }
     });
  }

    function _Geolocation(options){
            if (navigator.geolocation) {

                navigator.geolocation.getCurrentPosition(function(position) {

                    $('#'+options.SetAddress).html('Getting your locations');

                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    if(options.MapCenter)
                        _map.setCenter(pos);
                    if(options.callback != undefined && typeof options.callback == 'function' ){
                        var a = new Array({lat: position.coords.latitude, lng: position.coords.longitude});
                             options.callback.apply(null,a);
                    }
                }, function(position) {
                        getJson(defualt_latlng);
                });
            } else {
                console.log('Failed');
            }
        }

    function _geocodeLatLng() {

        var arr = arguments;
        var latlng = {lat: arr[0], lng: arr[1]};

        $.ajax({
              url: "core_functions/geocode.php?q="+arr[0]+','+arr[1],
              context: document.body
            }).done(function(data) {

              var res = JSON.parse(data);

             if (res.status === google.maps.GeocoderStatus.OK) {
                if (res.results[0]) {

                    $('#'+arr[2]).html(res.results[1].formatted_address);

                    var a = new Array({ adress:res.results[0].formatted_address, lat: arr[0], lng: arr[1] ,results: res.results[0]});

                    if(arr[3] != undefined && typeof arr[3] == 'function' )
                        arr[3].apply(null,a);
                } else {
                    window.alert('No results found');
                }
            } else {
                window.alert('Geocoder failed due to: ' + status);
            }

        });

    }

    function _createSingleMarker(data){
        var m = new google.maps.Marker(data);
        m.setMap(_map);

        if(data.onclick){
            google.maps.event.addDomListener(m, 'click', (function(e) {

               if(typeof data.onclick =='function')
                   data.onclick.call(null,this);
            }));
        }
        if(data.mouseover){

            google.maps.event.addDomListener(m, 'mouseover', (function(e) {
                  if(this.infowindowContent != undefined && this.infowindowContent != ''){
                   _infoWindow.setPosition(this.position);
                   _infoWindow.setContent(this.infowindowContent);
                   _infoWindow.open(_map, this);
                }
                if(typeof data.mouseover =='function')
                   data.mouseover.call(null,this);
            }));
        }
        if(data.mouseout){

            google.maps.event.addDomListener(m, 'mouseout', (function(e) {
               if(this.infowindowContent != undefined ){
                 _infoWindow.close();
                }
               if(typeof data.mouseout =='function')
                   data.mouseout.call(null,this);
            }));
        }
        return m;
    }

     function _clearMarkers(i,clearCluster){
       var temp = _markers[i];
        _markers[i] =[];
       if(temp != undefined){
           var len = temp.length;
          if(_markerClusters[i] && clearCluster ==1){
               _markerClusters[i].clearMarkers();
           }
           for(var j = 0 ; j < len; j++)
               temp[j].setMap(null);
       }
   }

    function _createPolyline(data)
    {
        var poly = new google.maps.Polyline(data);
        poly.data = data;
        poly.setMap(_map);
        return poly;
    }

    function _clearPolylines(i){
        var temp = _polylines[i];
		 _polylines[i] =[];
        if(temp != undefined){
            var len = temp.length;
         for(var j = 0 ; j < len; j++)
               temp[j].setMap(null);
        }
    }

    function _AutoComplete(options){

        var input = document.getElementById(options.input);

        var autocomplete = new google.maps.places.Autocomplete(input);
        if(options.country){

           autocomplete.setComponentRestrictions({'country': [options.country]});
        }

        if(options.sessionToken){

           autocomplete.setOptions({'sessionToken':options.sessionToken});
        }

        autocomplete.bindTo('bounds', _map);

        autocomplete.setFields(['address_components','formatted_address', 'geometry', 'name', 'place_id']);

        autocomplete.addListener('place_changed', function() {
            var autoval = $.trim($("#autoComplete").val().toLowerCase());

            // if(autoval!= LocatorData.esteregg_edit || autoval != LocatorData.esteregg_new){
            //         getGeoCode();
            //     }
            //  else{
              console.log("options.callback first",autocomplete.getPlace())
                    var place = autocomplete.getPlace();
                   if(place.geometry != undefined){

                    if(options.callback != undefined && typeof options.callback == 'function' )
                       options.callback.call(null,place);
                     console.log("options.callback",options.callback)

                  // }
             }
        });

    }

    function _trafficLayer(dataval){
       if(dataval=='off')
           {
            trafficLayer = new google.maps.TrafficLayer();
            trafficLayer.setMap(_map);
           }
        else{
            trafficLayer.setMap(null);
        }
    }

    function _panBy(x, y) {
        _map.panBy(x, y);
    }

    function _getBounds()
    {
       return _map.getBounds();
    }

    this.getMap = function(){
        return _map;
    }

    this.initMap = function(){
        _Init(_options);
    }

    this.setOptions = function(option){
        _map.setOptions(option);
    }

    this.createMarker = function(data){
        var marker = '';

		var i = arguments[1] || 0;

			if(typeof(_markers[i]) == 'undefined'){
				_markers[i] =[];
				}

        if(data.length == undefined)
        {

          marker = _createSingleMarker(data);

		 _markers[i].push(marker);}
        else
        {

		for(var j =0; j<data.length; j++){
                if(data[j] != undefined)
                   {
                    var m =  _createSingleMarker(data[j]);
				   _markers[i].push(m);
				   }
            }
        }
        return marker;
    }

    this.clearAllMarkers = function(index,mc){
         _clearMarkers(index,mc);
    }

    this.getMarkers = function(index){
        return _markers[index];
    }

    this.createPolyline = function(data,i){
        var poly = _createPolyline(data);
        _polylines[i].push(poly);
        return poly;
    }

    this.clearAllPolylines = function(index){
         _clearPolylines(index);
    }

    this.GetBounds = function(){
        return _getBounds();
    }

    this.SetMarkersBounds = function(index){
        if(_markers[index].length>0){
        _bounds =null;
        _bounds = new google.maps.LatLngBounds();

        for(var j = 0 ; j< _markers[index].length;j++){
            _bounds.extend(_markers[index][j].getPosition());
        }
		    _map.fitBounds(_bounds);
       }
    }

    this.setpolylineBounds = function(i,index){
        if(_polylines[index].length>0){
        _bounds =null;
        _bounds = new google.maps.LatLngBounds();
        var points =_polylines[index][i].getPath().getArray();

        for(var j = 0 ; j< points.length;j++)
            _bounds.extend(points[j]);
       _map.fitBounds(_bounds);
       }
    }

    this.GetGeoLocation = function(options){
        _Geolocation(options);
    }

    this.getMarkersBykey = function(key,value,index){
		 var markers;
		 var len = _markers[index].length;
		 for(var i =0; i <len; i++){
			if(_markers[index][i][key]==value)
			 markers = _markers[index][i];
		 }
		 return markers;
    }

    this.GetStreetView = function(latlng, radius, divname){
        _GetStreetView(latlng, radius, divname);
    }

    this.FilterMarkers = function(allPoints,type, val,mc,index){
        var temp = allPoints;
        var len = temp.length;
        if(typeof(_markers[index]) != 'undefined')
        {_clearMarkers(index,1);
          }
        else
            _markers[index] =[];
         for(var i =0; i< len;i++){
            if(typeof(temp[i]) != 'undefined')
                {
                 if(temp[i][type]==val)
                   {
                    var m = _createSingleMarker(temp[i]);
                   _markers[index].push(m);
                   }
                }
        }
  }

    this.setCustombounds=function(arr){
       if(arr.length>0){
        _bounds =null;
        _bounds = new google.maps.LatLngBounds();

        for(var j = 0 ; j< arr.length;j++){
            _bounds.extend(arr[j].getPosition());
        }
		_map.fitBounds(_bounds);

        if(_map.getZoom()>8)
            _map.setZoom(_map.getZoom()-1);
       }
   }

    this.setMarkerCluster = function(index,mcOptions){
        _markerClusters[index] = new MarkerClusterer(_map, _markers[index], mcOptions);
    }

    this.mapResize=function(){
      google.maps.event.trigger(_map, 'resize');
   }

   this.getCenter = function() {
     return _map.getCenter();
 }

  this.getZoom = function() {
     return _map.getZoom();
 }

   this.trafficLayer=function(dataval){
       _trafficLayer(dataval);
   }

   this.panby = function(x, y) {
       _panBy(x, y);
   }
}
