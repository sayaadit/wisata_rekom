<?php 
$full_url = current_url();

if(isset($seo_images))
	$images = $seo_images;
else
	$images = 'cdn/default-image-fakultas-informatika-universitas-telkom.jpg';
	
list($width, $height, $type) = getimagesize($images);
$images = base_url().$images;

if(isset($seo_title)) 
	$title = $seo_title.' | '.$this->config->item('seo_title');
else	
	$title = $this->config->item('seo_title');
?>

<title><?= $title ?></title>

<meta name="copyright" content="school of computing" itemprop="dateline" />
<meta name="robots" content="index, follow" />
<meta name="platform" content="desktop" />
<meta name="author" content="School of Computing" />
<meta name="description" content="<?= isset($seo_desc) ? $seo_desc : $this->config->item('seo_desc') ?>" itemprop="description" />
<meta name="keywords" content="<?= isset($seo_keyword) ? $seo_keyword : $this->config->item('seo_keyword') ?>" itemprop="keywords" />
<meta content="<?= $title ?>" itemprop="headline" />
<meta content="<?= $full_url ?>" itemprop="url" />
<meta name="thumbnailUrl" content="<?= $images ?>" itemprop="thumbnailUrl" />
<link rel=canonical href="<?= $full_url ?>"/>

<meta property="og:type" content="article" />
<meta property="og:site_name" content="Fakultas Informatika Universitas Telkom" />
<meta property="og:title" content="<?= $title ?>" />
<meta property="og:description" content="<?= isset($seo_desc) ? $seo_desc : $this->config->item('seo_desc') ?>" />
<meta property="og:url" content="<?= $full_url ?>" />
<meta property="og:image" content="<?= $images ?>" />
<!--<meta property="fb:app_id" content="187960271237149" />
<meta property="fb:admins" content="100000607566694" />-->
<meta property="og:image:type" content="image/<?=  y_type_images($type) ?>" />
<meta property="og:image:width" content="<?= $width ?>" />
<meta property="og:image:height" content="<?= $height ?>" />

<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="<?= $title ?>"/>
<meta name="twitter:description" content="<?= isset($seo_desc) ? $seo_desc : $this->config->item('seo_desc') ?>" />
<meta name="twitter:image:src" content="<?= $images ?>" />
<!--<meta name="twitter:site" content="@detikoto" />
<meta name="twitter:site:id" content="@detikoto" />
<meta name="twitter:creator" content="@detikoto" />-->