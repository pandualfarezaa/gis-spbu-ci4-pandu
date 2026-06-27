<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title"><?= isset($judul) ? $judul : 'Dashboard' ?></h3>

            <div class="card-tools">
                <a href="<?= base_url('admin/spbu/input') ?>" class="btn btn-flat btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah
                </a>
            </div>
        </div>
        
        <div class="card-body">
            <?php 
            // Notif insert data
            if (session()->getFlashdata('insert')) {
                echo '<div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h5><i class="icon fas fa-check"></i>' . session()->getFlashdata('insert') . '</h5></div>';
            }

            // Notif update data
            if (session()->getFlashdata('update')) {
                echo '<div class="alert alert-info alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h5><i class="icon fas fa-info"></i>' . session()->getFlashdata('update') . '</h5></div>';
            }
            ?>
            
            <table id="example2" class="table table-sm table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                        <td width="50px">No</td>
                        <td>Nama SPBU</td>
                        <!-- 🟢 TAMBAHAN KOLOM JUDUL BARU -->
                        <td>Jenis SPBU</td>
                        <td>Status</td>
                        <td>Rest Area</td>
                        <td>Alamat</td>
                        <td width="100px">Foto</td>
                        <td width="100px">Aksi</td>
                    </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                foreach (isset($spbu) ? $spbu : [] as $key => $value) { ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= $value['nama_spbu'] ?></td>
                    <!-- 🟢 TAMBAHAN ISI KOLOM JENIS SPBU -->
                    <td class="text-center"><?= isset($value['jenis']) ? $value['jenis'] : '-' ?></td>
                    <td class="text-center"><?= $value['status'] ?></td>
                    <td class="text-center"><?= $value['rest_area'] ?></td>
                    <td><?= $value['alamat'] ?></td>
                    <td class="text-center">
                        <img src="<?= base_url('foto/' . $value['foto']) ?>" width="150px" height="100px">
                    </td>
                    <td class="text-center">
                        <a href="<?= base_url('admin/spbu/detail/' . $value['id_spbu']) ?>" class="btn btn-xs btn-success btn-flat">
    <i class="fas fa-eye"></i>
</a>
                        <a href="<?= base_url('admin/spbu/edit/' . $value['id_spbu']) ?>" class="btn btn-xs btn-warning btn-flat"><i class="fas fa-pencil-alt"></i></a>
                        <a href="<?= base_url('admin/spbu/delete/' . $value['id_spbu']) ?>" class="btn btn-xs btn-danger btn-flat" onclick="return confirm('Yakin hapus?')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php } ?>  
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
  $(function() {
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