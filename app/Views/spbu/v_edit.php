<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title"><?= isset($judul) ? $judul : 'Edit Data SPBU' ?></h3>
        </div>
        <div class="card-body">
            
            <?php if (session()->getFlashdata('validation')): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> Gagal Menyimpan Perubahan!</h5>
                    <?= \Config\Services::validation()->listErrors() ?>
                </div>
            <?php endif; ?>

            <!-- 🟢 Action diarahkan ke rute update data, dan sertakan enctype untuk foto -->
            <form action="<?= base_url('admin/spbu/updatedata/' . $spbu['id_spbu']) ?>" method="post" enctype="multipart/form-data">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Nama SPBU</label>
                            <input name="nama_spbu" value="<?= old('nama_spbu', $spbu['nama_spbu']) ?>" class="form-control" placeholder="Nama SPBU" required>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Jenis SPBU</label>
                            <select name="id_jenis" class="form-control select2" style="width: 100%;">
    <option value="">--Pilih Jenis SPBU--</option>
    <?php foreach ($jenis as $key => $value) { ?>
        <!-- 🟢 PERBAIKAN: Ganti $value['nama_jenis'] menjadi $value['jenis'] -->
        <option value="<?= $value['id_jenis'] ?>" <?= old('id_jenis', $spbu['id_jenis']) == $value['id_jenis'] ? 'selected' : '' ?>>
            <?= $value['jenis'] ?>
        </option>
    <?php } ?>
</select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Rest Area</label>
                            <input name="rest_area" value="<?= old('rest_area', $spbu['rest_area']) ?>" class="form-control" placeholder="Ada / Tidak Ada">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="">--Pilih Status--</option>
                                <option value="Aktif" <?= old('status', $spbu['status']) == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                                <option value="Tidak Aktif" <?= old('status', $spbu['status']) == 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Koordinat SPBU</label>
                    <div id="map" style="width: 100%; height: 500px;"></div>
                    <input name="koordinat" id="Koordinat" value="<?= old('koordinat', $spbu['lokasi']) ?>" class="form-control" placeholder="Koordinat" readonly>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Provinsi</label>
                            <select name="id_provinsi" id="id_provinsi" class="form-control select2" style="width: 100%;">
                                <option value="">--Pilih Provinsi--</option>
                                <?php foreach ($provinsi as $key => $value) { ?>
                                    <option value="<?= $value['id'] ?>" <?= old('id_provinsi', $spbu['id_provinsi']) == $value['id'] ? 'selected' : '' ?>><?= $value['nama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kabupaten</label>
                            <select name="id_kabupaten" id="id_kabupaten" class="form-control select2bs4" style="width: 100%;">
                                <option value="">--Pilih Kabupaten--</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Kecamatan</label>
                            <select name="id_kecamatan" id="id_kecamatan" class="form-control select2bs4" style="width: 100%;">
                                <option value="">--Pilih Kecamatan--</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label>Alamat</label>
                            <input name="alamat" value="<?= old('alamat', $spbu['alamat']) ?>" placeholder="Alamat SPBU" class="form-control">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Wilayah Administrasi</label>
                            <select name="id_wilayah" id="id_wilayah" class="form-control select2bs4">
                                <option value="">--Pilih Wilayah Administrasi--</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Ganti Foto SPBU (Biarkan kosong jika tidak diganti)</label>
                    <input type="file" accept=".jpg,.jpeg,.png" name="foto" class="form-control">
                    <br>
                    <img src="<?= base_url('foto/' . $spbu['foto']) ?>" width="150px" alt="Foto Lama">
                </div>

                <button class="btn btn-primary btn-flat" type="submit">Simpan Perubahan</button>
                <a class="btn btn-success btn-flat" href="<?= base_url('admin/spbu') ?>">Kembali</a>

            </form>

        </div>
    </div>
</div>

<!-- Script Berantai AJAX Dropdown -->
<script>
  $(document).ready(function() {
    $('.select2').select2();
    $('.select2bs4').select2({ theme: 'bootstrap4' });

    // AJAX untuk Load Kabupaten & Kecamatan bawaan saat pertama kali halaman Edit dimuat
    var id_prov_old = "<?= $spbu['id_provinsi'] ?>";
    var id_kab_old = "<?= $spbu['id_kabupaten'] ?>";
    var id_kec_old = "<?= $spbu['id_kecamatan'] ?>";
    var id_wil_old = "<?= $spbu['id_wilayah'] ?>";

    if(id_prov_old != "") {
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/spbu/kabupaten') ?>",
            data: { id_provinsi: id_prov_old },
            success: function(response) {
                $('#id_kabupaten').html(response).val(id_kab_old).trigger('change');
                
                // Load kecamatan setelah kabupaten terisi
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('admin/spbu/kecamatan') ?>",
                    data: { id_kabupaten: id_kab_old },
                    success: function(response_kec) {
                        var hasil = response_kec.split("||SPLIT_DISINI||");
                        $('#id_kecamatan').html(hasil[0]).val(id_kec_old).trigger('change');
                        $('#id_wilayah').html(hasil[1]).val(id_wil_old).trigger('change');
                    }
                });
            }
        });
    }

    // Event ketika Provinsi diubah manual oleh user
    $('#id_provinsi').change(function() {
        var id_provinsi = $('#id_provinsi').val();
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/spbu/kabupaten') ?>",
            data: { id_provinsi: id_provinsi },
            success: function(response) {
                $('#id_kabupaten').html(response);
                $('#id_kecamatan').html('<option value="">--Pilih Kecamatan--</option>');
                $('#id_wilayah').html('<option value="">--Pilih Wilayah Administrasi--</option>');
            }
        });
    });

    // Event ketika Kabupaten diubah manual oleh user
    $('#id_kabupaten').change(function() {
        var id_kabupaten = $('#id_kabupaten').val();
        if(id_kabupaten != "") {
            $.ajax({
                type: "POST",
                url: "<?= base_url('admin/spbu/kecamatan') ?>",
                data: { id_kabupaten: id_kabupaten },
                success: function(response) {
                    var hasil = response.split("||SPLIT_DISINI||");
                    $('#id_kecamatan').html(hasil[0]);
                    $('#id_wilayah').html(hasil[1]);
                }
            });
        }
    });
  });
</script>

<!-- Leaflet Map Script untuk Edit -->
<script>
    var peta2 = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { attribution: 'Tiles © Esri' });
    var map = L.map('map', {
        center: [<?= $spbu['lokasi'] ?>], 
        zoom: 15, 
        layers: [peta2] 
    });

    var coordinatInput = document.querySelector("[name=koordinat]");
    var curLocation = [<?= $spbu['lokasi'] ?>];
    
    map.attributionControl.setPrefix(false);
    var marker = new L.marker(curLocation, { draggable: 'true' }).addTo(map);
    
    marker.on('dragend', function(e) {
        var position = marker.getLatLng();
        marker.setLatLng(position, { draggable: 'true' }).bindPopup(position).update();
        $("#Koordinat").val(position.lat + "," + position.lng);
    });

    map.on("click", function(e) {
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;
        marker.setLatLng(e.latlng);
        coordinatInput.value = lat + "," + lng;
    });
</script>