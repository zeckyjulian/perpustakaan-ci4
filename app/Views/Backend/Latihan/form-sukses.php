<?php
$session = session();
if (!isset($_SESSION['nim'])) {
?>
    <script>
        alert('Kamu Belum Melakukan Input');
        document.location = "<?= base_url('admin/belajar-form') ?>";
    </script>
<?php
} else {
?>
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
                <li class="active">Page Sukses</li>
            </ol>
        </div><!--/.row-->
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading"><span class="glyphicon glyphicon-user"></span> Sukses</div>
                    <div class="panel-body">
                        <h1>#SUKSES#</h1>
                        <br>
                        <form class="form-horizontal">
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="nim">NIM</label>
                                    <div class="col-md-9">
                                        <input readonly type="text" name="nim" id="nim" class="form-control" placeholder="<?= $_SESSION['nim']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="nama">Nama Lengkap</label>
                                    <div class="col-md-9">
                                        <input readonly id="nama" name="nama" type="text" class="form-control" placeholder="<?= $_SESSION['nama']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="email">Email</label>
                                    <div class="col-md-9">
                                        <input readonly id="email" name="email" type="text" class="form-control" placeholder="<?= $_SESSION['email']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="jk">Jenis Kelamin</label>
                                    <div class="col-md-9">
                                        <input readonly type="text" name="jekel" id="jk1" placeholder="<?= $_SESSION['jekel']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="kodecabang">Kode Cabang</label>
                                    <div class="col-md-9">
                                        <input type="text" name="kodecabang" readonly placeholder="<?= $_SESSION['kodecabang']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="kodecabang">Kampus</label>
                                    <div class="col-md-9">
                                        <input type="text" name="kampus" readonly placeholder="<?= $_SESSION['kampus']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="kelas">Kelas</label>
                                    <div class="col-md-9">
                                        <input readonly id="kelas" name="kelas" type="text" class="form-control" placeholder="<?= $_SESSION['kelas']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="alamat">Alamat</label>
                                    <div class="col-md-9">
                                        <textarea name="alamat" id="alamat" class="form-control" readonly><?= $_SESSION['alamat']; ?></textarea>
                                    </div>
                                </div>
                            </fieldset>
                        </form>



                        <a href="belajar-form" class="btn btn-primary">input Kembali</a>
                    </div>
                </div>
                <?php  ?>

            </div><!--/.col-->

            <div class="col-md-4">

                <!--
				<div class="panel panel-blue">
					<div class="panel-heading dark-overlay"><span class="glyphicon glyphicon-check"></span>To-do List</div>
					<div class="panel-body">
						<ul class="todo-list">
						<li class="todo-list-item">
								<div class="checkbox">
									<input readonly type="checkbox" id="checkbox" />
									<label for="checkbox">Make a plan for today</label>
								</div>
								<div class="pull-right action-buttons">
									<a href="#"><span class="glyphicon glyphicon-pencil"></span></a>
									<a href="#" class="flag"><span class="glyphicon glyphicon-flag"></span></a>
									<a href="#" class="trash"><span class="glyphicon glyphicon-trash"></span></a>
								</div>
							</li>
							<li class="todo-list-item">
								<div class="checkbox">
									<input readonly type="checkbox" id="checkbox" />
									<label for="checkbox">Update Basecamp</label>
								</div>
								<div class="pull-right action-buttons">
									<a href="#"><span class="glyphicon glyphicon-pencil"></span></a>
									<a href="#" class="flag"><span class="glyphicon glyphicon-flag"></span></a>
									<a href="#" class="trash"><span class="glyphicon glyphicon-trash"></span></a>
								</div>
							</li>
							<li class="todo-list-item">
								<div class="checkbox">
									<input readonly type="checkbox" id="checkbox" />
									<label for="checkbox">Send email to Jane</label>
								</div>
								<div class="pull-right action-buttons">
									<a href="#"><span class="glyphicon glyphicon-pencil"></span></a>
									<a href="#" class="flag"><span class="glyphicon glyphicon-flag"></span></a>
									<a href="#" class="trash"><span class="glyphicon glyphicon-trash"></span></a>
								</div>
							</li>
							<li class="todo-list-item">
								<div class="checkbox">
									<input readonly type="checkbox" id="checkbox" />
									<label for="checkbox">Drink coffee</label>
								</div>
								<div class="pull-right action-buttons">
									<a href="#"><span class="glyphicon glyphicon-pencil"></span></a>
									<a href="#" class="flag"><span class="glyphicon glyphicon-flag"></span></a>
									<a href="#" class="trash"><span class="glyphicon glyphicon-trash"></span></a>
								</div>
							</li>
							<li class="todo-list-item">
								<div class="checkbox">
									<input readonly type="checkbox" id="checkbox" />
									<label for="checkbox">Do some work</label>
								</div>
								<div class="pull-right action-buttons">
									<a href="#"><span class="glyphicon glyphicon-pencil"></span></a>
									<a href="#" class="flag"><span class="glyphicon glyphicon-flag"></span></a>
									<a href="#" class="trash"><span class="glyphicon glyphicon-trash"></span></a>
								</div>
							</li>
							<li class="todo-list-item">
								<div class="checkbox">
									<input readonly type="checkbox" id="checkbox" />
									<label for="checkbox">Tidy up workspace</label>
								</div>
								<div class="pull-right action-buttons">
									<a href="#"><span class="glyphicon glyphicon-pencil"></span></a>
									<a href="#" class="flag"><span class="glyphicon glyphicon-flag"></span></a>
									<a href="#" class="trash"><span class="glyphicon glyphicon-trash"></span></a>
								</div>
							</li>
						</ul>
					</div>
					<div class="panel-footer">
						<div class="input readonly-group">
							<input readonly id="input readonlytxt" type="text" class="form-control input readonly-md" placeholder="Add new task" />
							<span class="input readonly-group-btn">
								<button class="btn btn-primary btn-md" id="btn-todo">Add</button>
							</span>
						</div>
					</div>
				</div>
				-->

            </div><!--/.col-->
        </div><!--/.row-->
    </div> <!--/.main-->

<?php } ?>