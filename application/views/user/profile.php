        <!-- Begin Page Content -->
        <div class="container-fluid">

          <div class="page-header-row">
            <div class="page-header">
              <h1 class="h3"><?= $title; ?></h1>
              <p class="page-subtitle">Informasi akun Anda</p>
            </div>
          </div>

          <?php if ($this->session->flashdata('pesan')) : ?>
            <div class="alert alert-success premium-alert alert-dismissible fade show" role="alert">
              <?= $this->session->flashdata('pesan'); ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
          <?php endif; ?>

          <div class="row">
            <div class="col-xl-6">
              <div class="profile-card">
                <div class="row no-gutters">
                  <div class="col-md-4">
                    <img src="<?= base_url('assets/profile/'.$user['foto_profile']) ?>" alt="Foto Profil" class="profile-image">
                  </div>
                  <div class="col-md-8">
                    <div class="profile-body">
                      <div class="profile-username">
                        <i class="fas fa-user-circle" style="color: #6366f1;"></i>
                        <?= htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8'); ?>
                      </div>
                      <div class="profile-info">
                        <i class="fas fa-phone-alt" style="color: #94a3b8; width: 18px;"></i>
                        <?= htmlspecialchars($user['telp'], ENT_QUOTES, 'UTF-8') ?>
                      </div>
                      <div class="profile-info">
                        <i class="fas fa-tag" style="color: #94a3b8; width: 18px;"></i>
                        <?= isset($user['level']) ? ucfirst($user['level']) : 'Masyarakat' ?>
                      </div>
                      <div style="margin-top: 16px;">
                        <button class="premium-btn premium-btn-info premium-btn-sm" onclick="alert('Halaman belum tersedia')">
                          <i class="fas fa-camera"></i> Ganti Foto
                        </button>
                        <a href="<?= base_url('Auth/ChangePasswordController') ?>" class="premium-btn premium-btn-outline premium-btn-sm">
                          <i class="fas fa-key"></i> Ganti Password
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      <!-- End of Main Content -->