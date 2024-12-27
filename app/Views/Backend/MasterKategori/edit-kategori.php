<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<li>Master Data Kategori</li>
			<li>Data Kategori</li>
			<li class="active">Edit Data Admin</li>
		</ol>
	</div><!--/.row-->

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-body">
			    <h3>Edit Data Kategori</h3>
			    <hr />
				<form action="<?php echo base_url('admin/update-kategori');?>" method="post">
					<div class="form-group col-md-6">
                        <label>Nama Kategori</label>
                        <input type="text" class="form-control" name="kategori" value="<?= $data_edit['nama_kategori']; ?>" placeholder="Masukkan Nama Kategori" required="required">
                    </div>
                    <div style="clear:both;"></div>

                    <div class="form-group col-md-6">
	                    <button type="submit" class="btn btn-primary">Simpan</button>
						<button type="reset" class="btn btn-danger">Batal</button>
					</div>
					<div style="clear:both;"></div>
				</form>
			</div>
		</div>
	</div>
	
</div><!--/.row-->

</div>