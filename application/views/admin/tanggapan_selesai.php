        <!-- Begin Page Content -->
        <div class="container-fluid">

          <div class="page-header-row">
            <div class="page-header">
              <h1 class="h3"><?= $title; ?></h1>
              <p class="page-subtitle">Pengaduan yang telah selesai ditindaklanjuti</p>
            </div>
          </div>

          <?= validation_errors('<div class="alert alert-danger premium-alert alert-dismissible fade show" role="alert">','<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>') ?>
          <?= $this->session->flashdata('msg'); ?>

          <?php if ( ! empty($data_pengaduan)) : ?>
            <div class="row">
            <?php foreach ($data_pengaduan as $dp) : ?>
              <div class="col-xl-4 col-lg-6 mb-4 d-flex align-items-stretch">
                <div class="complaint-card w-100">
                  <div class="card-header d-flex align-items-center">
                    <div class="d-flex align-items-center" style="gap: 10px;">
                      <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(16,185,129,0.1); display: flex; align-items: center; justify-content: center; color: #10b981; font-size: .85rem; font-weight: 700; flex-shrink: 0;">
                        <i class="fas fa-user"></i>
                      </div>
                      <div>
                        <h6><?= htmlspecialchars($dp['nama'], ENT_QUOTES, 'UTF-8') ?></h6>
                        <small class="text-muted" style="font-size: .7rem;"><i class="fas fa-phone"></i> <?= htmlspecialchars($dp['telp'], ENT_QUOTES, 'UTF-8') ?></small>
                      </div>
                    </div>
                    <div class="ml-auto">
                      <span class="badge-status badge-selesai">Selesai</span>
                    </div>
                  </div>
                  <img height="160" src="<?= base_url() ?>assets/uploads/<?= $dp['foto'] ?>" class="card-img-top" style="object-fit: cover;">
                  <div class="card-body">
                    <span class="field-label"><i class="fas fa-file-alt"></i> Laporan</span>
                    <p><?= nl2br(htmlspecialchars($dp['isi_laporan'])) ?></p>
                    <span class="field-label"><i class="fas fa-calendar"></i> Tanggal</span>
                    <p><?= date('d M Y', strtotime($dp['tgl_pengaduan'])) ?></p>
                  </div>
                  <div class="card-footer text-center">
                    <span class="text-muted" style="font-size: .78rem; font-weight: 500;">
                      <i class="fas fa-check-circle text-success"></i> Selesai diproses
                    </span>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
            </div>
          <?php else : ?>
            <div class="text-center py-5">
              <div style="font-size: 3rem; color: #cbd5e1; margin-bottom: 16px;">
                <i class="fas fa-flag-checkered"></i>
              </div>
              <p class="text-muted" style="font-size: .95rem;">Belum ada pengaduan yang selesai</p>
            </div>
          <?php endif; ?>

        </div>
      <!-- End of Main Content -->