<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title"><?= isset($judul) ? $judul : 'Detail SPBU' ?></h3>
            <div class="card-tools">
                <a href="<?= base_url('admin/spbu') ?>" class="btn btn-flat btn-warning btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        
        <div class="card-body">
            <div class="row">
                <!-- 🗺️ SISI KIRI: Peta Lokasi SPBU -->
                <div class="col-sm-6">
                    <div id="map" style="width: 100%; height: 400px; border-radius: 8px;"></div>
                </div>
                
                <!-- 📋 SISI KANAN: Foto & Informasi Detail -->
                <div class="col-sm-6">
                    <div class="text-center mb-3">
                        <img src="<?= base_url('foto/' . $spbu['foto']) ?>" class="img-fluid img-thumbnail" style="max-height: 250px; width: 100%; object-fit: cover;" alt="Foto SPBU">
                    </div>
                    
                    <table class="table table-bordered table-striped table-sm">
                        <tr>
                            <th width="180px">Nama SPBU</th>
                            <td><strong><?= $spbu['nama_spbu'] ?></strong></td>
                        </tr>
                        <tr>
                            <th>Jenis SPBU</th>
                            <td><span class="badge badge-primary"><?= isset($spbu['jenis']) ? $spbu['jenis'] : '-' ?></span></td>
                        </tr>
                        <tr>
                            <th>Status Operasional</th>
                            <td>
                                <span class="badge <?= $spbu['status'] == 'Aktif' ? 'badge-success' : 'badge-danger' ?>">
                                    <?= $spbu['status'] ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Fasilitas Rest Area</th>
                            <td><?= $spbu['rest_area'] ?></td>
                        </tr>
                        <tr>
                            <th>Koordinat</th>
                            <td><code class="text-danger"><?= $spbu['lokasi'] ?></code></td>
                        </tr>
                        <tr>
                            <th>Alamat Lengkap</th>
                            <td><?= $spbu['alamat'] ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 🟢 SCRIPT LEAFLET DETAIL MAP -->
<script>
    // 🟢 PERBAIKAN: Peta langsung berpusat pada lokasi SPBU ini dengan Zoom level 15
    var map = L.map('map').setView([<?= $spbu['lokasi'] ?>], 15);

    // Base Map (OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Buat Marker otomatis tepat di titik koordinat SPBU tersebut
    L.marker([<?= $spbu['lokasi'] ?>]).addTo(map)
        .bindPopup("<b><?= $spbu['nama_spbu'] ?></b><br><?= $spbu['alamat'] ?>")
        .openPopup();
</script>