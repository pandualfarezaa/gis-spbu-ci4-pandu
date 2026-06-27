<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title"><?= isset($judul) ? $judul : 'Dashboard' ?></h3>
        </div>
        <div class="card-body">
            
            <?php if (session()->getFlashdata('validation')): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> Gagal Menyimpan!</h5>
                    <?= \Config\Services::validation()->listErrors() ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('admin/spbu/insertdata') ?>" method="post" enctype="multipart/form-data">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Nama SPBU</label>
                            <input name="nama_spbu" value="<?= old('nama_spbu') ?>" class="form-control" placeholder="Nama SPBU" required>
                            <p class="text-danger">
                                <?= \Config\Services::validation()->getError('warna') ?>
                            </p>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Rest Area</label>
                            <input name="rest_area" value="<?= old('rest_area') ?>" class="form-control" placeholder="Ada / Tidak Ada">
                            <p class="text-danger">
                                <?= \Config\Services::validation()->getError('warna') ?>
                            </p>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="">--Pilih Status--</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                            <p class="text-danger">
                                <?= \Config\Services::validation()->getError('warna') ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                    <label>Jenis SPBU</label>
                    <select name="id_jenis" class="form-control select2" style="width: 100%;">
    <option value="">--Pilih Jenis SPBU--</option>
    <?php foreach ($jenis as $key => $value) { ?>
        <!-- 🟢 Sisi kiri memakai id_jenis, Sisi kanan/tulisan memakai jenis -->
        <option value="<?= $value['id_jenis'] ?>"><?= $value['jenis'] ?></option>
    <?php } ?>
</select>
                    <p class="text-danger">
                        <?= $validation->hasError('id_jenis') ? $validation->getError('id_jenis') : '' ?>
                    </p>
                </div>
            </div>

                <div class="form-group">
                    <label>Koordinat SPBU</label>
                    <div id="map" style="width: 100%; height: 500px;"></div>
                    <input name="koordinat" id="Koordinat" value="<?= old('koordinat') ?>" class="form-control" placeholder="Koordinat" readonly>
                    <p class="text-danger">
                        <?= \Config\Services::validation()->getError('warna') ?>
                    </p>
                </div>

                <div class="row">
                    <!-- Kolom 1: Provinsi -->
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Provinsi</label>
                            <!-- 🟢 Ditambahkan class select2bs4 agar terikat ke JavaScript -->
                            <select name="id_provinsi" id="id_provinsi" class="form-control select2" style="width: 100%;">
                                <option value="">--Pilih Provinsi--</option>
                                <?php foreach ($provinsi as $key => $value) { ?>
    <option value="<?= $value['id'] ?>"><?= $value['nama'] ?></option>
<?php } ?>
                            </select>
                            <p class="text-danger">
                                <?= $validation->hasError('id_provinsi') ? $validation->getError('id_provinsi') : '' ?>
                            </p>
                        </div> <!-- 🟢 Penutup div form-group yang tadi keliru -->
                    </div>

                    <!-- Kolom 2: Kabupaten -->
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kabupaten</label>
                            <select name="id_kabupaten" id="id_kabupaten" class="form-control select2bs4" style="width: 100%;">
                                <option value="">--Pilih Kabupaten--</option>
                            </select>
                            <p class="text-danger">
                                <?= $validation->hasError('id_kabupaten') ? $validation->getError('id_kabupaten') : '' ?>
                            </p>
                        </div>
                    </div>

                    <!-- Kolom 3: Kecamatan -->
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kecamatan</label>
                            <select name="id_kecamatan" id="id_kecamatan" class="form-control select2bs4" style="width: 100%;">
                                <option value="">--Pilih Kecamatan--</option>
                            </select>
                            <p class="text-danger">
                                <?= $validation->hasError('id_kecamatan') ? $validation->getError('id_kecamatan') : '' ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label>Alamat</label>
                            <input name="alamat" value="<?= old('alamat') ?>" placeholder="Alamat SPBU" class="form-control">
                            <p class="text-danger">
                                <?= $validation->hasError('alamat') ? $validation->getError('alamat') : '' ?>
                            </p>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Wilayah Administrasi</label>
                            <select name="id_wilayah" id="id_wilayah" class="form-control select2bs4">
                                <option value="">--Pilih Wilayah Administrasi--</option>
                            </select>
                            <p class="text-danger">
                                <?= $validation->hasError('id_wilayah') ? $validation->getError('id_wilayah') : '' ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Foto SPBU</label>
                    <input type="file" accept=".jpg" name="foto" value="<?= old('foto') ?>" class="form-control">
                    <p class="text-danger">
                        <?= $validation->hasError('foto') ? $validation->getError('foto') : '' ?>
                    </p>
                </div>

                <button class="btn btn-primary btn-flat" type="submit">Simpan</button>
                <a class="btn btn-success btn-flat" href="<?= base_url('admin/spbu') ?>">Kembali</a>

            </form>

        </div>
    </div>
</div>

<!-- 🟢 Script Select2 yang sudah diperbaiki kurung dan syntax error-nya -->
<script>
  $(document).ready(function() {
    $('.select2').select2();
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    });

    // 1. Saat Provinsi dipilih
    $('#id_provinsi').change(function() {
        var id_provinsi = $('#id_provinsi').val();
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/spbu/kabupaten') ?>",
            data: { id_provinsi: id_provinsi },
            success: function(response) {
                $('#id_kabupaten').html(response);
                $('#id_kecamatan').html('<option value="">--Pilih Kecamatan--</option>');
                $('#id_wilayah').html('<option value="">--Pilih Wilayah Administrasi--</option>'); // Reset wilayah
            }
        });
    });

    // 2. Saat Kabupaten dipilih -> Mengisi Kecamatan DAN Wilayah Administrasi sekaligus
    $('#id_kabupaten').change(function() {
        var id_kabupaten = $('#id_kabupaten').val();
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/spbu/kecamatan') ?>",
            data: { id_kabupaten: id_kabupaten },
            success: function(response) {
                // 🟢 Memisah hasil response dari controller berdasarkan pembatas
                var hasil = response.split("||SPLIT_DISINI||");
                
                // Hasil belahan pertama (indeks 0) masuk ke Dropdown Kecamatan
                $('#id_kecamatan').html(hasil[0]);
                
                // Hasil belahan kedua (indeks 1) masuk ke Dropdown Wilayah Administrasi
                $('#id_wilayah').html(hasil[1]);
            }
        });
    });

  });

</script>

<script>
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

    var map = L.map('map', {
        center: [<?= $web['coordinat_wilayah'] ?>], 
        zoom: 10, 
        layers: [peta2] 
    });

    var baseMaps = {
        'OpenStreetMap': peta1,
        'Satellite': peta2,
        'Streets': peta3,
        'Night': peta4,
    };

    var layerControl = L.control.layers(baseMaps).addTo(map);

    var coordinatInput = document.querySelector("[name=koordinat]");

    var curLocation = [<?= $web['coordinat_wilayah'] ?>];
    map.attributionControl.setPrefix(false);
    var marker = new L.marker(curLocation, {
        draggable: 'true'
    });
    
    marker.on('dragend', function(e) {
        var position = marker.getLatLng();
        marker.setLatLng(position, {
            draggable: 'true'
        }).bindPopup(position).update();
        $("#Koordinat").val(position.lat + "," + position.lng);
    });

    map.on("click", function(e) {
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;
        if (!marker) {
            marker = L.marker(e.latlng).addTo(map);
        } else {
            marker.setLatLng(e.latlng);
        }
        coordinatInput.value = lat + "," + lng;
    });
    map.addLayer(marker);
</script>