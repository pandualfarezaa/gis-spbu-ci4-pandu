 <div class="col-md-12">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title"><?= isset($judul) ? $judul : 'Dashboard' ?></h3>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
            <?php 
            session();
            $validation = session()->getFlashdata('validation');
            ?>
           <form action="<?= base_url('wilayah/simpan') ?>" method="post">

             <div class="row">
                 <div class="col-sm-6">
                    <div class="form-group">
                    <label>Nama Wilayah</label>
                    <input name="nama_wilayah" value="<?= old('nama_wilayah') ?>" class="form-control" placeholder="Nama Wilayah">
                    <p class="text-danger">
                    <?= $validation ? $validation->getError('nama_wilayah') : '' ?>
                    </p>
                 </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label>Warna Wilayah</label>
                    <input name="warna" value="<?= old('warna') ?>"class="form-control my-colorpicker1" placeholder="Warna Wilayah">
                     <p class="text-danger">
                    <?= $validation ? $validation->getError('warna') : '' ?>
                    </p>
                </div>
            </div>
        </div>

                <div class="form-group">
                    <label>GeoJSON</label>
                    <textarea name="geojson" value="<?= old('geojson') ?>" class="form-control" rows="15" placeholder="GeoJSON"></textarea>
                     <p class="text-danger">
                    <?= $validation ? $validation->getError('geojson') : '' ?>
                    </p>
                </div>

                <button class="btn btn-primary btn-flat" type="submit">Simpan</button>
                <a class="btn btn-success btn-flat" href="<?= base_url('admin/wilayah') ?>">Kembali</a>

            </form>

             </div>
         </div>
    </div>


    <script>
    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()
    </script>