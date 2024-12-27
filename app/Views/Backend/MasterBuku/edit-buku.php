<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
			<li>Master Data Buku</li>
			<li class="active">Edit Data Buku</li>
		</ol>
	</div><!--/.row-->

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-body">
			    <h3>Edit Data Buku</h3>
			    <hr />
				<form action="<?php echo base_url('admin/update-buku');?>" method="post" enctype="multipart/form-data">
        <div class="form-group col-md-6">
                        <label>Judul Buku</label>
                        <input type="text" class="form-control" name="judul" value="<?= $data_edit['judul_buku']; ?>" placeholder="Masukkan Judul Buku" required="required">
                    </div>
                    <div style="clear:both;"></div>

                    <div class="form-group col-md-6">
                        <label>Pengarang</label>
                        <input type="text" class="form-control" name="pengarang" value="<?= $data_edit['pengarang']; ?>" placeholder="Masukkan Nama Pengarang" required="required">
                    </div>
                    <div style="clear:both;"></div>

                    <div class="form-group col-md-6">
                        <label>Penerbit</label>
                        <input type="text" class="form-control" name="penerbit" value="<?= $data_edit['penerbit']; ?>" placeholder="Masukkan Nama Penerbit" required="required">
                    </div>
                    <div style="clear:both;"></div>

                    <div class="form-group col-md-6">
                        <label>Tahun</label>
                        <input type="text" class="form-control" value="<?= $data_edit['tahun']; ?>" onKeyPress="return goodchars(event,'1234567890',this)" name="tahun" placeholder="Masukkan Tahun" required="required">
                    </div>
                    <div style="clear:both;"></div>

										<div class="form-group col-md-6">
                        <label>Jumlah Eksemplar</label>
                        <input type="text" class="form-control" value="<?= $data_edit['jumlah_eksemplar']; ?>" onKeyPress="return goodchars(event,'1234567890',this)" name="eksemplar" placeholder="Masukkan Jumlah Eksemplar" required="required">
                    </div>
                    <div style="clear:both;"></div>

                    <div class="form-group col-md-6">
                        <label>Kategori Rak</label>
                        <select class="form-control" name="idrak" required="required">
                        	<option value="">-- Pilih Kategori Rak --</option>
                            <?php
                                foreach($data_rak as $dataRak){
                                    if($dataRak['id_rak']==$data_edit['id_rak']) {
                                        $sel1 = 'selected';
                                    } else {
                                        $sel1 = '';
                                    }
                            ?>
                        	<option value="<?= $dataRak['id_rak']; ?>"><?= $dataRak['nama_rak']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div style="clear:both;"></div>

                    <div class="form-group col-md-6">
                        <label>Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" value="<?= $data_edit['keterangan']; ?>" placeholder="Masukkan Keterangan" required="required">
                    </div>
                    <div style="clear:both;"></div>

                    <div class="form-group col-md-6">
                        <label>Id Rak</label>
                        <input type="text" class="form-control" value="<?= $data_edit['id_rak']; ?>" onKeyPress="return goodchars(event,'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',this)" name="idrak" placeholder="Masukkan Id Rak" required="required">
                    </div>
                    <div style="clear:both;"></div>

                    <div class="form-group col-md-6">
                        <label>Cover Buku</label>
                        <input type="file" class="form-control" name="cover" value="<?= base_url($data_edit['cover_buku']); ?>" width="100%">
                        <?php if (!empty($data_edit['cover_buku'])): ?>
                            <img src="<?= base_url('img/'.$data_edit['cover_buku']); ?>" alt="Cover Buku Lama" style="max-width: 100px; margin-top: 10px;">
                        <?php endif; ?>
                    </div>
                    <div style="clear:both;"></div>

                    <div class="form-group col-md-6">
                        <label>E-Book</label>
                        <iframe src="/Assets/e-book/<?php echo $data_edit['e_book']; ?>" width="100%"></iframe>
                        <input type="file" class="form-control" name="ebook" value="<?= $data_edit['e_book']; ?>" placeholder="Masukkan File E-Book"><?= $data_edit['e_book']; ?>
                    </div>
                    <div style="clear:both;"></div>

                    <!-- base_url('admin/edit-buku/'.sha1($data['id_buku'])) -->
                    <!-- <?= $data_edit['e_book']; ?> -->

                    <div class="form-group col-md-6">
	                    <button type="submit" class="btn btn-primary">Simpan</button>
						<a href="<?php echo base_url('admin/master-data-buku'); ?>"><button type="button" class="btn btn-danger">Batal</button></a>
					</div>
					<div style="clear:both;"></div>
				</form>
			</div>
		</div>
	</div>
	
</div><!--/.row-->

</div>