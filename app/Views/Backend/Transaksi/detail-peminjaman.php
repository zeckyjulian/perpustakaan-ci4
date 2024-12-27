<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Peminjaman Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .invoice-box {
            width: 100%;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
            margin-top: 20px;
        }
        .invoice-header h1 {
            font-size: 24px;
            margin: 0;
        }
        .client-details {
            width: 50%;
            vertical-align: top;
            line-height: 1.5;
            margin-left: 10px;
        }
        .client-details h2 {
            margin-top: 0;
        }
        .client-table {
          margin-left: 25px;
        }
        .client-table td {
          border: none;
        }
        .invoice-details {
            margin-top: 20px;
            text-align: center;
            margin-left: auto;
            margin-right: auto;
        }
        .invoice-details th, .invoice-details td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .invoice-details th {
            background-color: #f2f2f2;
        }
        .invoice-footer {
            text-align: right;
            margin-top: 20px;
            margin-right: 25px;
            margin-bottom: 20px;
        }
        .total {
            font-size: 18px;
            font-weight: bold;
        }
        @media print {
          @page {
              size: A4 landscape;
              margin: 10mm;
          }
          body * {
              visibility: hidden; /* Sembunyikan semua elemen */
          }
          .invoice-box, .invoice-box * {
              visibility: visible; /* Tampilkan hanya invoice-box */
          }
          .invoice-box {
              position: absolute;
              top: 0;
              left: 0;
              width: 100%; /* Pastikan tampil penuh */
          }
          .btn {
              display: none; /* Sembunyikan tombol saat print */
          }
        }
    </style>
</head>
<body>

<div class="invoice-box">
    <div class="invoice-header">
        <h1>Invoice Peminjaman</h1>
    </div>

    <div class="client-details">
        <h2></h2>
        <table class="client-table" width="48%">
          <tr>
            <td>Nama Peminjam</td>
            <td>: <?= $dataPeminjaman[0]['nama_anggota'] ?></td>
          </tr>
          <tr>
            <td>Telepon</td>
            <td>: <?= $dataPeminjaman[0]['no_tlp'] ?></td>
          </tr>
          <tr>
            <td>Email</td>
            <td>: <?= $dataPeminjaman[0]['email'] ?></td>
          </tr>
          <tr>
            <td>Total Buku Dipinjam</td>
            <td>: <?= count($dataPeminjaman2) ?></td>
          </tr>
        </table>
    </div>

    <table class="invoice-details" width="95%">
        <thead>
            <tr>
                <th>No</th>
                <th>No Peminjaman</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
            </tr>
        </thead>
        <tbody>
          <?php
            $no = 0;
            foreach($dataPeminjaman2 as $data){
          ?>
            <tr>
              <td data-sortable="true"><?= $no=$no+1;?></td>
              <td data-sortable="true"><?= $data['no_peminjaman'];?></td>
              <td data-sortable="true"><?= $data['judul_buku'];?></td>
              <td data-sortable="true"><?= date("Y-m-d", strtotime($data['tgl_kembali']."-7 days"));?></td>
              <td data-sortable="true"><?= $data['tgl_kembali'];?></td>
            </tr>
          <?php } ?>
        </tbody>
    </table>

    <div class="invoice-footer">
      <img height="200px" width="200px" src="/Assets/qr-code/<?= $dataPeminjaman[0]['qr_code'];?>">
    </div>
</div>
<br>
<a href="<?= base_url('admin/data-transaksi-peminjaman'); ?>"><button type="button" class="btn btn-sm btn-primary pull-right">Kembali ke Data Peminjaman</button></a>
<button type="button" class="btn btn-sm btn-info pull-right" onClick="window.print()">Cetak Invoice</button>

</body>
</html>