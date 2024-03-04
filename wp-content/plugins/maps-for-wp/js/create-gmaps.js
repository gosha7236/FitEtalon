/* v 1.1.3 (2018-03-16 14:00) */
jQuery(function($){$(document).ready( function() {
 console.log("Connect create-gmaps.js");
 
 if (typeof mfwp_setings_OnePoint !=="undefined"){
  // если есть массив настроек для одиночных карт
  console.table(mfwp_setings_OnePoint); 
  if ($("div").is(".mfwpOne")) {
	// если на найдены блоки для нескольких точек
	var countOne = $('.mfwpOne').length;
	console.log("Есть карта с одной точкой. Всего их "+countOne);
	for (var i =0; i < mfwp_setings_OnePoint.length; i++) {
		setings_OnePoint = mfwp_setings_OnePoint[i];
		console.table(setings_OnePoint);
		initializeMap_OnePoint();
	}
  } 
 }
 
 if (typeof mfwp_setings_ManyPoints !=="undefined"){
	console.table(mfwp_setings_ManyPoints); 
	if ($("div").is(".mfwpMany")) {
		var countMany = $('.mfwpMany').length;
		console.log("Есть карта с несколькими точками. Всего их "+countMany);			
	}
	for (var i =0; i < mfwp_setings_ManyPoints.length; i++) {
		setings_ManyPoints = mfwp_setings_ManyPoints[i];
		console.table(setings_ManyPoints[i]);
		initializeMap_ManyPoint();
	}
 }
 
 // построение одиночных карт
 function initializeMap_OnePoint() {
	var divId = "mfwp"+setings_OnePoint[0].mfwp_id;	
	var latitude = Number(setings_OnePoint[0].mfwp_lat);
	var longitude = Number(setings_OnePoint[0].mfwp_lon);
	var iconUrl = setings_OnePoint[0].iconImageHref; // картинка маркера
	var zoom = setings_OnePoint[0].mfwp_zoom;
	var TypeId = setings_OnePoint[0].mfwp_type; // слой карты
	var thover = setings_OnePoint[0].mfwp_thover;
	var tclick = setings_OnePoint[0].mfwp_tclick;	
	
	console.log("ID блока карты "+divId+" lat="+latitude+" lon="+longitude);
	
	map = new google.maps.Map(document.getElementById(divId), {
		center: {lat: latitude, lng: longitude},
		zoom: zoom,
		mapTypeId: TypeId
	});
	var marker = new google.maps.Marker({
		position: {lat: latitude, lng: longitude},
		icon: iconUrl,
		map: map,
		title: thover
	});
	var infowindow = new google.maps.InfoWindow({
		content: tclick
	});
	marker.addListener('click', function() {
		infowindow.open(map, marker);
	});
 } 
 
 // построение карт с множеством точек
 function initializeMap_ManyPoint() {
	var divId = "mfwpm"+setings_ManyPoints[0].mfwp_id;	
	var latitude = Number(setings_ManyPoints[0].mfwp_lat);
	var longitude = Number(setings_ManyPoints[0].mfwp_lon);
	var iconUrl = setings_ManyPoints[0].iconImageHref; // картинка маркера
	var zoom = setings_ManyPoints[0].mfwp_zoom;
	var TypeId = setings_ManyPoints[0].mfwp_type; // слой карты
		
	console.log("ID блока карты "+divId+" lat="+latitude+" lon="+longitude);

	map = new google.maps.Map(document.getElementById(divId), {
		center: {lat: latitude, lng: longitude},
		zoom: zoom,
		mapTypeId: TypeId		
	});	
	
	// ставим точки
	setings_ManyPoints[0].mfwp_pointsdate.forEach(function(index){
		var marker = new google.maps.Marker({
			position: {lat: index.lat, lng: index.lon},
			icon: iconUrl,
			map: map,
			title: index.thover
		});
		var infowindow = new google.maps.InfoWindow({
			content: index.tclick
		});
		marker.addListener('click', function() {
			infowindow.open(map, marker);
		});
	});
 }
 
})});