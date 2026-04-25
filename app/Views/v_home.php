<div id="map" style="width: 100%; height: 800px;"></div>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    // 🔹 OSM (Default)
    var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    });

    // 🔹 Satellite (ESRI)
    var satellite = L.tileLayer(
        'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
        { attribution: 'Tiles © Esri' }
    );

    // 🔹 Street (Carto Light - beda dari OSM)
    var street = L.tileLayer(
        'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',
        { attribution: '© Carto' }
    );

    // 🔹 Night / Dark Mode
    var night = L.tileLayer(
        'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png',
        { attribution: '© Carto' }
    );

    // 🔹 Init Map
    var map = L.map('map', {
        center: [-7.261740816260255, 109.01797393820488],
        zoom: 12,
        layers: [osm] // default
    });

    // 🔹 Layer Control
    var baseMaps = {
        "OSM": osm,
        "Satellite": satellite,
        "Street": street,
        "Night": night
    };

    L.control.layers(baseMaps).addTo(map);

    // 🔹 Marker contoh
    L.marker([-7.261740816260255, 109.01797393820488])
        .addTo(map)
        .bindPopup("Lokasi Awal")
        .openPopup();
</script>



