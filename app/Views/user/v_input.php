<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title"><?= isset($judul) ? $judul : 'Input User' ?></h3>
        </div>
        
        <form action="<?= base_url('admin/user/insertdata') ?>" method="post" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group">
                    <label>Nama User</label>
                    <input type="text" name="nama_user" class="form-control" placeholder="Nama User" required>
                </div>
                <div class="form-group">
                    <label>E-Mail</label>
                    <input type="email" name="email" class="form-control" placeholder="E-Mail" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <label>Foto</label>
                    <input type="file" name="foto_user" class="form-control" accept="image/*" required>
                </div>
            </div>
            
            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-flat">Simpan</button>
                <a href="<?= base_url('admin/user') ?>" class="btn btn-success btn-flat">Kembali</a>
            </div>
        </form>
    </div>
</div>