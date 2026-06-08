        <!-- Begin Page Content -->
        <div class="container-fluid">

          <div class="page-header-row">
            <div class="d-flex align-items-center" style="gap: 14px;">
              <a href="<?= base_url('User/ProfileController') ?>" class="back-link">
                <i class="fas fa-arrow-left"></i> Kembali
              </a>
              <div class="page-header" style="margin: 0;">
                <h1 class="h3">Ganti Password</h1>
                <p class="page-subtitle">Perbarui password akun Anda</p>
              </div>
            </div>
          </div>

          <?= validation_errors('<div class="alert alert-danger premium-alert alert-dismissible fade show" role="alert">','<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>') ?>
          <?= $this->session->flashdata('msg'); ?>

          <div class="row">
            <div class="col-xl-6">
              <div class="card dashboard-card">
                <div class="card-header">
                  <h6><i class="fas fa-lock"></i> Ubah Password</h6>
                </div>
                <div class="card-body">
                  <?= form_open('Auth/ChangePasswordController', 'class="premium-form"'); ?>
                    <div class="form-group">
                      <label for="current_password">Password Saat Ini</label>
                      <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Masukkan password saat ini">
                    </div>
                    <div class="form-group">
                      <label for="new_password">Password Baru</label>
                      <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Min. 6 karakter">
                    </div>
                    <div class="form-group">
                      <label for="confirm_password">Konfirmasi Password Baru</label>
                      <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Ulangi password baru">
                      <small class="form-text text-muted" style="font-size: .72rem; margin-top: 4px;">Jangan pernah beritahukan password kepada siapapun.</small>
                    </div>
                    <div class="custom-control custom-checkbox mb-3">
                      <input type="checkbox" class="custom-control-input" id="check_confirmation_password" name="confirmation_password" value="agree">
                      <label class="custom-control-label" for="check_confirmation_password">Saya yakin ingin mengganti password</label>
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