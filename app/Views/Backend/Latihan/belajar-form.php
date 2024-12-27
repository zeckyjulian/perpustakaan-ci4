<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Form Biodata Diri</title>

<link href="/Assets/css/bootstrap.min.css" rel="stylesheet">
<link href="/Assets/css/datepicker3.css" rel="stylesheet">/Assets/
<link href="/Assets/css/styles.css" rel="stylesheet">

<!-- Google Font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><span>Lumino</span>Admin</a>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> User <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
							<li><a href="#"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
							<li><a href="#"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
							
		</div><!-- /.container-fluid -->
	</nav>
		
	<!-- <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<form role="search">
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Search">
			</div>
		</form>
		<ul class="nav menu">
			<li><a href="dashboard"><span class="glyphicon glyphicon-dashboard"></span> Dashboard</a></li>
			<li><a href="widgets"><span class="glyphicon glyphicon-th"></span> Widgets</a></li>
			<li><a href="charts"><span class="glyphicon glyphicon-stats"></span> Charts</a></li>
			<li><a href="tables"><span class="glyphicon glyphicon-list-alt"></span> Tables</a></li>
			<li><a href="forms"><span class="glyphicon glyphicon-pencil"></span> Forms</a></li>
			<li class="active"><a href="belajar-form"><span class="glyphicon glyphicon-pencil"></span> Form Biodata</a></li>
			<li><a href="panels"><span class="glyphicon glyphicon-info-sign"></span> Alerts &amp; Panels</a></li>
			<li class="parent ">
				<a href="#">
					<span class="glyphicon glyphicon-list"></span> Dropdown <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="glyphicon glyphicon-s glyphicon-plus"></em></span> 
				</a>
				<ul class="children collapse" id="sub-item-1">
					<li>
						<a class="" href="#">
							<span class="glyphicon glyphicon-share-alt"></span> Sub Item 1
						</a>
					</li>
					<li>
						<a class="" href="#">
							<span class="glyphicon glyphicon-share-alt"></span> Sub Item 2
						</a>
					</li>
					<li>
						<a class="" href="#">
							<span class="glyphicon glyphicon-share-alt"></span> Sub Item 3
						</a>
					</li>
				</ul>
			</li>
			<li role="presentation" class="divider"></li>
			<li><a href="login"><span class="glyphicon glyphicon-user"></span> Login Page</a></li>
		</ul>
		<div class="attribution">Template by <a href="http://www.medialoot.com/item/lumino-admin-bootstrap-template/">Medialoot</a></div>
	</div> -->
	<!--/.sidebar-->
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
				<li class="active">Forms</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Form Biodata</h1>
			</div>
		</div><!--/.row-->
				
		
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Form Elements</div>
					<div class="panel-body">
					<?php
					if(session()->get('error_list')!=""){
						?>
						<div class="alert bg-warning" role="alert">
							<?= session()->get('error_list'); ?>
						</div>
						<?php
					}
					?>
						<div class="col-md-6">

							<form role="form"  method="post" action="<?= base_url('admin/post-form');?>">
							
								<div class="form-group">
									<label>NIM</label>
									<input class="form-control" placeholder="Masukan NIM anda" name="nim" onKeypress="return goodchars(event, '012345689', this)" maxlength="8" required>
								</div>
																
								<div class="form-group">
									<label>Nama Lengkap</label>
									<input type="text" class="form-control" placeholder="Masukan Nama Lengkap" name="nama" onKeypress="return goodchars(event, 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM\'- ', this)" maxlength="50" required>
								</div>

								<div class="form-group">
									<label>E-Mail</label>
									<input type="text" class="form-control" placeholder="Masukan E-Mail anda" name="email" onKeypress="return goodchars(event, '012345689qwertyuiopasdfghjklzxcvbnm@._', this)" maxlength="50" required>
								</div>

								<div class="form-group">
									<label>Jenis Kelamin</label>
									<div class="radio">
										<label>
											<input type="radio" name="jekel" id="optionsRadios1" value="Laki-laki">Laki-laki
										</label>
									</div>
									<div class="radio">
										<label>
										<input type="radio" name="jekel" id="optionsRadios2" value="Perempuan">Perempuan
										</label>
									</div>
								</div>
								
								<div class="form-group">
									<label>Kode Cabang</label>
									<select class="form-control" name="kode_cabang">
										<option>01</option>
										<option>02</option>
										<option>03</option>
										<option>04</option>
									</select>
								</div>
								
								<div class="form-group">
									<label>Kelas</label>
									<input type="text" class="form-control" placeholder="Masukan Kelas" name="kelas" onKeypress="return goodchars(event, '012345689QWERTYUIOPASDFGHJKLZXCVBNM.', this)" maxlength="8" required>
								</div>

								<div class="form-group">
									<label>Alamat</label>
									<textarea class="form-control" rows="3"  name="alamat"></textarea>
								</div>
								
								<button type="submit" class="btn btn-primary">Submit</button>
								<button type="reset" class="btn btn-default">Reset</button>

							</div>
							<div class="col-md-6">

							</div>
						</form>
					</div>
				</div>
			</div><!-- /.col-->
		</div><!-- /.row -->
		
	</div><!--/.main-->

	<script src="/Assets/js/jquery-1.11.1.min.js"></script>
	<script src="/Assets/js/bootstrap.min.js"></script>
	<script src="/Assets/js/chart.min.js"></script>
	<script src="/Assets/js/chart-data.js"></script>
	<script src="/Assets/js/easypiechart.js"></script>
	<script src="/Assets/js/easypiechart-data.js"></script>
	<script src="/Assets/js/bootstrap-datepicker.js"></script>
	<script>
		!function ($) {
			$(document).on("click","ul.nav li.parent > a > span.icon", function(){		  
				$(this).find('em:first').toggleClass("glyphicon-minus");	  
			}); 
			$(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})
	</script>	
</body>

</html>
