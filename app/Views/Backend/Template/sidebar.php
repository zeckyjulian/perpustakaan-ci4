<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
	<form role="search">
		<div class="form-group">
			<input type="text" class="form-control" placeholder="Search">
		</div>
	</form>
		<ul class="nav menu">
		<li <?php if ($halaman == "dashboard-admin") echo "class='active'"; ?>><a href="<?= base_url('admin/dashboard-admin'); ?>"><span class="glyphicon glyphicon-dashboard"></span> Dashboard</a></li>
		<!-- Master Admin -->
		<li class="parent">
			<a href="#">
				<span class="glyphicon glyphicon-list"></span> Master Data Admin <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span> 
			</a>
			<ul class="children collapse" id="sub-item-1">
				<li>
					<a class="" href="<?= base_url('admin/master-data-admin'); ?>">
						<span class="glyphicon glyphicon-share-alt"></span> Data Admin
					</a>
				</li>
				<li>
					<a class="" href="<?= base_url('admin/input-data-admin'); ?>">
						<span class="glyphicon glyphicon-share-alt"></span> Input Admin
					</a>
				</li>
			</ul>
		</li>
		<!-- Master Anggota -->
		<li class="parent ">
			<a href="#">
				<span class="glyphicon glyphicon-list"></span> Master Data Anggota <span data-toggle="collapse" href="#sub-item-2" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span> 
			</a>
			<ul class="children collapse" id="sub-item-2">
				<li>
					<a class="" href="<?= base_url('admin/master-data-anggota'); ?>">
						<span class="glyphicon glyphicon-share-alt"></span> Data Anggota
					</a>
				</li>
				<li>
					<a class="" href="<?= base_url('admin/input-data-anggota'); ?>">
						<span class="glyphicon glyphicon-share-alt"></span> Input Anggota
					</a>
				</li>
			</ul>
		</li>
		<!-- Master Buku -->
		<li class="parent ">
			<a href="#">
				<span class="glyphicon glyphicon-list"></span> Master Data Buku <span data-toggle="collapse" href="#sub-item-3" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span> 
			</a>
			<ul class="children collapse" id="sub-item-3">
				<li>
					<a class="" href="<?= base_url('admin/master-data-buku'); ?>">
						<span class="glyphicon glyphicon-share-alt"></span> Data Buku
					</a>
				</li>
				<li>
					<a class="" href="<?= base_url('admin/input-data-buku'); ?>">
						<span class="glyphicon glyphicon-share-alt"></span> Input Buku
					</a>
				</li>
			</ul>
		</li>
		<!-- Master Kategori -->
		<li class="parent ">
			<a href="#">
				<span class="glyphicon glyphicon-list"></span> Master Data Kategori <span data-toggle="collapse" href="#sub-item-4" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span> 
			</a>
			<ul class="children collapse" id="sub-item-4">
				<li>
					<a class="" href="<?= base_url('admin/master-data-kategori'); ?>">
						<span class="glyphicon glyphicon-share-alt"></span> Data Kategori
					</a>
				</li>
				<li>
					<a class="" href="<?= base_url('admin/input-data-kategori'); ?>">
						<span class="glyphicon glyphicon-share-alt"></span> Input Kategori
					</a>
				</li>
			</ul>
		</li>
		<!-- Master Rak -->
		<li class="parent ">
			<a href="#">
				<span class="glyphicon glyphicon-list"></span> Master Data Rak <span data-toggle="collapse" href="#sub-item-5" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span> 
			</a>
			<ul class="children collapse" id="sub-item-5">
				<li>
					<a class="" href="<?= base_url('admin/master-data-rak'); ?>">
						<span class="glyphicon glyphicon-share-alt"></span> Data Rak
					</a>
				</li>
				<li>
					<a class="" href="<?= base_url('admin/input-data-rak'); ?>">
						<span class="glyphicon glyphicon-share-alt"></span> Input Rak
					</a>
				</li>
			</ul>
		</li>
		<!-- Restore Data -->
		<li class="parent ">
			<a href="#">
				<span class="glyphicon glyphicon-list"></span> Restore Data <span data-toggle="collapse" href="#sub-item-6" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span> 
			</a>
			<ul class="children collapse" id="sub-item-6">
				<li>
					<a class="" href="<?= base_url('admin/master-data-restoreAdmin'); ?>">
						<span class="glyphicon glyphicon-share-alt"></span> Restore Data Admin
					</a>
				</li>
				<li>
					<a class="" href="<?= base_url('admin/master-data-restoreAnggota'); ?>">
						<span class="glyphicon glyphicon-share-alt"></span> Restore Data Anggota
					</a>
				</li>
				<li>
					<a class="" href="<?= base_url('admin/master-data-restoreBuku'); ?>">
						<span class="glyphicon glyphicon-share-alt"></span> Restore Data Buku
					</a>
				</li>
				<li>
					<a class="" href="<?= base_url('admin/master-data-restoreKategori'); ?>">
						<span class="glyphicon glyphicon-share-alt"></span> Restore Data Kategori
					</a>
				</li>
				<li>
					<a class="" href="<?= base_url('admin/master-data-restoreRak'); ?>">
						<span class="glyphicon glyphicon-share-alt"></span> Restore Data Rak
					</a>
				</li>
			</ul>
		</li>
		<!-- Transaksi -->
		<li class="parent ">
			<a href="#">
				<span class="glyphicon glyphicon-list"></span> Transaksi <span data-toggle="collapse" href="#sub-item-7" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span> 
			</a>
			<ul class="children collapse" id="sub-item-7">
				<li>
					<a class="" href="<?= base_url('admin/data-transaksi-peminjaman'); ?>">
						<span class="glyphicon glyphicon-share-alt"></span> Data Peminjaman
					</a>
				</li>
				<li>
					<a class="" href="<?= base_url('admin/input-data-peminjaman'); ?>">
						<span class="glyphicon glyphicon-share-alt"></span> Input Peminjaman
					</a>
				</li>
			</ul>
		</li>
		<!-- ???????????????? -->
		<li <?php if ($halaman == "widgets") echo "class='active'"; ?>><a href="<?= base_url('admin/widgets'); ?>"><span class="glyphicon glyphicon-th"></span> Widgets</a></li>
		<li <?php if ($halaman == "charts") echo "class='active'"; ?>><a href="<?= base_url('admin/charts'); ?>"><span class="glyphicon glyphicon-stats"></span> Charts</a></li>
		<li <?php if ($halaman == "tables") echo "class='active'"; ?>><a href="<?= base_url('admin/tables'); ?>"><span class="glyphicon glyphicon-list-alt"></span> Tables</a></li>
		<li <?php if ($halaman == "forms") echo "class='active'"; ?>><a href="<?= base_url('admin/forms'); ?>"><span class="glyphicon glyphicon-pencil"></span> Forms</a></li>
		<li <?php if ($halaman == "belajar-form") echo "class='active'"; ?>><a href="belajar-form"><span class="glyphicon glyphicon-pencil"></span> Forms Biodata</a></li>
		<li <?php if ($halaman == "panels") echo "class='active'"; ?>><a href="<?= base_url('admin/panels'); ?>"><span class="glyphicon glyphicon-info-sign"></span> Alerts &amp; Panels</a></li>
		
		<li role="presentation" class="divider"></li>
		<li><a href="<?= base_url('admin/logout') ?>"><span class="glyphicon glyphicon-log-out"></span> Log-Out</a></li>
	</ul>
</div><!--/.sidebar-->