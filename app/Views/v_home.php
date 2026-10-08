<!-- Tampilan Peta Penuh dengan Aksen Biru Pertamina -->
<div class="col-md-12">
    <div class="card card-outline shadow-sm" style="border-top: 4px solid #0054A6 !important;">
        <div class="card-body p-0">
            <div id="map" style="width: 100%; height: 600px;"></div>
        </div>
    </div>
</div>

<style>
/* Efek "menyala" pada kecamatan yang sedang difilter */
.wilayah-glow {
    animation: wilayah-pulse 1.6s ease-in-out infinite;
    pointer-events: none;
}
@keyframes wilayah-pulse {
    0%   { opacity: 0.55; }
    50%  { opacity: 0.15; }
    100% { opacity: 0.55; }
}
@media (prefers-reduced-motion: reduce) {
    .wilayah-glow { animation: none; opacity: 0.3; }
}
</style>

<script>
    var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    });

    var satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles © Esri'
    });

    var street = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '© Carto'
    });

    var map = L.map('map', {
        center: [<?= $web['coordinat_wilayah'] ?>],
        zoom: <?= $web['zoom_view'] ?>,
        layers: [osm]
    });

    var baseMaps = {
        "OSM": osm,
        "Satellite": satellite,
        "Street": street
    };
    L.control.layers(baseMaps).addTo(map);

    // 🔵 Referensi tiap layer wilayah & marker SPBU, dipakai oleh fungsi filter di bawah
    var wilayahLayers  = {};   // { id_wilayah: { polygon, warnaAsli, geo } }
    var spbuMarkers    = [];   // [{ marker, id_wilayah }]
    var glowLayerGroup = L.layerGroup().addTo(map); // wadah efek glow biar gampang dibersihkan/diganti

    // Menampilkan Wilayah
    <?php foreach ($wilayah as $key => $value) { ?>
        (function () {
            var geo       = JSON.parse(<?= json_encode($value['geojson']) ?>);
            var warnaAsli = '<?= $value['warna'] ?>';
            var idWilayah = '<?= $value['id_wilayah'] ?>';

            var poligon_wilayah = L.geoJSON(geo, {
                style: {
                    color: warnaAsli,
                    weight: 2,
                    opacity: 0.7,
                    fillColor: warnaAsli,
                    fillOpacity: 0.15
                }
            }).addTo(map);

            poligon_wilayah.bindPopup("<h5>Kecamatan <?= $value['nama_wilayah'] ?></h5>");

            wilayahLayers[idWilayah] = {
                polygon: poligon_wilayah,
                warnaAsli: warnaAsli,
                geo: geo
            };
        })();
    <?php } ?>

    // Menampilkan SPBU
    <?php foreach ($spbu as $key => $value) {
        if (!empty($value['lokasi'])) {
            $koordinat = explode(',', $value['lokasi']);
            $lat = trim($koordinat[0]);
            $lng = trim($koordinat[1]);
    ?>
        (function () {
            var iconSpbu = L.icon({
                iconUrl: '<?= base_url('marker/' . ($value['marker'] ?? 'default.png')) ?>',
                iconSize: [32, 42],
                iconAnchor: [16, 42],
                popupAnchor: [0, -40]
            });

            var marker = L.marker([<?= $lat ?>, <?= $lng ?>], {
                icon: iconSpbu
            }).addTo(map);

            var isiPopup = `
                <div class='text-center' style='min-width: 180px;'>
                    <img src='<?= base_url('foto/' . ($value['foto'] ?? 'default.jpg')) ?>' width='100%' class='rounded mb-2' style='max-height: 120px; object-fit: cover;'>
                    <h5 class='font-weight-bold mb-1' style='color: #333;'><?= $value['nama_spbu'] ?></h5>
                    <p class='text-muted small mb-2'><?= $value['alamat'] ?></p>
                    <a href='<?= base_url('home/detail/' . ($value['id_spbu'] ?? '')) ?>' class='btn btn-xs btn-block text-white font-weight-bold' style='background-color: #0054A6; border-radius: 4px; padding: 4px 0;'>Detail Asset</a>
                </div>
            `;
            marker.bindPopup(isiPopup);

            // ⚠️ Sesuaikan key 'id_wilayah' berikut dengan nama kolom relasi SPBU -> Wilayah pada tabel data kamu
            spbuMarkers.push({
                marker: marker,
                id_wilayah: '<?= $value['id_wilayah'] ?? '' ?>'
            });
        })();
    <?php
        }
    }
    ?>

    // 🔵 FITUR FILTER: menyalakan 1 kecamatan + marker SPBU di dalamnya.
    // Generik untuk semua kecamatan — cukup panggil filterWilayah(id_wilayah).
    function filterWilayah(idWilayah) {
        glowLayerGroup.clearLayers(); // bersihkan efek glow kecamatan sebelumnya

        Object.keys(wilayahLayers).forEach(function (id) {
            var data = wilayahLayers[id];

            if (!idWilayah) {
                // "Semua Wilayah" -> kembalikan tampilan normal
                data.polygon.setStyle({
                    color: data.warnaAsli,
                    weight: 2,
                    opacity: 0.7,
                    fillColor: data.warnaAsli,
                    fillOpacity: 0.15
                });
            } else if (id === idWilayah) {
                // Kecamatan terpilih -> "menyala"
                data.polygon.setStyle({
                    color: data.warnaAsli,
                    weight: 4,
                    opacity: 1,
                    fillColor: data.warnaAsli,
                    fillOpacity: 0.35
                });
                data.polygon.bringToFront();

                var glow = L.geoJSON(data.geo, {
                    className: 'wilayah-glow',
                    style: {
                        color: data.warnaAsli,
                        weight: 10,
                        opacity: 0.5,
                        fill: false
                    }
                });
                glowLayerGroup.addLayer(glow);
            } else {
                // Kecamatan lain -> disembunyikan total (tanpa warna & tanpa garis)
                data.polygon.setStyle({
                    opacity: 0,
                    fillOpacity: 0
                });
            }
        });

        // Tampilkan hanya marker SPBU milik kecamatan terpilih (semua marker jika tanpa filter)
        spbuMarkers.forEach(function (item) {
            var cocok = !idWilayah || item.id_wilayah === idWilayah;
            if (cocok) {
                if (!map.hasLayer(item.marker)) map.addLayer(item.marker);
            } else {
                if (map.hasLayer(item.marker)) map.removeLayer(item.marker);
            }
        });

        // Zoom otomatis ke kecamatan terpilih, atau kembali ke tampilan awal jika "Semua Wilayah"
        if (idWilayah && wilayahLayers[idWilayah]) {
            map.fitBounds(wilayahLayers[idWilayah].polygon.getBounds(), { padding: [30, 30] });
        } else {
            map.setView([<?= $web['coordinat_wilayah'] ?>], <?= $web['zoom_view'] ?>);
        }
    }

    // 🔵 Deteksi otomatis dari URL saat tombol "Wilayah" di navbar diklik.
    // Link menu itu mengarah ke .../home/wilayah/<id_wilayah>, jadi id-nya
    // diambil langsung dari alamat URL — tidak perlu tombol/dropdown baru.
    function getWilayahIdFromUrl() {
        var parts = window.location.pathname.split('/').filter(Boolean);
        var idx = parts.indexOf('wilayah');
        if (idx !== -1 && parts[idx + 1]) {
            return parts[idx + 1];
        }
        return '';
    }

    var idWilayahAktif = <?php echo !empty($wilayah_terpilih) ? "'".$wilayah_terpilih."'" : 'getWilayahIdFromUrl()'; ?>;
    filterWilayah(idWilayahAktif);
</script>