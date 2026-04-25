        <div class="col-md-12">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title"><?= $judul ?></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                
                <?php 
                if (session()->getFlashdata('pesan')) {
                    echo '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-check"></i>';
                    echo session()->getFlashdata('pesan');
                    echo '</h5></div>';
                }
                
                ?>

                <?php echo form_open('admin/update-setting') ?>



                    <div class="row">
                         <div class="col-sm-7">
                            <div class="form-group">
                            <label>Nama SPBU</label>
                            <input name="nama_spbu" value="<?= $spbu['nama_spbu'] ?>" class="form-control" placeholder="Nama SPBU">
                         </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Coordinat Wilayah</label>
                            <input name="coordinat_wilayah" value="<?= $spbu['coordinat_wilayah'] ?>"  class="form-control" placeholder="Coordinat Wilayah">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Zoom View</label>
                            <input type="number" value="<?= $spbu['zoom_view'] ?>"  name="zoom_view" min="0" max="20" class="form-control" placeholder="Coordinat Wilayah">
                        </div>
                    </div>
                </div>


                <button class="btn btn-primary" type="submit">Simpan</button>

                

                <?php echo form_close() ?>
              </div>
              <!-- /.card-body -->
            </div>
         <!-- /.card -->
          </div>


<div class="col-md-12">
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
        center: [<?= $spbu['coordinat_wilayah'] ?>],
        zoom: <?= $spbu['zoom_view'] ?>,
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


</script>