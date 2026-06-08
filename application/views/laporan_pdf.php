<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengaduan Masyarakat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #444;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            text-transform: uppercase;
            color: #000;
        }
        .header p {
            margin: 5px 0 0 0;
            font-style: italic;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        table, th, td {
            border: 1px solid #666;
        }
        th {
            background-color: #f2f2f2;
            padding: 10px 5px;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
        }
        td {
            padding: 8px 5px;
            vertical-align: top;
            word-wrap: break-word;
        }
        .text-center {
            text-align: center;
        }
        .status {
            font-weight: bold;
            text-transform: capitalize;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Pengaduan Masyarakat</h2>
        <p>Dicetak pada: <?= date('d F Y, H:i') ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px">No</th>
                <th style="width: 80px">Nama</th>
                <th style="width: 80px">NIK</th>
                <th>Isi Laporan</th>
                <th style="width: 70px">Tgl Lapor</th>
                <th style="width: 70px">Status</th>
                <th>Tanggapan</th>
                <th style="width: 70px">Tgl Tanggapi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach($laporan as $l) : ?>
                <tr>
                    <td class="text-center"><?= $no++; ?></td>
                    <td><?= htmlspecialchars($l['nama'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td class="text-center"><?= htmlspecialchars($l['nik'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= nl2br(htmlspecialchars($l['isi_laporan'], ENT_QUOTES, 'UTF-8')) ?></td>
                    <td class="text-center"><?= date('d-m-Y', strtotime($l['tgl_pengaduan'])) ?></td>
                    <td class="text-center status">
                        <?php
                        if ($l['status'] == '0') echo 'Verifikasi';
                        elseif ($l['status'] == 'proses') echo 'Proses';
                        elseif ($l['status'] == 'selesai') echo 'Selesai';
                        elseif ($l['status'] == 'tolak') echo 'Ditolak';
                        else echo '-';
                        ?>
                    </td>
                    <td><?= $l['tanggapan'] == null ? '-' : nl2br(htmlspecialchars($l['tanggapan'], ENT_QUOTES, 'UTF-8')); ?></td>
                    <td class="text-center"><?= $l['tgl_tanggapan'] == null ? '-' : date('d-m-Y', strtotime($l['tgl_tanggapan'])); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
