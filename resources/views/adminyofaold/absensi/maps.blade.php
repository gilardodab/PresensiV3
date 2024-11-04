<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://npmcdn.com/leaflet@0.7.7/dist/leaflet.js"></script>
</head>
<body>
    <div id="peta" style="height:500px; width: 100%"></div>
    <script type="text/javascript">
        var mymap = L.map('peta').setView([{{ $latitude }}, {{ $longitude }}], 13);
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1Ijoid2lkb2RvMTk5MSIsImEiOiJja3AzcG5zYW0xamVnMm9xaWNnamI1ODRpIn0.wr-0_-8cP9KfDPiesVdoPw', {
            maxZoom: 18,
            attribution: '',
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: 'pk.eyJ1IjoiZmF1emF5eXkiLCJhIjoiY2tqZng3OWw5MDlmejJ0cW9vbWg1bXlvMCJ9.zn3d3ptHQ38xKp4yM_55SQ'
        }).addTo(mymap);
        L.marker([{{ $latitude }}, {{ $longitude }}]).addTo(mymap);
        L.circle([{{ $latitude }}, {{ $longitude }}], 550, {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5
        }).addTo(mymap).bindPopup("{{ $name }}").openPopup();

        function onMapClick(e) {
            L.popup()
                .setLatLng(e.latlng)
                .setContent("" + e.latlng.toString())
                .openOn(mymap);
        }

        mymap.on('click', onMapClick);
    </script>
</body>
</html>
