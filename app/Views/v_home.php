<div id="map" style="width: 100%; height: 800px;"></div>

<script>
    // 🔹 Provider peta sesuai struktur nama di layar tutor (peta1, peta2, dst)
    var peta1 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    });

    var peta2 = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { 
        attribution: 'Tiles © Esri' 
    });

    var peta3 = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', { 
        attribution: '© Carto' 
    });

    var peta4 = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', { 
        attribution: '© Carto' 
    });

    // 🔹 Inisialisasi Map (Sekarang sudah murni menggunakan data dari tbl_setting)
    var map = L.map('map', {
        center: [<?= $web['coordinat_wilayah'] ?>], // Mengambil '-7.2778279, 109.0188789' dari database
        zoom: <?= $web['zoom_view'] ?>, // Mengambil angka 12 dari database
        layers: [peta2] 
    });

    // 🔹 Pengelompokan Layer Control Sesuai Teks Layar Tutor
    var baseMaps = {
        'OpenStreetMap': peta1,
        'Satellite': peta2,
        'Streets': peta3,
        'Night': peta4,
    };

    // 🔹 Memasukkan kontrol pilihan ke peta
    var layerControl = L.control.layers(baseMaps).addTo(map);

    <?php foreach (isset($wilayah) ? $wilayah : [] as $key => $value) { ?>
 L.geoJSON(<?= $value['geojson'] ?>, {
        style: function(feature) {
            return {
                color: '<?= $value['warna'] ?>',
                weight: 2,
                fillColor: '<?= $value['warna'] ?>',
                fillOpacity: 0.5
            };
        }
    }).addTo(map).bindPopup("<b><?= $value['nama_wilayah'] ?></b>");
<?php } ?>


</script>