 <div class="col-md-12">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title"><?= isset($judul) ? $judul : 'Dashboard' ?></h3>

                <div class="card-tools">
                  <a href="<?= base_url('admin/wilayah/input') ?>" class="btn btn-flat btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah
                  </a>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?php 
                //notif insert data
                if (session()->getFlashdata('insert')) {
                    echo '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-check"></i>';
                    echo session()->getFlashdata('insert');
                    echo '</h5></div>';
                }

                 //notif update data
                if (session()->getFlashdata('update')) {
                    echo '<div class="alert alert-info alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-info"></i>';
                    echo session()->getFlashdata('update');
                    echo '</h5></div>';
                }
                ?>
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr class="text-center">
                                <td width="50px">No</td>
                                <td>Nama Wilayah</td>
                                <td>Warna</td>
                                <td width="100px">Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no = 1;
                        foreach (isset($wilayah) ? $wilayah : [] as $key => $value) { ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= $value['nama_wilayah'] ?></td>
                            <td style="background-color: <?= $value['warna'] ?>;">&nbsp;</td>
                            <td class="text-center">
                              <a href="<?= base_url('admin/wilayah/edit/' . $value['id_wilayah']) ?>" class="btn btn-sm btn-warning btn-flat">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a href="<?= base_url('admin/wilayah/delete/' . $value['id_wilayah']) ?>" class="btn btn-sm btn-danger btn-flat" onclick="return confirm('Yakin hapus?')">
                                <i class="fas fa-trash"></i>
                            </a>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>  
                        </tbody>
                    </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

<div class="col-sm-12">
    <div id="map" style="width: 100%; height: 800px;"></div>
</div>

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
        center: [<?= isset($spbu['coordinat_wilayah']) ? explode(',', $spbu['coordinat_wilayah'])[0] : 0 ?>, <?= isset($spbu['coordinat_wilayah']) ? explode(',', $spbu['coordinat_wilayah'])[1] : 0 ?>],
        zoom: <?= isset($spbu['zoom_view']) ? $spbu['zoom_view'] : 10 ?>,
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
<script>
  $(function() {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>