        <!-- Begin Page Content -->
        <div class="container-fluid">

          <div class="page-header-row">
            <div class="page-header">
              <h1 class="h3"><?= $title; ?></h1>
              <p class="page-subtitle">Semua pemberitahuan untuk Anda</p>
            </div>
          </div>

          <?= $this->session->flashdata('msg'); ?>

          <div class="row">
            <div class="col-lg-8">
              <div class="card dashboard-card">
                <div class="card-body p-0">
                  <?php if (empty($notifikasi)) : ?>
                    <div class="text-center py-5">
                      <div style="font-size: 3rem; color: #cbd5e1; margin-bottom: 16px;">
                        <i class="fas fa-bell"></i>
                      </div>
                      <p class="text-muted">Tidak ada notifikasi</p>
                    </div>
                  <?php else : ?>
                    <div class="list-group list-group-flush">
                      <?php foreach ($notifikasi as $n) : ?>
                        <a href="<?= base_url('NotifikasiController/read/'.$n['id_notifikasi']) ?>" class="list-group-item list-group-item-action d-flex align-items-center <?= $n['is_read'] == '0' ? 'font-weight-bold' : '' ?>" style="border-left: <?= $n['is_read'] == '0' ? '3px solid #6366f1' : '3px solid transparent' ?>;">
                          <div style="width: 40px; height: 40px; border-radius: 10px; background: <?= $n['is_read'] == '0' ? 'rgba(99,102,241,0.1)' : 'rgba(148,163,184,0.1)' ?>; display: flex; align-items: center; justify-content: center; color: <?= $n['is_read'] == '0' ? '#6366f1' : '#94a3b8' ?>; flex-shrink: 0; margin-right: 14px;">
                            <i class="fas fa-bell"></i>
                          </div>
                          <div style="flex: 1; min-width: 0;">
                            <div style="font-size: .9rem; color: #1e293b;"><?= htmlspecialchars($n['isi']) ?></div>
                            <div style="font-size: .75rem; color: #94a3b8; margin-top: 2px;"><?= date('d M Y H:i', strtotime($n['created_at'])) ?></div>
                          </div>
                          <?php if ($n['is_read'] == '0') : ?>
                            <span style="width: 8px; height: 8px; border-radius: 50%; background: #6366f1; flex-shrink: 0;"></span>
                          <?php endif; ?>
                        </a>
                      <?php endforeach; ?>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>

        </div>
      <!-- End of Main Content -->
