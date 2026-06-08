        <!-- Begin Page Content -->
        <div class="container-fluid">

          <div class="page-header-row">
            <div class="page-header">
              <h1 class="h3"><?= $title; ?></h1>
              <p class="page-subtitle">Kelola akun petugas dan admin</p>
            </div>
          </div>

          <?= validation_errors('<div class="alert alert-danger premium-alert alert-dismissible fade show" role="alert">','<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>') ?>
          <?= $this->session->flashdata('msg'); ?>

          <div class="row">
            <div class="col-lg-6 mb-4">
              <div class="card dashboard-card">
                <div class="card-header">
                  <h6><i class="fas fa-user-plus"></i> Tambah Petugas</h6>
                </div>
                <div class="card-body">
                  <?= form_open('Admin/PetugasController', 'class="premium-form"'); ?>
                    <div class="form-group">
                      <label for="nama">Nama</label>
                      <input type="text" class="form-control" id="nama" name="nama" value="<?= set_value('nama') ?>" placeholder="Masukkan nama">
                    </div>
                    <div class="form-group">
                      <label for="username">Username</label>
                      <input type="text" class="form-control" id="username" name="username" value="<?= set_value('username') ?>" placeholder="Masukkan username">
                    </div>
                    <div class="form-group">
                      <label for="password">Password</label>
                      <input type="password" class="form-control" id="password" name="password" placeholder="Min. 6 karakter">
                    </div>
                    <div class="form-group">
                      <label for="telp">No. Telepon</label>
                      <input type="text" class="form-control" id="telp" name="telp" value="<?= set_value('telp') ?>" placeholder="Masukkan nomor telepon">
                    </div>
                    <div class="form-group">
                      <label>Level</label>
                      <div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="level" id="admin" value="admin">
                          <label class="form-check-label" for="admin">Admin</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="level" id="petugas" value="petugas" checked="">
                          <label class="form-check-label" for="petugas">Petugas</label>
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn-submit">
                      <i class="fas fa-save"></i> Simpan
                    </button>
                  <?= form_close(); ?>
                </div>
              </div>
            </div>

            <div class="col-lg-6 mb-4">
              <div class="card dashboard-card">
                <div class="card-header">
                  <h6><i class="fas fa-users"></i> Data Petugas</h6>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="premium-table mb-0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nama</th>
                          <th>Telp</th>
                          <th>Level</th>
                          <th class="text-center">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($data_petugas as $dp) : ?>
                          <tr>
                            <td class="fw-bold"><?= $no++; ?></td>
                            <td><?= htmlspecialchars($dp['nama_petugas'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= htmlspecialchars($dp['telp'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                              <?php if ($dp['level'] == 'admin') : ?>
                                <span class="badge-status" style="background: #e0e7ff; color: #4338ca; border-color: #c7d2fe;">Admin</span>
                              <?php else : ?>
                                <span class="badge-status" style="background: #f1f5f9; color: #475569; border-color: #e2e8f0;">Petugas</span>
                              <?php endif; ?>
                            </td>
                            <td class="text-center">
                              <?php if ($dp['username'] == $this->session->userdata('username')) : ?>
                                <small class="text-muted">Akun Anda</small>
                              <?php else : ?>
                                <div class="table-action justify-content-center">
                                  <a href="<?= base_url('Admin/PetugasController/edit/'.$dp['id_petugas']) ?>" class="premium-btn premium-btn-info premium-btn-sm">
                                    <i class="fas fa-edit"></i>
                                  </a>
                                  <?= form_open('Admin/PetugasController/delete/'.$dp['id_petugas']); ?>
                                    <button type="submit" class="premium-btn premium-btn-warning premium-btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus petugas ini?')">
                                      <i class="fas fa-trash"></i>
                                    </button>
                                  <?= form_close(); ?>
                                </div>
                              <?php endif; ?>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      <!-- End of Main Content -->