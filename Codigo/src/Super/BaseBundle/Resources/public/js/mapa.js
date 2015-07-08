var map;
var idInfoBoxAberto;
var infoBox = [];
var markers = [];

function initialize() {
    var latlng = new google.maps.LatLng(-18.8800397, -47.05878999999999);

    var options = {
        zoom: 5,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById("mapa"), options);
}

initialize();

function abrirInfoBox(id, marker) {
    if (typeof(idInfoBoxAberto) == 'number' && typeof(infoBox[idInfoBoxAberto]) == 'object') {
        infoBox[idInfoBoxAberto].close();
    }

    infoBox[id].open(map, marker);
    idInfoBoxAberto = id;
}

function carregarPontos() {

    $.getJSON('/super/franquia/localidade', function(pontos) {

        var latlngbounds = new google.maps.LatLngBounds();

        $.each(pontos, function(index, ponto) {

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(ponto.noLatitude, ponto.noLongitude),
                title: "Meu ponto personalizado! :-D",
                icon: 'img/marcador.png'
            });

            var myOptions = {
                pixelOffset: new google.maps.Size(-150, 0)
            };

            infoBox[ponto.idFranqueador] = new InfoBox(myOptions);
            infoBox[ponto.idFranqueador].marker = marker;

            infoBox[ponto.idFranqueador].listener = google.maps.event.addListener(marker, 'click', function (e) {
                abrirInfoBox(ponto.idFranqueador, marker);
            });

            markers.push(marker);

            latlngbounds.extend(marker.position);

        });

        var markerCluster = new MarkerClusterer(map, markers);

        map.fitBounds(latlngbounds);

    });

}

carregarPontos();