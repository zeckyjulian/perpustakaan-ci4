<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<li>Master Data Anggota</li>
			<li class="active">Input Anggota</li>
		</ol>
	</div><!--/.row-->

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-body">
			    <h3>Input Anggota</h3>
			    <hr />
				<form action="<?php echo base_url('admin/simpan-anggota');?>" method="post">
					<div class="form-group col-md-6">
                        <label>Nama Anggota</label>
                        <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama" required="required">
                    </div>
                    <div style="clear:both;"></div>
                    
                    <div class="form-group col-md-6">
                        <label>Jenis Kelamin</label>
                        <select class="form-control" name="jekel" required="required">
                        	<option value="">-- Pilih Jenis Kelamin --</option>
                        	<option value="L">Laki-laki</option>
                        	<option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div style="clear:both;"></div>

                    <div class="form-group col-md-6">
                        <label>No Telepon</label>
                        <input type="text" class="form-control" onKeyPress="return goodchars(event,'0123456789+',this)" name="telp" placeholder="Masukkan No Telepon" required="required">
                    </div>
                    <div style="clear:both;"></div>

                    <div class="form-group col-md-6">
                        <label>Alamat</label>
                        <input type="text" class="form-control" onKeyPress="return goodchars(event,'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ 1234567890/,.',this)" name="alamat" placeholder="Masukkan Alamat" required="required">
                    </div>
                    <div style="clear:both;"></div>

										<div class="form-group col-md-6">
                        <label>E-mail</label>
                        <input type="text" class="form-control" onKeyPress="return goodchars(event,'abcdefghijklmnopqrstuvwxyz_ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890@.',this)" name="email" placeholder="Masukkan E-mail" required="required">
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