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
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="assets/frontend_limit/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="assets/frontend_limit/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="assets/frontend_limit/css/core.css" rel="stylesheet" type="text/css">
	<link href="assets/frontend_limit/css/components.css" rel="stylesheet" type="text/css">
	<link href="assets/frontend_limit/css/colors.css" rel="stylesheet" type="text/css">
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
            	<img src="assets/frontend/images/travel-crs.png" alt="" style="height:40px; padding-top:0px">
            </a>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<div class="navbar-right">
				<p class="navbar-text"><?= y_greeting('id', 'yes'); ?>, Users</p>
			</div>
		</div>
	</div>
	<!-- /main navbar -->
	
    <!-- Second navbar -->
	<div class="navbar navbar-default" id="navbar-second">
		<ul class="nav navbar-nav no-border visible-xs-block">
			<li><a class="text-center collapsed" data-toggle="collapse" data-target="#navbar-second-toggle"><i class="icon-menu7"></i></a></li>
		</ul>

		<div class="navbar-collapse collapse" id="navbar-second-toggle">
			<ul class="nav navbar-nav">
				<li class="active"><a href="<?= base_url() ?>"><i class="icon-home2 position-left"></i> Home</a></li>
				<li><a href="<?= base_url() ?>places"><i class="icon-city position-left"></i> Destinasi Wisata</a></li>
				<li><a href="<?= base_url() ?>recommender"><i class="icon-map position-left"></i> Rekomendasi Jadwal Wisata</a></li>
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li>
					<a href="recommender">
						<i class="icon-history position-left"></i> Mulai Rekomendasi Baru
					</a>
				</li>
			</ul>
		</div>
	</div>
	<!-- /second navbar -->
	
    <?php $this->load->view($view); ?>

</body>
</html>