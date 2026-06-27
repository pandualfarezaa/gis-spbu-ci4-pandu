<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title"><?= isset($judul) ? $judul : 'Data User' ?></h3>
            <div class="card-tools">
                <!-- 🟢 TOMBOL LINK BERSIH UNTUK PINDAH HALAMAN -->
                <a href="<?= base_url('admin/user/input') ?>" class="btn btn-flat btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah
                </a>
            </div>
        </div>
        
        <div class="card-body">
            <?php 
            if (session()->getFlashdata('insert')) {
                echo '<div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h5><i class="icon fas fa-check"></i>' . session()->getFlashdata('insert') . '</h5></div>';
            }
            ?>
            
            <table class="table table-sm table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                        <th width="50px">No</th>
                        <th>Nama User</th>
                        <th>E-mail</th>
                        <th>Password (SHA-1)</th>
                        <th width="100px">Foto</th>
                        <th width="100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no = 1; foreach (isset($user) ? $user : [] as $key => $value) { ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= $value['nama_user'] ?></td>
                    <td><?= $value['email'] ?></td>
                    <td><small class="text-muted"><?= $value['password'] ?></small></td>
                   <td class="text-center">
    <!-- 🟢 Diubah dari 'foto user' menjadi 'foto_user' -->
    <img src="<?= base_url('foto/' . $value['foto_user']) ?>" width="50px" height="50px" class="img-circle">
</td>
                    <td class="text-center">
    <!-- Tombol Edit -->
    <a href="<?= base_url('admin/user/edit/' . $value['id_user']) ?>" class="btn btn-xs btn-warning btn-flat">
        <i class="fas fa-pencil-alt"></i>
    </a>
    <!-- Tombol Hapus -->
    <a href="<?= base_url('admin/user/hapus/' . $value['id_user']) ?>" class="btn btn-xs btn-danger btn-flat" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
        <i class="fas fa-trash"></i>
    </a>
</td>
                </tr>
                <?php } ?>  
                </tbody>
            </table>
        </div>
    </div>
</div>