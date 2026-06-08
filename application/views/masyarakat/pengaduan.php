        <!-- Begin Page Content -->
        <div class="container-fluid">

          <div class="page-header-row">
            <div class="page-header">
              <h1 class="h3"><?= $title; ?></h1>
              <p class="page-subtitle">Ajukan laporan pengaduan baru</p>
            </div>
          </div>

          <?= validation_errors('<div class="alert alert-danger premium-alert alert-dismissible fade show" role="alert">','<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>') ?>
          <?= $this->session->flashdata('msg'); ?>

          <div class="row">
            <div class="col-lg-7 mb-4">
              <div class="card dashboard-card">
                <div class="card-header">
                  <h6><i class="fas fa-plus-circle"></i> Buat Pengaduan Baru</h6>
                </div>
                <div class="card-body">
                  <?= form_open_multipart('Masyarakat/PengaduanController', 'class="premium-form"'); ?>
                    <div class="form-group">
                      <label for="isi_laporan">Isi Laporan</label>
                      <textarea name="isi_laporan" id="isi_laporan" cols="30" rows="6" class="form-control" placeholder="Jelaskan laporan pengaduan Anda..."></textarea>
                    </div>
                    <div class="form-group">
                      <label for="foto">Upload Foto (opsional)</label>
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="foto" name="foto">
                        <label class="custom-file-label" for="foto">Pilih file</label>
                      </div>
                      <small class="text-muted" style="font-size: .72rem;">Format: jpg, jpeg, png. Maks: 2MB</small>
                    </div>
                    <button type="submit" class="btn-submit">
                      <i class="fas fa-paper-plane"></i> Kirim Pengaduan
                    </button>
                  <?php form_close(); ?>
                </div>
              </div>
            </div>

            <div class="col-lg-5 mb-4">
              <div class="card dashboard-card h-100">
                <div class="card-header">
                  <h6><i class="fas fa-info-circle"></i> Informasi</h6>
                </div>
                <div class="card-body d-flex flex-column justify-content-center" style="gap: 16px;">
                  <div class="d-flex align-items-start" style="gap: 12px;">
                    <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(99,102,241,0.1); display: flex; align-items: center; justify-content: center; color: #6366f1; flex-shrink: 0;">
                      <i class="fas fa-file-alt"></i>
                    </div>
                    <div>
                      <div style="font-weight: 600; font-size: .85rem; color: #1e293b;">Laporan Jelas & Lengkap</div>
                      <div style="font-size: .75rem; color: #64748b; margin-top: 2px;">Sertakan detail kejadian agar mudah ditindaklanjuti</div>
                    </div>
                  </div>
                  <div class="d-flex align-items-start" style="gap: 12px;">
                    <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(16,185,129,0.1); display: flex; align-items: center; justify-content: center; color: #10b981; flex-shrink: 0;">
                      <i class="fas fa-camera"></i>
                    </div>
                    <div>
                      <div style="font-weight: 600; font-size: .85rem; color: #1e293b;">Lampirkan Bukti</div>
                      <div style="font-size: .75rem; color: #64748b; margin-top: 2px;">Foto bukti pendukung memperkuat laporan Anda</div>
                    </div>
                  </div>
                  <div class="d-flex align-items-start" style="gap: 12px;">
                    <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(245,158,11,0.1); display: flex; align-items: center; justify-content: center; color: #f59e0b; flex-shrink: 0;">
                      <i class="fas fa-clock"></i>
                    </div>
                    <div>
                      <div style="font-weight: 600; font-size: .85rem; color: #1e293b;">Pantau Status</div>
                      <div style="font-size: .75rem; color: #64748b; margin-top: 2px;">Cek status pengaduan secara berkala di halaman ini</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Data Tabel -->
          <div class="card dashboard-card mt-2">
            <div class="card-header">
              <h6><i class="fas fa-history"></i> Riwayat Pengaduan</h6>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="premium-table mb-0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Isi Laporan</th>
                      <th>Tgl Melapor</th>
                      <th>Foto</th>
                      <th>Status</th>
                      <th class="text-center">Detail</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (empty($data_pengaduan)) : ?>
                      <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada pengaduan</td>
                      </tr>
                    <?php else : ?>
                      <?php $no = 1; ?>
                      <?php foreach ($data_pengaduan as $dp) : ?>
                        <tr>
                          <td class="fw-bold"><?= $no++; ?></td>
                          <td style="max-width: 200px;" class="text-truncate"><?= htmlspecialchars($dp['isi_laporan']); ?></td>
                          <td><?= date('d/m/Y', strtotime($dp['tgl_pengaduan'])); ?></td>
                          <td>
                            <img width="60" height="40" src="<?= base_url() ?>assets/uploads/<?= $dp['foto']; ?>" alt="" style="border-radius: 8px; object-fit: cover;">
                          </td>
                          <td>
                            <?php
                            if ($dp['status'] == '0') :
                              echo '<span class="badge-status badge-pending">Verifikasi</span>';
                            elseif ($dp['status'] == 'proses') :
                              echo '<span class="badge-status badge-proses">Diproses</span>';
                            elseif ($dp['status'] == 'selesai') :
                              echo '<span class="badge-status badge-selesai">Selesai</span>';
                            elseif ($dp['status'] == 'tolak') :
                              echo '<span class="badge-status badge-tolak">Ditolak</span>';
                            endif;
                            ?>
                          </td>
                          <td class="text-center">
                            <a href="<?= base_url('Masyarakat/PengaduanController/pengaduan_detail/'.$dp['id_pengaduan']) ?>" class="premium-btn premium-btn-info premium-btn-sm">
                              <i class="fas fa-eye"></i>
                            </a>
                          </td>
                          <td class="text-center">
                            <?php if ($dp['status'] == '0') : ?>
                              <div class="table-action justify-content-center">
                                <?= form_open('Masyarakat/PengaduanController/pengaduan_batal/'.$dp['id_pengaduan']); ?>
                                  <button type="submit" class="premium-btn premium-btn-warning premium-btn-sm" onclick="return confirm('Hapus pengaduan ini?')">
                                    <i class="fas fa-trash"></i>
                                  </button>
                                <?= form_close(); ?>
                                <a href="<?= base_url('Masyarakat/PengaduanController/edit/'.$dp['id_pengaduan']) ?>" class="premium-btn premium-btn-info premium-btn-sm">
                                  <i class="fas fa-edit"></i>
                                </a>
                              </div>
                            <?php else : ?>
                              <small class="text-muted">-</small>
                            <?php endif; ?>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
      <!-- End of Main Content -->