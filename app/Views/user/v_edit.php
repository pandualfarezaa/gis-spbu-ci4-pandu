<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Form Edit User</h3>
    </div>

    <?= form_open_multipart('admin/user/updatedata/' . $user['id_user']) ?>
    <div class="card-body">
        <div class="row">
            <!-- Bagian Form Input (8 Kolom) -->
            <div class="col-sm-8">
                <div class="form-group">
                    <label>Nama User</label>
                    <input type="text" name="nama_user" value="<?= $user['nama_user'] ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>E-Mail</label>
                    <input type="email" name="email" value="<?= $user['email'] ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="text" name="password" value="<?= $user['password'] ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Ganti Foto</label>
                    <!-- Atribut required sengaja dibuang agar ganti foto bersifat opsional -->
                    <input type="file" name="foto_user" class="form-control">
                </div>
            </div>

            <!-- Bagian Preview Foto Lama (4 Kolom) -->
            <div class="col-sm-4 text-center">
                <div class="form-group">
                    <label>Foto User</label><br>
                    <?php if (!empty($user['foto_user'])): ?>
                        <img src="<?= base_url('foto/' . $user['foto_user']) ?>" width="150px" class="img-thumbnail">
                    <?php else: ?>
                        <img src="<?= base_url('foto/default.jpg') ?>" width="150px" class="img-thumbnail">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= base_url('admin/user') ?>" class="btn btn-secondary">Kembali</a>
    </div>
    <?= form_close() ?>
</div>