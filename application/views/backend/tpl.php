<?php $iuser = y_info_login(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $this->config->item('apps_title') ?></title>
	<base href="<?= base_url() ?>" />   
    
	<link rel="shortcut icon" href="assets/frontend/images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="assets/frontend/images/favicon.ico" type="image/x-icon">

	<!-- Global stylesheets -->
	<link href="assets/backend/fonts/roboto/roboto-v15.css" rel="stylesheet" type="text/css">
	<link href="assets/backend/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="assets/backend/css/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
	<link href="assets/backend/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="assets/backend/css/core.css" rel="stylesheet" type="text/css">
	<link href="assets/backend/css/components.css" rel="stylesheet" type="text/css">
	<link href="assets/backend/css/colors.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->
    
    <style>
	.content {
		padding: 0 10px 80px;
	}
	.page-header-default {
		margin-bottom: 10px;
	}
	.form-group {
		margin-bottom:10px;
	}
	.btn-table {
		padding:2px 8px !important;
		border-radius:0px !important;
	}
	.label-table {
		font-size:11px;
	}
	.center {
		text-align:center;
	}
	
	.yloading {
		width:100%;
		height:100%;
		padding:0px;
		margin:0px;
		top:0px;
		left:0px;
		background-color:rgba(51,51,51,0.5);
		z-index: 130299;
		position: fixed;
		display:none;
	}
	.loader-container {
		width: 150px;
		height: 150px;
		padding: 50px;
		background-color:#232323;
		color:#FFF;
		text-align: center;
		border-radius: 10px !important;
		position: fixed;
		z-index: 130300;
		left: 50%;
		top: 50%;
		margin-left: -150px;
		margin-top: -150px;
		
		box-sizing:content-box !important;
	}
	
	.theme_xbox, .theme_xbox_sm, .theme_xbox_xs {
		width: 100px;
		height: 100px;
	}
	
	.theme_xbox .pace_activity, .theme_xbox_sm .pace_activity, .theme_xbox_xs .pace_activity {
   		width: 150px;
    	height: 150px;
	}
	
	.theme_xbox .pace_activity, .theme_xbox .pace_activity::after, .theme_xbox .pace_activity::before, .theme_xbox_sm .pace_activity, .theme_xbox_sm .pace_activity::after, .theme_xbox_sm .pace_activity::before, .theme_xbox_xs .pace_activity, .theme_xbox_xs .pace_activity::after, .theme_xbox_xs .pace_activity::before {
		border-top-color: #61ED00;
	}
	
	.theme_xbox_with_text span {
		width:150px;
		margin-top: 7px;
	}
	</style>
</head>

<body class="<?= isset($body) && !empty($body) ? $body : '' ?>">
	
    <!-- Loading -->
    <div class="yloading" id="loading-img">
    <div class="loader-container">
        <div class="theme_xbox theme_xbox_with_text">
            <div class="pace_progress" data-progress-text="60%" data-progress="60"></div>
            <div class="pace_activity"></div> <span>LOADING...</span>
        </div>
    </div>
    </div>
    <!-- Loading -->
    
	<!-- Main navbar -->
	<div class="navbar navbar-inverse bg-blue-800">
		<div class="navbar-header">
			<a class="navbar-brand" href="<?= y_url_admin() ?>" style="padding:0px 20px 8px 20px">
            	<img src="assets/frontend/images/travel-crs-retina.png" alt="" style="height:40px; padding-top:0px">
            </a>

			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">
				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>

			<div class="navbar-right">
				<p class="navbar-text"><?= y_greeting('id', 'yes'); ?>, <?= $iuser->user_fullname ?>!</p>
				<p class="navbar-text"><span class="label bg-success-400">Online</span></p>
			</div>
		</div>
	</div>
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			<div class="sidebar sidebar-main sidebar-default">
				<div class="sidebar-content">

					<!-- User menu -->
					<div class="sidebar-user-material">
						<div class="category-content" style="color:#333 !important">
							<div class="sidebar-user-material-content">
								<a href="#"><img src="assets/backend/images/demo/video1.png" class="img-circle img-responsive" alt=""></a>
								<h6><?= $iuser->user_fullname ?></h6>
								<span class="text-size-small"><?= $iuser->user_name ?></span>
							</div>
														
							<div class="sidebar-user-material-menu">
								<a href="#user-nav" data-toggle="collapse"><span>My account</span> <i class="caret"></i></a>
							</div>
						</div>
						
						<div class="navigation-wrapper collapse" id="user-nav">
							<ul class="navigation">
								<li><a href="<?= y_url_admin() ?>"><i class="icon-user-plus"></i> <span>My profile</span></a></li>
								<li class="divider"></li>
								<li><a href="<?= y_url_admin() ?>/login/logout"><i class="icon-switch2"></i> <span>Logout</span></a></li>
							</ul>
						</div>
					</div>
					<!-- /user menu -->


					<!-- Main navigation -->
					<div class="sidebar-category sidebar-category-visible">
						<div class="category-content no-padding">
							<ul class="navigation navigation-main navigation-accordion">
								<li><a href="<?= y_url_admin() ?>/posts"><i class="icon-file-xml"></i> <span>Post Artikel</span></a></li>
                                <li><a href="<?= y_url_admin() ?>/media"><i class="icon-file-picture"></i> <span>Media</span></a></li>
                                <li><a href="<?= y_url_admin() ?>/gallery"><i class="icon-file-picture"></i> <span>Galeri</span></a></li>
                                <li><a href="<?= y_url_admin() ?>/dokumen"><i class="icon-file-text2"></i> <span>Dokumen</span></a></li>
                                <li class="navigation-header"><span>Data Master</span> <i class="icon-menu" title="" data-original-title="Forms"></i></li>
                                <li><a href="<?= y_url_admin() ?>/ms_category"><i class="icon-price-tags2"></i> <span>Master Data Kategori</span></a></li>
                                <li><a href="#"><i class="icon-file-picture"></i> <span>Manajemen User</span></a></li>
							</ul>
						</div>
					</div>
					<!-- /main navigation -->

				</div>
			</div>
			<!-- /main sidebar -->


			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title" style="padding-bottom:10px; padding-top:10px">
							<h4><i class="<?= isset($icon) ? $icon : 'icon-pushpin' ?> position-left"></i> <?= isset($title) ? $title : '' ?></h4>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href=""><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active"><?= isset($title) ? $title : '' ?></li>
						</ul>
                        <?php if(isset($add) && $add) { ?>	
                        <ul class="breadcrumb-elements" style="padding-top:4px">
							<li><button class="btn btn-xs btn-success btn-labeled" style="padding-top:6px; padding-bottom:6px" onClick="add()"><b><i class="icon-add position-left"></i></b>Tambah Data</button></li>
						</ul>
                        <?php } ?>			
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
					<?php $this->load->view($view); ?>

</body>
</html>