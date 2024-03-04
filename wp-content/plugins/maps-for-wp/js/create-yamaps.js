/* v 1.1.4 (2018-06-03 12:17) */
jQuery(function($){$(document).ready( function() {
 console.log("Connect create-yamaps.js");
 
 if (typeof mfwp_setings_OnePoint !=="undefined"){
	// если есть массив настроек для одиночных карт
	console.table(mfwp_setings_OnePoint);
	ymaps.ready(init); /* ждем загрузки API Яндекс карт*/  
 }
 
 function init(){ 
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
	// если есть массив настроек для карт с множеством точек
	console.table(mfwp_setings_ManyPoints);
	ymaps.ready(initMany); /* ждем загрузки API Яндекс карт*/  
 }
 
 function initMany(){ 
  if ($("div").is(".mfwpMany")) {
	// если на найдены блоки для нескольких точек
	var countMany = $('.mfwpMany').length;
	console.log("Есть карта с несколькими точками. Всего их "+countMany);	
	for (var i =0; i < mfwp_setings_ManyPoints.length; i++) {
		setings_ManyPoints = mfwp_setings_ManyPoints[i];
		console.table(setings_ManyPoints);
		initializeMap_ManyPoints();
	}
  }  
 } 

 // построение одиночных карт
 function initializeMap_OnePoint() {
	var divId = "mfwp"+setings_OnePoint[0].mfwp_id;	
	var latitude = Number(setings_OnePoint[0].mfwp_lat);
	var longitude = Number(setings_OnePoint[0].mfwp_lon);
	var iconUrl = setings_OnePoint[0].iconImageHref; // картинка маркера
	var zoom = setings_OnePoint[0].mfwp_zoom;
	var TypeId = 'yandex#'+setings_OnePoint[0].mfwp_type; // слой карты
	var thover = setings_OnePoint[0].mfwp_thover;
	var tclick = setings_OnePoint[0].mfwp_tclick;
	
	console.log("ID блока карты "+divId+" lat="+latitude+" lon="+longitude);

	map = new ymaps.Map(divId, {
		center: [latitude, longitude],
		zoom: zoom,
		// элементы управления картой
		// список элементов можно посмотреть на этой странице
		// https://tech.yandex.ru/maps/doc/jsapi/2.1/dg/concepts/controls-docpage/
		controls: [
			'typeSelector', // переключатель отображаемого типа карты
			'zoomControl' // ползунок масштаба
		],
		/* Тип покрытия карты: 
		* схема - ('yandex#map'), 
		* спутник - ('yandex#satellite'),
		* гибрид - ('yandex#hybrid').
		*/
		type: TypeId
	});

	myPlacemark_OnePoint = new ymaps.Placemark([latitude, longitude], {
		hintContent: thover, // 'Тут расположен данный объект!',
		balloonContent: tclick //'Местоположение может быть указано не точно'
	}, {
		// Опции. Необходимо указать данный тип макета.
		iconLayout: 'default#image',
		// Своё изображение иконки метки.
		iconImageHref: iconUrl,//'/wp-content/plugins/realty-7/img/marker.png',
		// Размеры метки.
		iconImageSize: [36, 36],
		// Смещение левого верхнего угла иконки относительно её "ножки" (точки привязки).
		iconImageOffset: [-3, -42]
		});
		
	map.geoObjects.add(myPlacemark_OnePoint); // cтавим точку на карту
 } 
 
 // построение карт с множеством точек
 function initializeMap_ManyPoints() {
	var divId = "mfwpm"+setings_ManyPoints[0].mfwp_id;	
	var latitude = Number(setings_ManyPoints[0].mfwp_lat);
	var longitude = Number(setings_ManyPoints[0].mfwp_lon);
	var iconUrl = setings_ManyPoints[0].iconImageHref; // картинка маркера
	var zoom = setings_ManyPoints[0].mfwp_zoom;
	var TypeId = 'yandex#'+setings_ManyPoints[0].mfwp_type; // слой карты
	
	console.log("ID блока карты "+divId+" lat="+latitude+" lon="+longitude);

	map = new ymaps.Map(divId, {
		center: [latitude, longitude],
		zoom: zoom,
		// элементы управления картой
		// список элементов можно посмотреть на этой странице
		// https://tech.yandex.ru/maps/doc/jsapi/2.1/dg/concepts/controls-docpage/
		controls: [
			'typeSelector', // переключатель отображаемого типа карты
			'zoomControl' // ползунок масштаба
		],
		/* Тип покрытия карты: 
		* схема - ('yandex#map'), 
		* спутник - ('yandex#satellite'),
		* гибрид - ('yandex#hybrid').
		*/
		type: TypeId
	});	
	
	setings_ManyPoints[0].mfwp_pointsdate.forEach(function(index){	
	 myPlacemark_OnePoint = new ymaps.Placemark([index.lat, index.lon], {
		hintContent: index.thover, // 'текст при наведении',
		balloonContent: index.tclick //'текст при клике'
	 }, {
		// Опции. Необходимо указать данный тип макета.
		iconLayout: 'default#image',
		// Своё изображение иконки метки.
		iconImageHref: iconUrl,//'/wp-content/plugins//img/marker.png',
		// Размеры метки.
		iconImageSize: [36, 36],
		// Смещение левого верхнего угла иконки относительно её "ножки" (точки привязки).
		iconImageOffset: [-3, -42]
		});
		
	 map.geoObjects.add(myPlacemark_OnePoint); // cтавим точку на карту
	});
 }

})});