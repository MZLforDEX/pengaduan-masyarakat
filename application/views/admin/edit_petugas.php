        <!-- Begin Page Content -->
        <div class="container-fluid">

          <div class="page-header-row">
            <div class="d-flex align-items-center" style="gap: 14px;">
              <a href="<?= base_url('Admin/PetugasController') ?>" class="back-link">
                <i class="fas fa-arrow-left"></i> Kembali
              </a>
              <div class="page-header" style="margin: 0;">
                <h1 class="h3"><?= $title; ?></h1>
              </div>
            </div>
          </div>

          <?= validation_errors('<div class="alert alert-danger premium-alert alert-dismissible fade show" role="alert">','<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>') ?>
          <?= $this->session->flashdata('msg'); ?>

          <div class="row">
            <div class="col-lg-6">
              <div class="card dashboard-card">
                <div class="card-header">
                  <h6><i class="fas fa-user-edit"></i> Edit Petugas</h6>
                </div>
                <div class="card-body">
                  <?= form_open('Admin/PetugasController/edit/'.$petugas['id_petugas'], 'class="premium-form"'); ?>
                    <div class="form-group">
                      <label for="nama">Nama</label>
                      <input type="text" class="form-control" id="nama" name="nama" value="<?= $petugas['nama_petugas'] ?>">
                    </div>
                    <div class="form-group">
                      <label for="telp">No. Telepon</label>
                      <input type="text" class="form-control" id="telp" name="telp" value="<?= $petugas['telp'] ?>">
                    </div>
                    <div class="form-group">
                      <label>Level</label>
                      <div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="level" id="admin" value="admin" <?= $petugas['level'] == 'admin' ? 'checked' : ''; ?>>
                          <label class="form-check-label" for="admin">Admin</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="level" id="petugas" value="petugas" <?= $petugas['level'] == 'petugas' ? 'checked' : ''; ?>>
                          <label class="form-check-label" for="petugas">Petugas</label>
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn-submit">
                      <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                  <?= form_close(); ?>
                </div>
              </div>
            </div>
          </div>

        </div>
      <!-- End of Main Content -->