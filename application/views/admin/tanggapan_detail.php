        <!-- Begin Page Content -->
        <div class="container-fluid">

          <div class="page-header-row">
            <div class="d-flex align-items-center" style="gap: 14px;">
              <a href="<?= base_url('Admin/TanggapanController') ?>" class="back-link">
                <i class="fas fa-arrow-left"></i> Kembali
              </a>
              <div class="page-header" style="margin: 0;">
                <h1 class="h3"><?= $title; ?></h1>
              </div>
            </div>
          </div>

          <?= validation_errors('<div class="alert alert-danger premium-alert alert-dismissible fade show" role="alert">', '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>') ?>
          <?= $this->session->flashdata('msg'); ?>

          <div class="row">
            <div class="col-xl-8">
              <div class="detail-card mb-4">
                <div class="row no-gutters">
                  <div class="col-md-5">
                    <img src="<?= base_url() ?>assets/uploads/<?= $data_pengaduan['foto'] ?>" alt="Foto Pengaduan" class="detail-image">
                  </div>
                  <div class="col-md-7">
                    <div class="detail-body">
                      <div class="detail-row">
                        <span class="detail-label">Tanggal Pengaduan</span>
                        <p class="detail-value"><?= date('d F Y', strtotime($data_pengaduan['tgl_pengaduan'])) ?></p>
                      </div>
                      <div class="detail-row">
                        <span class="detail-label">Status</span>
                        <p class="detail-value">
                          <?php if ($data_pengaduan['status'] == '0') : ?>
                            <span class="badge-status badge-pending">Pending</span>
                          <?php elseif ($data_pengaduan['status'] == 'proses') : ?>
                            <span class="badge-status badge-proses">Diproses</span>
                          <?php elseif ($data_pengaduan['status'] == 'selesai') : ?>
                            <span class="badge-status badge-selesai">Selesai</span>
                          <?php elseif ($data_pengaduan['status'] == 'tolak') : ?>
                            <span class="badge-status badge-tolak">Ditolak</span>
                          <?php endif; ?>
                        </p>
                      </div>
                      <div class="detail-row">
                        <span class="detail-label">Isi Laporan</span>
                        <p class="detail-value"><?= nl2br(htmlspecialchars($data_pengaduan['isi_laporan'])) ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card dashboard-card">
                <div class="card-header">
                  <h6>Beri Tanggapan</h6>
                </div>
                <div class="card-body">
                  <?= form_open('Admin/TanggapanController/tambah_tanggapan', 'class="premium-form"'); ?>
                    <input type="hidden" name="id" value="<?= $data_pengaduan['id_pengaduan']; ?>">

                    <div class="form-section">
                      <div class="form-section-title">Status Tanggapan</div>
                      <div class="form-group">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="status" id="status-setuju" value="proses" checked="">
                          <label class="form-check-label" for="status-setuju">Setuju / Proses</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="status" id="status-tolak" value="tolak">
                          <label class="form-check-label" for="status-tolak">Tolak</label>
                        </div>
                      </div>
                    </div>

                    <div class="form-section">
                      <div class="form-section-title">Tanggapan</div>
                      <div class="form-group">
                        <textarea name="tanggapan" class="form-control" id="tanggapan" cols="30" rows="6" placeholder="Tulis tanggapan Anda..."></textarea>
                      </div>
                    </div>

                    <button type="submit" class="btn-submit">
                      <i class="fas fa-paper-plane"></i> Kirim Tanggapan
                    </button>
                  <?= form_close(); ?>
                </div>
              </div>
            </div>
          </div>

        </div>
      <!-- End of Main Content -->