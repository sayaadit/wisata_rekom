<div class="td-category-header td-container-wrap">
    <div class="td-container">
        <div class="td-pb-row">
            <div class="td-pb-span12">
            	<div class="td-crumb-container">
                	<div class="entry-crumbs">
                    	<span class="td-bred-first"><a href="<?= base_url() ?>">Home</a></span> 
                        <i class="td-icon-right td-bread-sep"></i> 
                        <span class="td-bred-no-url-last"><?= $title ?></span>
                    </div>
                </div>
            	<h1 class="entry-title td-page-title"><?= $title ?></h1>
                
                <div class="td-category-pulldown-filter td-wrapper-pulldown-filter"><div class="td-pulldown-filter-display-option"><div class="td-subcat-more"><i class="td-icon-comments"></i> &nbsp; <?= $count ?> Post</div></div></div>
                
            </div>
        </div>
    </div>
</div>


<div class="td-main-content-wrap td-container-wrap" style="padding-top:26px">
<div class="td-container">
	<!-- row side left & side right -->
    <div class="td-pb-row">
    	<!-- column side left -->
        <div class="td-pb-span8 td-main-content">
            <div class="td-ss-main-content">
            	<?php if(empty($data)) { ?>
                <div class="no-results td-pb-padding-side"><h2>No posts to display</h2></div>                                                                    
                <?php } else { ?>
                <?php for($row=0; $row<5; $row++) { ?>
                <div class=td-block-row>
                	<?php 
					for($col=$row*2; $col<($row*2)+2; $col++) { 
						if(isset($data[$col]) && !empty($data[$col])) { 
							$d = $data[$col]; 
					?>
                    <div class="td-block-span6"><div class="td_module_2 td_module_wrap td-animation-stack">
                        <div class="td-module-image">
                        	<div class="td-module-thumb" style="width:324px; height:160px; overflow:hidden; background-color:#EFEFEF">
                                <a href="<?= y_url_read($d->post_id, $d->post_url) ?>" rel="bookmark" title="<?= $d->post_title_id ?>">
                                    <img class="entry-thumb" src="<?= y_image($d->post_img, 'medium') ?>" title="<?= $d->post_title_id ?>" />
                                </a>
                            </div> 
                            <a href="<?= y_url_cat($d->cat_id, $d->cat_url) ?>" class="td-post-category"><?= $d->cat_name ?></a> 
                        </div>
                    	<h3 class="entry-title td-module-title">
                        	<a href="<?= y_url_read($d->post_id, $d->post_url) ?>" rel="bookmark" title="<?= $d->post_title_id ?>">
                            	<?= $d->post_title_id ?>
                            </a>
                        </h3>
                        <div class="td-module-meta-info">
                            <span class="td-post-author-name">
                                <a href="<?= base_url() ?>">Travel CRS</a> 
                                <span>-</span> 
                            </span> 
                            <span class="td-post-date">
                            	<time class="entry-date updated td-module-date" datetime="<?= $d->post_date ?>">
									<?= y_date_text($d->post_date) ?>
                                </time>
                            </span> 
                            <div class="td-module-comments">
                            	<a href="<?= y_url_read($d->post_id, $d->post_url) ?>"><?= $d->post_views ?></a>
                            </div> 
                        </div>
                        <div class="td-excerpt"><?= !empty($d->post_excerpt_id) ? y_ellipsis($d->post_excerpt_id, 100) : y_ellipsis($d->post_content_id, 100) ?></div>
                    </div></div>
                    <?php } } ?>
                </div>
                <?php } } ?>
                                
                <?= $this->paging->show(); ?>
                
            </div>
        </div>
        <!-- end column side left -->
        
        <!-- column side right -->
        <div class="td-pb-span4 td-main-sidebar">
        <div class=td-ss-main-sidebar>
        	<div class="clearfix"></div>
        	<?php $this->load->view('frontend/_sidebar'); ?>
        </div>
        </div>
        <!-- end column side right -->
    </div>
</div>
</div>