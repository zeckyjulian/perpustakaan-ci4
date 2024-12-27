<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<li>Master Data Anggota</li>
			<li class="active">Edit Data Anggota</li>
		</ol>
	</div><!--/.row-->

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-body">
			    <h3>Edit Data Anggota</h3>
			    <hr />
				<form action="<?php echo base_url('admin/update-anggota');?>" method="post">
					<div class="form-group col-md-6">
                        <label>Nama Anggota</label>
                        <input type="text" class="form-control" name="nama" value="<?= $data_edit['nama_anggota']; ?>" placeholder="Masukkan Nama" required="required">
                    </div>
                    <div style="clear:both;"></div>
                    
                    <div class="form-group col-md-6">
                        <label>Jenis Kelamin</label>
                        <select class="form-control" name="jekel" required="required">
                        	<option value="">-- Pilih Jenis Kelamin --</option>
                        	<option value="L" <?php if($data_edit['jenis_kelamin']=="L") echo "selected"; else echo "";?>>Laki-laki</option>
                        	<option value="P" <?php if($data_edit['jenis_kelamin']=="P") echo "selected"; else echo "";?>>Perempuan</option>
                        </select>
                    </div>
                    <div style="clear:both;"></div>

                    <div class="form-group col-md-6">
                        <label>No Telepon</label>
                        <input type="text" class="form-control" value="<?= $data_edit['no_tlp']; ?>" onKeyPress="return goodchars(event,'0123456789+',this)" name="telp" placeholder="Masukkan No Telepon" required="required">
                    </div>
                    <div style="clear:both;"></div>

                    <div class="form-group col-md-6">
                        <label>Alamat</label>
                        <input type="text" class="form-control" value="<?= $data_edit['alamat']; ?>" onKeyPress="return goodchars(event,'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ 1234567890/,.',this)" name="alamat" placeholder="Masukkan Alamat" required="required">
                    </div>
                    <div style="clear:both;"></div>

										<div class="form-group col-md-6">
                        <label>E-mail</label>
                        <input type="text" class="form-control" disabled="disabled" value="<?= $data_edit['email']; ?>" onKeyPress="return goodchars(event,'abcdefghijklmnopqrstuvwxyz_ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890@.',this)" name="email" placeholder="Masukkan E-mail" required="required">
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