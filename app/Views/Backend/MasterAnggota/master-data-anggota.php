<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
				<li>Master Data Anggota</li>
				<li class="active">Data Anggota</li>
			</ol>
		</div><!--/.row-->				
		
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<h3>Master Data Anggota <a href="<?= base_url('admin/input-data-anggota'); ?>"><button type="button" class="btn btn-sm btn-primary pull-right">Input Data Anggota</button></a></h3>
						<hr />
						<table data-toggle="table" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
						    <thead>
								<tr>
									<th data-sortable="true">#</th>
									<th data-sortable="true">Nama Anggota</th>
									<th data-sortable="true">Jenis Kelamin</th>
									<th data-sortable="true">No. Telp</th>
									<th data-sortable="true">Alamat</th>
									<th data-sortable="true">E-mail</th>
									<th data-sortable="true">Opsi</th>
								</tr>
						    </thead>
							<tbody>
								<?php
								$no = 0;
								foreach($data_user as $data){
								?>
								<tr>
									<td data-sortable="true"><?= $no=$no+1;?></td>
									<td data-sortable="true"><?= $data['nama_anggota'];?></td>
									<td data-sortable="true"><?= $data['jenis_kelamin'];?></td>
									<td data-sortable="true"><?= $data['no_tlp'];?></td>
									<td data-sortable="true"><?= $data['alamat'];?></td>
									<td data-sortable="true"><?= $data['email'];?></td>
									<td data-sortable="true">
										<a href="<?= base_url('admin/edit-anggota/'.sha1($data['id_anggota'])); ?>"><button type="button" class="btn btn-sm btn-success">Edit</button></a>
										<a href="#" onclick="doDelete('<?= sha1($data['id_anggota']);?>')"><button type="button" class="btn btn-sm btn-danger">Hapus</button></a>
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

	<script type="text/javascript">
		function doDelete(idDelete){
			swal({
				title : "Hapus Data Anggota?",
				text : "Data ini akan terhapus secara permanen!!",
				icon : "warning",
				buttons : true,
				dangerMode : false,
			})
			.then(ok => {
				if(ok){
					window.location.href = '<?= base_url();?>/admin/hapus-data-anggota/' + idDelete;
				}
				else{
					$(this).removeAttr('disabled')
				}
			})
		}
	</script>