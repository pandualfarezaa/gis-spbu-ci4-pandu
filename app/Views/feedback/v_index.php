<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title"><?= isset($judul) ? $judul : 'Feedback' ?></h3>
        </div>
        <div class="card-body">
            <?php 
            if (session()->getFlashdata('pesan')) {
                echo '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-check"></i> ' . session()->getFlashdata('pesan') . '</h5></div>';
            }
            ?>

            <table id="example2" class="table table-sm table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                        <th width="50px">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Pesan</th>
                        <th>Tipe</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th width="150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no = 1;
                foreach (isset($feedback) ? $feedback : [] as $key => $value) { ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= esc($value['nama']) ?></td>
                    <td><?= esc($value['email'] ?? '-') ?></td>
                    <td><?= esc($value['pesan']) ?></td>
                    <td class="text-center"><?= esc($value['tipe'] ?? '-') ?></td>
                    <td class="text-center">
                        <?php if (($value['status'] ?? '') === 'tampil'): ?>
                            <span class="badge badge-success">Tampil</span>
                        <?php else: ?>
                            <span class="badge badge-secondary">Sembunyi</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center"><?= $value['created_at'] ?? '-' ?></td>
                    <td class="text-center">
                        <?php if (($value['status'] ?? '') === 'tampil'): ?>
                            <a href="<?= base_url('admin/feedback/sembunyikan/' . $value['id_feedback']) ?>" class="btn btn-xs btn-secondary btn-flat" title="Sembunyikan"><i class="fas fa-eye-slash"></i></a>
                        <?php else: ?>
                            <a href="<?= base_url('admin/feedback/tampilkan/' . $value['id_feedback']) ?>" class="btn btn-xs btn-success btn-flat" title="Tampilkan"><i class="fas fa-eye"></i></a>
                        <?php endif; ?>
                        <a href="<?= base_url('admin/feedback/hapus/' . $value['id_feedback']) ?>" class="btn btn-xs btn-danger btn-flat" onclick="return confirm('Yakin hapus feedback ini?')" title="Hapus"><i class="fas fa-trash"></i></a>
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
