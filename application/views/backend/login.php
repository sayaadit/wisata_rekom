<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $this->config->item('apps_title') ?></title>
	<base href="<?= base_url() ?>" />

	<!-- Global stylesheets -->
	<link href="assets/backend/fonts/roboto/roboto-v15.css" rel="stylesheet" type="text/css">
	<link href="assets/backend/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="assets/backend/css/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
	<link href="assets/backend/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="assets/backend/css/core.css" rel="stylesheet" type="text/css">
	<link href="assets/backend/css/components.css" rel="stylesheet" type="text/css">
	<link href="assets/backend/css/colors.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->
</head>

<body class="login-container bg-pink-300" style="background-image:url(assets/backend/images/backgrounds/login_cover.jpg)">

	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Content area -->
				<div class="content">
					
                    <!-- Advanced login -->
					<form method="post" action="<?= y_url_admin() ?>/login/exe">
						<div class="panel panel-body login-form">
							<div class="text-center">
								<div class="icon-object border-warning-400 text-warning-400"><i class="icon-people"></i></div>
								<h5 class="content-group-lg">Login Pengguna <?= $this->config->item('apps_name') ?><small class="display-block">Masukkan username dan password anda</small></h5>
							</div>
                            
                            <?php if($this->session->flashdata('errlog')) { ?>
                            <div class="alert alert-danger alert-bordered">
                                <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                                <span class="text-semibold">Username atau Password anda salah</span>. Silahkan coba kembali.
                            </div>
                            <?php } ?>

							<div class="form-group has-feedback has-feedback-left">
								<input type="text" name="username" id="username" class="form-control" placeholder="Username">
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<input type="password" name="password" id="password" class="form-control" placeholder="Password">
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
							</div>

							<div class="form-group">
								<button type="submit" class="btn bg-pink-400 btn-block">Login <i class="icon-circle-right2 position-right"></i></button>
							</div>
						</div>
					</form>
					<!-- /advanced login -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

</body>
</html>