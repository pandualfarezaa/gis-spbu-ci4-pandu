<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title"><?= $judul ?></h3>
        </div>
        <div class="card-body">
            <?php 
            if (session()->getFlashdata('insert')) {
                echo '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-check"></i> ' . session()->getFlashdata('insert') . '</h5></div>';
            }

            if (session()->getFlashdata('update')) {
                echo '<div class="alert alert-info alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-info"></i> ' . session()->getFlashdata('update') . '</h5></div>';
            }
            ?>
            
            <table id="example2" class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                        <th width="50px">No</th>
                        <th>Jenis SPBU</th>
                        <th>Marker</th>
                        <th width="100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $no = 1;
                foreach ($jenisSpbu as $key => $value) { 
                ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= $value['jenis'] ?></td>
                    <td class="text-center">
                        <img src="<?= base_url('marker/' . trim($value['marker'])) ?>" width="40px">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-warning btn-flat" data-toggle="modal" data-target="#edit<?= $value['id_jenis'] ?>">
                            <i class="fas fa-map-marker-alt"></i> Ganti Marker
                        </button>
                    </td>
                </tr>
                <?php } ?>  
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php foreach ($jenisSpbu as $key => $value) { ?>
<div class="modal fade" id="edit<?= $value['id_jenis'] ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ganti Marker <?= $value['jenis'] ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <?php echo form_open_multipart('admin/jenis_spbu/updatedata/' . $value['id_jenis']) ?>
            
            <div class="modal-body">
                <div class="form-group">
                    <label>Upload Marker</label>
                    <input type="file" name="marker" class="form-control" accept="image/png" required>
                </div>
            </div>
            
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-flat">Simpan</button>
            </div>
            
            <?php echo form_close() ?>
            
        </div>
        </div>
    </div>
<?php } ?>