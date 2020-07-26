<div class="td-main-content-wrap td-main-page-wrap td-container-wrap">
<div class="td-container tdc-content-wrap">   
    
    <!-- row side left & side right -->
    <div class="vc_row wpb_row td-pb-row td-ss-row">
        <!-- column side left -->
        <div class="wpb_column vc_column_container td-pb-span8">
        <div class="vc_column-inner ">
        <div class=wpb_wrapper>
        
			<!-- Block Feature -->
            <div class="td_block_wrap td_block_2 td_color_red td_with_ajax_pagination td-pb-border-top td_block_template_1 td-column-2 td_block_padding" data-td-block-uid=td_uid_16_58ef3b8324847>
                <div class=td-block-title-wrap>
                    <h4 class=block-title><span class=td-pulldown-size>MOST RECOMMENDATION</span></h4>
                </div>
                
                <div class="td_block_inner">
                    <div class="td-block-row">
                    	<?php for($col=0; $col<=1; $col++) { 
						if(isset($popular[$col]) && !empty($popular[$col])) { 
						$b = $popular[$col]; ?>
                        <div class="td-block-span6">
                            <div class="td_module_2 td_module_wrap td-animation-stack">
                                <div class="td-module-image">
                                    <div class="td-module-thumb">
                                    	<a href="<?= y_url_read($b->post_id, $b->post_url) ?>" rel="bookmark" title="<?= $b->post_title_id ?>">
                                    	<img class="entry-thumb" src="<?= y_image($b->post_img, 'medium') ?>" alt="<?= $b->post_title_id ?>" title="<?= $b->post_title_id ?>" width="324" height="160" />
                                    	</a>
                                    </div> 
                                    <a href="<?= y_url_cat($b->cat_id, $b->cat_url) ?>" class=td-post-category><?= $b->cat_name ?></a> 
                                </div>
                                <h3 class="entry-title td-module-title">
                                    <a href="<?= y_url_read($b->post_id, $b->post_url) ?>" rel=bookmark title="<?= $b->post_title_id ?>"><?= $b->post_title_id ?></a>
                                </h3>
                                <div class=td-module-meta-info>
                                    <span class=td-post-author-name>
                                        <a href="<?= base_url() ?>">Travel CRS</a> 
                                        <span>-</span> 
                                    </span> 
                                    <span class=td-post-date><time class="entry-date updated td-module-date" datetime="<?= $b->post_date ?>"><?= y_date_text($b->post_date) ?></time></span> 
                                    <div class=td-module-comments><a href="<?= y_url_read($b->post_id, $b->post_url) ?>"><?= $b->post_views ?></a></div> 
                                </div>
                                <div class=td-excerpt><?= !empty($b->post_excerpt_id) ? y_ellipsis($b->post_excerpt_id, 70) : y_ellipsis($b->post_content_id, 70) ?></div>
                            </div>
                        </div>
                        <?php } } ?>
                    </div>
                    
                    <?php for($row=1; $row<=2; $row++) { ?>
                    <div class="td-block-row">
                    	<?php $start = $row*2; for($col=$start; $col<=$start+1; $col++) { 
						if(isset($popular[$col]) && !empty($popular[$col])) { 
						$b = $popular[$col];  ?>
                        <div class="td-block-span6">
                            <div class="td_module_6 td_module_wrap td-animation-stack">
                            	<div class="td-module-thumb" style="width:100px; height:70px; overflow:hidden">
                                	<a href="<?= y_url_read($b->post_id, $b->post_url) ?>" rel="bookmark" title="<?= $b->post_title_id ?>">
                                    <img height="100%" style="height:100%; max-width:none" class="entry-thumb" src="<?= y_image($b->post_img, 'thumbnail') ?>" alt="<?= $b->post_title_id ?>" title="<?= $b->post_title_id ?>"/>
                                    </a>
                                </div>
                                <div class="item-details">
                                    <h3 class="entry-title td-module-title"><a href="<?= y_url_read($b->post_id, $b->post_url) ?>" rel="bookmark" title="<?= $b->post_title_id ?>"><?= $b->post_title_id ?></a></h3> 
                                    <div class="td-module-meta-info">
                                    	<span class="td-post-date"><time class="entry-date updated td-module-date" datetime="<?= $b->post_date ?>"><?= y_date_text($b->post_date) ?></time></span> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } } ?>
                    </div>
                    <?php } ?>
                    
                </div>
            </div>
            <!-- END Block Feature -->
            
            <!-- Block Blog -->
            <div class="td_block_wrap td_block_11 td_color_blue td_uid_56_59716fa9c29c8_rand td-pb-border-top td_block_template_1 td-column-2">
                <div class="td-block-title-wrap">
                    <h4 class="block-title"><span class="td-pulldown-size">DESTINASI WISATA</span></h4>
                </div>
                <div class="td_block_inner">
					<?php if(!empty($last)) { foreach($last as $l) { ?>
                    <div class="td-block-span12">
                    <div class="td_module_10 td_module_wrap td-animation-stack">
                    	<div class="td-module-thumb">
                        	<a href="<?= $l->post_title_id ?>" rel="bookmark" title="<?= $l->post_title_id ?>">
                            <img width="218" height="150" class="entry-thumb" src="<?= y_image($l->post_img, 'thumbnail') ?>" alt="" title="<?= $l->post_title_id ?>"/>
                            </a>
                        </div>
                        <div class="item-details">
                        	<h3 class="entry-title td-module-title"><a href="<?= y_url_read($l->post_id, $l->post_url) ?>" rel="bookmark" title="<?= $l->post_title_id ?>"><?= $l->post_title_id ?></a></h3>
                        	<div class="td-module-meta-info">
                        		<span class="td-post-author-name"><a href="<?= base_url() ?>">Travel CRS</a> <span>-</span> </span> 
                                <span class="td-post-date"><time class="entry-date updated td-module-date" datetime="<?= $l->post_date ?>"><?= y_date_text($l->post_date) ?></time></span> 
                                <div class=td-module-comments><a href="<?= y_url_read($l->post_id, $l->post_url) ?>"><?= $l->post_views ?></a></div> 
                            </div>
                        	<div class="td-excerpt"><?= !empty($l->post_excerpt_id) ? y_ellipsis($l->post_excerpt_id, 200) : y_ellipsis($l->post_content_id, 200) ?> [...]</div>
                        </div>
                    </div>
                    </div>
                    <?php } } ?> 
                </div>
            </div>
            <div class="td-load-more-wrap">
                <a href="<?= base_url() ?>places" class="td_ajax_load_more td_ajax_load_more_js">Selengkapnya <i class="td-icon-font td-icon-menu-down"></i></a>
            </div>
            <!-- END Block Blog -->
    
        </div>
        </div>
        </div>
        <!-- end column side left -->   
        
        <!-- column side right -->
        <div class="wpb_column vc_column_container td-pb-span4">
        <div class="vc_column-inner ">
        <div class=wpb_wrapper>
            <?php $this->load->view('frontend/_sidebar'); ?>
        </div>
        </div>
        </div>
        <!-- end column side right -->
    
    </div>
    <!-- row side left & side right -->

</div>
</div>