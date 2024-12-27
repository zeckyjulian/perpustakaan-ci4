<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
				<li>Restore Data</li>
				<li class="active">Master Data Admin</li>
			</ol>
		</div><!--/.row-->				
		
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<h3>Restore Data Admin <a href="<?= base_url('admin/input-data-admin'); ?>"></a></h3>
						<hr />
						<table data-toggle="table" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
						    <thead>
								<tr>
									<th data-sortable="true">#</th>
									<th data-sortable="true">Nama Admin</th>
									<th data-sortable="true">Username Admin</th>
									<th data-sortable="true">Akses Level</th>
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
									<td data-sortable="true"><?= $data['nama_admin'];?></td>
									<td data-sortable="true"><?= $data['username_admin'];?></td>
									<td data-sortable="true"><?= $data['akses_level'];?></td>
									<td data-sortable="true">
									<!-- <a href="<?= base_url('admin/update-admin/'.sha1($data['id_admin'])); ?>"><button type="button" class="btn btn-sm btn-success">Edit</button></a> -->
										<a href="#" onclick="doDelete('<?= sha1($data['id_admin']);?>')"><button type="button" class="btn btn-sm btn-success">Restore</button></a>
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
				title : "Restore Data Admin?",
				text : "Data ini akan dikembalikan!!",
				icon : "warning",
				buttons : true,
				dangerMode : false,
			})
			.then(ok => {
				if(ok){
					window.location.href = '<?= base_url();?>/admin/restore-data-admin/' + idDelete;
				}
				else{
					$(this).removeAttr('disabled')
				}
			})
		}
	</script>