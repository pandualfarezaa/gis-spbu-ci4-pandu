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

            <form action="<?= base_url('admin/wilayah/simpan') ?>" method="post">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Nama Wilayah</label>
                            <input name="nama_wilayah" value="<?= old('nama_wilayah') ?>" class="form-control" placeholder="Nama Wilayah" required>
                            <p class="text-danger">
                                <?= \Config\Services::validation()->getError('nama_wilayah') ?>
                            </p>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Warna Wilayah</label>
                            <input name="warna" value="<?= old('warna') ?>" class="form-control my-colorpicker1" placeholder="Warna Wilayah" required>
                            <p class="text-danger">
                                <?= \Config\Services::validation()->getError('warna') ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>GeoJSON</label>
                    <textarea name="geojson" class="form-control" rows="15" placeholder="GeoJSON" required><?= old('geojson') ?></textarea>
                    <p class="text-danger">
                        <?= \Config\Services::validation()->getError('geojson') ?>
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