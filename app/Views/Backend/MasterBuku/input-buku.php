<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<li>Master Data Buku</li>
			<li class="active">Input Data Buku</li>
		</ol>
	</div><!--/.row-->

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-body">
			    <h3>Input Buku</h3>
			    <hr />
				<form action="<?php echo base_url('admin/simpan-buku');?>" method="post" enctype="multipart/form-data">
					<div class="form-group col-md-6">
                        <label>Judul Buku</label>
                        <input type="text" class="form-control" name="judul" placeholder="Masukkan Judul Buku" required="required">
                    </div>
                    <div style="clear:both;"></div>

                    <div class="form-group col-md-6">
                        <label>Pengarang</label>
                        <input type="text" class="form-control" name="pengarang" placeholder="Masukkan Nama Pengarang" required="required">
                    </div>
                    <div style="clear:both;"></div>

                    <div class="form-group col-md-6">
                        <label>Penerbit</label>
                        <input type="text" class="form-control" name="penerbit" placeholder="Masukkan Nama Penerbit" required="required">
                    </div>
                    <div style="clear:both;"></div>

                    <div class="form-group col-md-6">
                        <label>Tahun</label>
                        <input type="text" class="form-control" onKeyPress="return goodchars(event,'1234567890',this)" name="tahun" placeholder="Masukkan Tahun" required="required">
                    </div>
                    <div style="clear:both;"></div>

										<div class="form-group col-md-6">
                        <label>Jumlah Eksemplar</label>
                        <input type="text" class="form-control" onKeyPress="return goodchars(event,'1234567890',this)" name="eksemplar" placeholder="Masukkan Jumlah Eksemplar" required="required">
                    </div>
                    <div style="clear:both;"></div>

                    <div class="form-group col-md-6">
                        <label>Kategori Buku</label>
                        <select class="form-control" name="idkategori" required="required">
                        	<option value="">-- Pilih Kategori Buku --</option>
                            <?php
                                foreach($data_kategori as $dataKategori){
                            ?>
                        	<option value="<?= $dataKategori['id_kategori']; ?>"><?= $dataKategori['nama_kategori']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div style="clear:both;"></div>

                    <div class="form-group col-md-6">
                        <label>Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" placeholder="Masukkan Keterangan" required="required">
                    </div>
                    <div style="clear:both;"></div>

                    <div class="form-group col-md-6">
                        <label>Kategori Rak</label>
                        <select class="form-control" name="idrak" required="required">
                        	<option value="">-- Pilih Kategori Rak --</option>
                            <?php
                                foreach($data_rak as $dataRak){
                            ?>
                        	<option value="<?= $dataRak['id_rak']; ?>"><?= $dataRak['nama_rak']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div style="clear:both;"></div>

                    <div class="form-group col-md-6">
                        <label>Cover Buku</label>
                        <input type="file" class="form-control" name="cover" placeholder="Masukkan Gambar Cover" required="required">
                    </div>
                    <div style="clear:both;"></div>

                    <div class="form-group col-md-6">
                        <label>E-Book</label>
                        <input type="file" class="form-control" name="ebook" placeholder="Masukkan File E-Book" required="required">
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