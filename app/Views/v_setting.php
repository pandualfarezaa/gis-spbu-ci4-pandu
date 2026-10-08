<!-- 1. CDN LEAFLET CSS & JS (Wajib ada agar peta muncul) -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<?php if (!isset($judul)) { $judul = 'Pengaturan'; } ?>
<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title"><?=$judul?></h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            
            <?php 
            if (!isset($spbu)) {
                $spbu = [
                    'nama_spbu' => '',
                    'coordinat_wilayah' => '0,0',
                    'zoom_view' => 13,
                ];
            }
            if (session()->getFlashdata('pesan')) {
                echo '<div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h5><i class="icon fas fa-check"></i> ' . session()->getFlashdata('pesan') . '</h5></div>';
            }
            ?>

            <?php echo form_open('admin/update-setting') ?>

            <div class="row">
                <div class="col-sm-7">
                    <div class="form-group">
                        <label>Nama SPBU</label>
                        <input name="nama_spbu" value="<?= $spbu['nama_spbu'] ?>" class="form-control" placeholder="Nama SPBU" required>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Coordinat Wilayah</label>
                        <input id="coordinat_wilayah" name="coordinat_wilayah" value="<?= $spbu['coordinat_wilayah'] ?>" class="form-control" placeholder="Contoh: -7.2567129, 109.0065193" required>
                        <small class="text-muted">Bisa diketik manual atau klik pada peta untuk mengisi otomatis.</small>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Zoom View</label>
                        <input type="number" id="zoom_view" value="<?= $spbu['zoom_view'] ?>" name="zoom_view" min="0" max="20" class="form-control" placeholder="Zoom" required>
                    </div>
                </div>
            </div>

            <button class="btn btn-primary" type="submit">Simpan</button>

            <?php echo form_close() ?>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="card card-outline card-info">
        <div class="card-body">
            <div id="map" style="width: 100%; height: 500px; z-index: 1;"></div>
        </div>
    </div>
</div>

<script>
    // 🔹 Base Layers (Basemaps)
    var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    });

    var satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { 
        attribution: 'Tiles © Esri' 
    });

    var street = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', { 
        attribution: '© Carto' 
    });

    var night = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', { 
        attribution: '© Carto' 
    });

    // 🟢 SINKRONISASI AMAN UNTUK FORMAT KOORDINAT STRING
    var dbCoords = "<?= $spbu['coordinat_wilayah'] ?>";
    var centerCoords = [-7.26453, 109.01241]; // Default Jatisawit Bumiayu jika database kosong
    var zoomInitial = <?= !empty($spbu['zoom_view']) ? $spbu['zoom_view'] : 12 ?>;

    if (dbCoords) {
        var splitCoords = dbCoords.split(',');
        if (splitCoords.length === 2) {
            var latArr = parseFloat(splitCoords[0].trim());
            var lngArr = parseFloat(splitCoords[1].trim());
            if (!isNaN(latArr) && !isNaN(lngArr) && latArr !== 0 && lngArr !== 0) {
                centerCoords = [latArr, lngArr];
            }
        }
    }

    // 🔹 Inisialisasi Peta
    var map = L.map('map', {
        center: centerCoords,
        zoom: zoomInitial,
        layers: [osm]
    });

    // Memaksa Leaflet menggambar ulang ukuran container peta agar render sempurna
    setTimeout(function() {
        map.invalidateSize();
    }, 300);

    var baseMaps = {
        "OSM": osm,
        "Satellite": satellite,
        "Street": street,
        "Night": night
    };
    L.control.layers(baseMaps).addTo(map);

    // 🟢 Marker Utama (Bisa digeser/draggable)
    var marker = L.marker(centerCoords, {
        draggable: true
    }).addTo(map);

    // 🟢 Fitur 1: Saat Peta Diklik (Pindahkan Marker & Isi Form Koordinat)
    map.on('click', function(e) {
        var lat = e.latlng.lat.toFixed(7);
        var lng = e.latlng.lng.toFixed(7);
        
        marker.setLatLng(e.latlng);
        document.getElementById('coordinat_wilayah').value = lat + ", " + lng;
    });

    // 🟢 Fitur 2: Saat Marker Digeser (Otomatis Perbarui Form Koordinat)
    marker.on('dragend', function(e) {
        var lat = marker.getLatLng().lat.toFixed(7);
        var lng = marker.getLatLng().lng.toFixed(7);
        document.getElementById('coordinat_wilayah').value = lat + ", " + lng;
    });

    // 🟢 Fitur 3: Saat Input DIKETIK MANUAL
    document.getElementById('coordinat_wilayah').addEventListener('change', function() {
        var nilaiInput = this.value.split(',');
        if (nilaiInput.length === 2) {
            var lat = parseFloat(nilaiInput[0].trim());
            var lng = parseFloat(nilaiInput[1].trim());
            
            if (!isNaN(lat) && !isNaN(lng)) {
                var lokasiBaru = [lat, lng];
                marker.setLatLng(lokasiBaru);
                map.setView(lokasiBaru, map.getZoom());
            }
        }
    });

    // 🟢 Fitur 4: Saat Zoom Peta Berubah
    map.on('zoomend', function() {
        document.getElementById('zoom_view').value = map.getZoom();
    });
</script>