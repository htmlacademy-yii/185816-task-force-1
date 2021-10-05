'use strict';

if(document.querySelector('#map')) {
  var myMap;
// Дождёмся загрузки API и готовности DOM.

  var map = document.querySelector('#map');
  var coordOne = map.getAttribute('data-one');
  var coordTwo = map.getAttribute('data-two');
  var address = document.querySelector('#address').textContent;

  ymaps.ready(function () {
    init(coordOne, coordTwo)

    myMap.geoObjects.add(new ymaps.Placemark([coordOne, coordTwo], {
        balloonContent: address
      },
      {
        preset: 'islands#blueCircleDotIconWithCaption',
        iconCaptionMaxWidth: '50'
      }));
  });

  function init(coordOne, coordTwo) {
    // Создание экземпляра карты и его привязка к контейнеру с
    // заданным id ("map").
    myMap = new ymaps.Map('map', {
      center: [coordOne, coordTwo], // Центр карты
      zoom: 13
    }, {
      searchControlProvider: 'yandex#search'
    });
  }
}
