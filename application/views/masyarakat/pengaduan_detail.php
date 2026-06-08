        <!-- Begin Page Content -->
        <div class="container-fluid">

          <div class="page-header-row">
            <div class="d-flex align-items-center" style="gap: 14px;">
              <a href="<?= base_url('Masyarakat/PengaduanController') ?>" class="back-link">
                <i class="fas fa-arrow-left"></i> Kembali
              </a>
              <div class="page-header" style="margin: 0;">
                <h1 class="h3"><?= $title; ?></h1>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-xl-8">
              <div class="detail-card">
                <div class="row no-gutters">
                  <div class="col-md-5">
                    <img src="<?= base_url('assets/uploads/'.$data_pengaduan['foto']) ?>" alt="Foto Pengaduan" class="detail-image">
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
                          <?php 
                          if ($data_pengaduan['status'] == '0') :
                            echo '<span class="badge-status badge-pending">Verifikasi</span>';
                          elseif ($data_pengaduan['status'] == 'proses') :
                            echo '<span class="badge-status badge-proses">Diproses</span>';
                          elseif ($data_pengaduan['status'] == 'selesai') :
                            echo '<span class="badge-status badge-selesai">Selesai</span>';
                          elseif ($data_pengaduan['status'] == 'tolak') :
                            echo '<span class="badge-status badge-tolak">Ditolak</span>';
                          endif;
                          ?>
                        </p>
                      </div>
                      <div class="detail-row">
                        <span class="detail-label">Isi Laporan</span>
                        <p class="detail-value"><?= nl2br(htmlspecialchars($data_pengaduan['isi_laporan'])) ?></p>
                      </div>
                      <div class="detail-row">
                        <span class="detail-label">Tanggapan</span>
                        <p class="detail-value"><?= !empty($data_pengaduan['tanggapan']) ? nl2br(htmlspecialchars($data_pengaduan['tanggapan'])) : '<span class="text-muted">Belum ada tanggapan</span>' ?></p>
                      </div>
                      <div class="detail-row">
                        <span class="detail-label">Tanggal Ditanggapi</span>
                        <p class="detail-value"><?= !empty($data_pengaduan['tgl_tanggapan']) ? date('d F Y', strtotime($data_pengaduan['tgl_tanggapan'])) : '-' ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      <!-- End of Main Content -->