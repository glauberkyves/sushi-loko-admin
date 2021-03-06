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

    $.getJSON('/franqueador/localidade', function(pontos) {

        var latlngbounds = new google.maps.LatLngBounds();

        $.each(pontos, function(index, ponto) {

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(ponto.noLatitude, ponto.noLongitude),
                title: ""
            });

            var myOptions = {
                content: ponto.noPessoa
                ,disableAutoPan: false
                ,maxWidth: 0
                ,pixelOffset: new google.maps.Size(-140, 0)
                ,zIndex: null
                ,closeBoxMargin: "10px 2px 2px 2px"
                ,closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif"
                ,infoBoxClearance: new google.maps.Size(1, 1)
                ,isHidden: false
                ,pane: "floatPane"
                ,enableEventPropagation: false
            };

            infoBox[ponto.idUsuario] = new InfoBox(myOptions);
            infoBox[ponto.idUsuario].marker = marker;

            infoBox[ponto.idUsuario].listener = google.maps.event.addListener(marker, 'click', function (e) {
                //abrirInfoBox(ponto.idUsuario, marker);
            });

            markers.push(marker);

            latlngbounds.extend(marker.position);
        });

        var markerCluster = new MarkerClusterer(map, markers);

        map.fitBounds(latlngbounds);

    });
}

carregarPontos();