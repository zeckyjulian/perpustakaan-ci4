<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
				<li>Transaksi</li>
				<li class="active">Data Peminjaman</li>
			</ol>
		</div><!--/.row-->				
		
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<h3>Data Peminjaman <a href="<?= base_url('admin/input-data-peminjaman'); ?>"> <button type="button" class="btn btn-sm btn-primary pull-right">Input Data Peminjaman</button></a> <button type="button" class="btn btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalScan" style="margin-right: 4px;"><span class="glyphicon glyphicon-camera"></span></button></h3>
						<hr />
						<table data-toggle="table" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
						    <thead>
								<tr>
									<th data-sortable="true">#</th>
									<th data-sortable="true">No Peminjaman</th>
									<th data-sortable="true">Nama Anggota</th>
									<th data-sortable="true">Tanggal Peminjaman</th>
									<th data-sortable="true">Total Buku Yang Dipinjam</th>
									<th data-sortable="true">Status Transaksi</th>
									<th data-sortable="true">Status Ambil Buku</th>
									<th data-sortable="true">Opsi</th>
								</tr>
						    </thead>
							<tbody>
								<?php
								$no = 0;
								foreach($data_pinjam as $data){
								?>
								<tr>
									<td data-sortable="true"><?= $no=$no+1;?></td>
									<td data-sortable="true"><?= $data['no_peminjaman'];?></td>
									<td data-sortable="true"><?= $data['nama_anggota'];?></td>
									<td data-sortable="true"><?= $data['tgl_pinjam'];?></td>
									<td data-sortable="true"><?= $data['total_pinjam'];?></td>
									<td data-sortable="true"><?= $data['status_transaksi'];?></td>
									<td data-sortable="true"><?= $data['status_ambil_buku'];?></td>
									<td data-sortable="true">
										<a href="<?= base_url('admin/detail-peminjaman/'.$data['no_peminjaman']); ?>"><button type="button" class="btn btn-sm btn-primary">Detail</button></a>
										<a href="<?= base_url('admin/edit-transaksi-pinjam/'.sha1($data['no_peminjaman'])); ?>"><button type="button" class="btn btn-sm btn-success">Kembalikan</button></a>
										<a href="#" onclick="doDelete('<?= sha1($data['no_peminjaman']);?>')"><button type="button" class="btn btn-sm btn-danger">Hapus</button></a>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div><!--/.row-->		
	</div><!--/.main-->

	<!-- Modal -->
	<div class="modal fade" id="modalScan" tabindex="-1" aria-labelledby="modalScanLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="modalScanLabel">Modal Scan</h1>
				</div>
				<div class="modal-body">
					<video id="qr-video" width="100%"></video>
					<p>
						<b>Detected QR code: </b>
						<span id="cam-qr-result">None</span>
					</p>

					<div>
						<b>Preferred camera:</b>
						<select id="cam-list">
						<option value="environment" selected>Environment Facing (default)</option>
						<option value="user">User Facing</option>
						</select>
					</div>

					<br>
					<button id="start-button" class="btn btn-success mt-3">Start</button>
					<button id="stop-button" class="btn btn-danger mt-2">Stop</button>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		function doDelete(idDelete){
			swal({
				title : "Hapus Data Peminjaman?",
				text : "Data ini akan terhapus secara permanen!!",
				icon : "warning",
				buttons : true,
				dangerMode : false,
			})
			.then(ok => {
				if(ok){
					window.location.href = '<?= base_url();?>/admin/hapus-peminjaman/' + idDelete;
				}
				else{
					$(this).removeAttr('disabled')
				}
			})
		}
	</script>

	<script type="module">
		import QrScanner from "/Assets/js/qr-scanner.min.js";

		// To enforce the use of the new api with detailed scan results, call the constructor with an options object, see below.
		const video = document.getElementById('qr-video');
		const videoContainer = document.getElementById('video-container');
		const camHasCamera = document.getElementById('cam-has-camera');
		const camList = document.getElementById('cam-list');
		const camQrResult = document.getElementById('cam-qr-result');

		function setResult(label, result) {
			console.log(result.data);
			window.open(result.data, '_blank');
			label.textContent = result.data;
			camQrResultTimestamp.textContent = new Date().toString();
			label.style.color = 'teal';
			clearTimeout(label.highlightTimeout);
			label.highlightTimeout = setTimeout(() => label.style.color = 'inherit', 100);
		}

		// ####### Web Cam Scanning #######

		const scanner = new QrScanner(video, result => setResult(camQrResult, result), {
			onDecodeError: error => {
				camQrResult.textContent = error;
				camQrResult.style.color = 'inherit';
			},
			highlightScanRegion: true,
			highlightCodeOutline: true,
		});

		

		document.getElementById('start-button').addEventListener('click', () => {
        QrScanner.listCameras(true).then(cameras => {
            camList.innerHTML = ''; // Clear old options
            cameras.forEach(camera => {
                const option = document.createElement('option');
                option.value = camera.id;
                option.text = camera.label;
                camList.add(option);
            });

            // Start scanner after listing cameras
            scanner.start();
        });
    });

		QrScanner.hasCamera().then(hasCamera => camHasCamera.textContent = hasCamera);

		// for debugging
		window.scanner = scanner;

		camList.addEventListener('change', event => {
				scanner.setCamera(event.target.value).then(updateFlashAvailability);
		});

		document.getElementById('start-button').addEventListener('click', () => {
			scanner.start();
		});

		document.getElementById('stop-button').addEventListener('click', () => {
			scanner.stop();
		});

		// ####### File Scanning #######

		// fileSelector.addEventListener('change', event => {
		//   const file = fileSelector.files[0];
		//   if (!file) {
		//     return;
		//   }
		//   QrScanner.scanImage(file, { returnDetailedScanResult: true })
		//     .then(result => setResult(fileQrResult, result))
		//     .catch(e => setResult(fileQrResult, { data: e || 'No QR code found.' }));
		// });
	</script>