<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Detail SPBU</h3>
            <div class="card-tools">
                <a href="<?= base_url('home') ?>" class="btn btn-flat btn-warning btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div id="map-detail" style="width: 100%; height: 400px; border-radius: 8px;"></div>
                </div>
                <div class="col-sm-6">
                    <div class="text-center mb-3">
                        <img src="<?= base_url('foto/' . ($spbu['foto'] ?? 'default.jpg')) ?>" class="img-fluid img-thumbnail" style="max-height: 250px; width: 100%; object-fit: cover;" alt="Foto SPBU">
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <tr><th>Nama SPBU</th><td><strong><?= esc($spbu['nama_spbu'] ?? '-') ?></strong></td></tr>
                        <tr><th>Jenis SPBU</th><td><?= esc($spbu['jenis'] ?? '-') ?></td></tr>
                        <tr><th>Status</th><td><?= esc($spbu['status'] ?? '-') ?></td></tr>
                        <tr><th>Rest Area</th><td><?= esc($spbu['rest_area'] ?? '-') ?></td></tr>
                        <tr><th>Koordinat</th><td><code><?= esc($spbu['lokasi'] ?? '-') ?></code></td></tr>
                        <tr><th>Alamat</th><td><?= esc($spbu['alamat'] ?? '-') ?></td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
window.addEventListener('load', function () {
    var map = L.map('map-detail').setView([<?= $spbu['lokasi'] ?>], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    L.marker([<?= $spbu['lokasi'] ?>]).addTo(map)
        .bindPopup(<?= json_encode('<b>' . esc($spbu['nama_spbu'] ?? '-') . '</b><br>' . esc($spbu['alamat'] ?? '-')) ?>)
        .openPopup();
});
</script>
