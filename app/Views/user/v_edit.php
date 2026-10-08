<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Form Edit User</h3>
        </div>

        <?= form_open_multipart('admin/user/updatedata/' . $user['id_user']) ?>
        <div class="card-body">
            <div class="row">
                <!-- 🟢 Bagian Kiri: Form Input mengambil 8 kolom -->
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
                        <!-- Tips: Kosongkan default value password agar tidak menampilkan hash sha1 lama -->
                        <input type="password" name="password" class="form-control" placeholder="Isi jika ingin mengganti password">
                    </div>
                    <div class="form-group">
                        <label>Ganti Foto</label>
                        <input type="file" name="foto_user" class="form-control">
                    </div>
                </div>

                <!-- 🟢 Bagian Kanan: Preview Foto Lama mengambil 4 kolom -->
                <div class="col-sm-4 text-center">
                    <div class="form-group">
                        <label>Foto User Saat Ini</label><br>
                        <?php if (!empty($user['foto_user'])): ?>
                            <img src="<?= base_url('foto/' . $user['foto_user']) ?>" style="max-width: 100%; max-height: 230px;" class="img-thumbnail">
                        <?php else: ?>
                            <img src="<?= base_url('foto/default.jpg') ?>" style="max-width: 100%; max-height: 230px;" class="img-thumbnail">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-flat">Simpan Perubahan</button>
            <a href="<?= base_url('admin/user') ?>" class="btn btn-success btn-flat">Kembali</a>
        </div>
        <?= form_close() ?>
    </div>
</div>