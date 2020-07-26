<div class="td-main-content-wrap td-container-wrap">
<div class="td-container td-post-template-2">
    
    <article id=post-261 class="post-261 post type-post status-publish format-standard has-post-thumbnail hentry category-tagdiv-interiors" itemscope itemtype="https://schema.org/Article">
    
    <!-- header -->
    <div class=td-pb-row>
        <div class=td-pb-span12>
            <div class=td-post-header>
            	
                <div class="td-crumb-container">
                	<div class="entry-crumbs" itemscope itemtype="http://schema.org/BreadcrumbList">
                    	<span class="td-bred-first"><a href="<?= base_url() ?>">Home</a></span> 
                        <i class="td-icon-right td-bread-sep"></i> 
                        
                        <?php if(isset($cats[0])) { $c = $cats[0] ?>
                        <span itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                        	<a title="<?= $c->cat_name ?>" class="entry-crumb" itemscope itemprop="item" itemtype="http://schema.org/Thing" href="<?= y_url_cat($c->cat_id, $c->cat_url) ?>"><span itemprop="name"><?= $c->cat_name ?></span></a>
                        </span> 
                        <i class="td-icon-right td-bread-sep td-bred-no-url-last"></i> 
                        <?php } ?>
                        
                        <span class="td-bred-no-url-last"><?= $data->post_title_id ?></span>
                	</div>
                </div>
                
                <?php if(!empty($cats)) { $color = array('E91E63', 'F44336', '9C27B0', '009688', 'FFC107', '0D47A1', '303F9F');?>
                <ul class=td-category>
                	<?php foreach($cats as $cat) { $cn = array_rand($color); $cc = $color[$cn]; unset($color[$cn]); ?>
                    <li class=entry-category>
                    	<a style="background-color:#<?= $cc ?>;color:#fff;border-color:#<?= $cc ?>" href="<?= y_url_cat($cat->cat_id, $cat->cat_url) ?>">
							<?= $cat->cat_name ?>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
                <?php } ?>
                
            	<header class=td-post-title>
            		<h1 class=entry-title><?= $data->post_title_id ?></h1>
            		<div class=td-module-meta-info>
            			<div class=td-post-author-name>
                        	<div class=td-author-by>By</div> 
                            <a href="<?= base_url() ?>">Travel CRS</a>
                            <div class=td-author-line> - </div> 
                        </div> 
                        <span class="td-post-date">
                        	<time class="entry-date updated td-module-date" datetime="<?= $data->post_date ?>"><?= y_date_text($data->post_date) ?></time>
                        </span> 
                        <div class="td-post-views">
                        	<i class=td-icon-views></i><span class="td-nr-views-<?= $data->post_id ?>"><?= $data->post_views ?></span>
                        </div>
                	</div>
            	</header>
            </div>
        </div>
    </div>
    <!-- end header -->
    
    <!-- row side left & side right -->
    <div class=td-pb-row>
    	<!-- column side left -->
        <div class="td-pb-span8 td-main-content" role=main>
        <div class=td-ss-main-content>
        
            <div class=td-post-content>            
            	<div class=td-post-featured-image>
                	<a href="<?= y_url_read($data->post_id, $data->post_url) ?>" data-caption="<?= $data->post_title_id ?>">
                    	<img width="100%" class="entry-thumb td-modal-image" src="<?= y_image($data->post_img) ?>" sizes="(max-width: 696px) 100vw, 696px" alt="<?= $data->post_title_id ?>" title="<?= $data->post_title_id ?>" />
                    </a>
                </div>
                
                <?= $data->post_content_id ?>
            </div>
        
        	<footer>                        
        		<div class="td-post-sharing td-post-sharing-bottom td-with-like">
            		<span class="td-post-share-title">SHARE</span>
        			<div class="td-default-sharing">
        				<a class="td-social-sharing-buttons td-social-facebook" href="https://www.facebook.com/sharer.php?u=<?= y_url_read($data->post_id, $data->post_url) ?>" onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;">
                        	<i class="td-icon-facebook"></i><div class="td-social-but-text">Facebook</div>
                        </a>
        				<a class="td-social-sharing-buttons td-social-twitter" href="https://twitter.com/intent/tweet?text=<?= $data->post_url ?>&url=<?= y_url_read($data->post_id, $data->post_url) ?>">
                        	<i class="td-icon-twitter"></i><div class="td-social-but-text">Twitter</div>
                        </a>
        				<a class="td-social-sharing-buttons td-social-google" href="https://plus.google.com/share?url=<?= y_url_read($data->post_id, $data->post_url) ?>" onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;">
                        	<i class="td-icon-googleplus"></i>
                        </a>
        				<a class="td-social-sharing-buttons td-social-pinterest" href="https://pinterest.com/pin/create/button/?url=<?= y_url_read($data->post_id, $data->post_url) ?>&amp;media=<?= base_url().$data->post_img ?>&description=<?= $data->post_url ?>" onclick="window.open(this.href, 'mywin','left=50,top=50,width=600,height=350,toolbar=0'); return false;">
                        	<i class="td-icon-pinterest"></i>
                        </a>
        				<a class="td-social-sharing-buttons td-social-whatsapp" href="whatsapp://send?text=<?= $data->post_url ?>%20-%20<?= y_url_read($data->post_id, $data->post_url) ?>">
                        	<i class="td-icon-whatsapp"></i>
                        </a>
        			</div>
        		</div>        
        	</footer>
        
        	<!--<div class="td_block_wrap td_block_related_posts td_color_red td-pb-border-top td_block_template_1">
				<h4 class="td-related-title td-block-title">
                	<a class="td-related-left td-cur-simple-item" href="javascript:;">RELATED ARTICLES</a>
                </h4>
                <div id=td_uid_17_5901289e11a5f class=td_block_inner>
        			<div class=td-related-row>
                    	<?php foreach($related as $rel) { ?>
                        <div class=td-related-span4>
                            <div class="td_module_related_posts td-animation-stack td_mod_related_posts">
                                <div class=td-module-image>
                                    <div class=td-module-thumb>
                                        <a href="<?= y_url_read($rel->post_id, $rel->post_url) ?>" rel="bookmark" title="<?= $rel->post_title_id ?>">
                                            <img width="218" height="150" class="entry-thumb" src="<?= file_exists($rel->post_img) ? $rel->post_img : '' ?>" alt="" title="<?= $rel->post_title_id ?>"/>
                                        </a>
                                    </div>
                                    <a href="<?= y_url_cat($rel->cat_id, $rel->cat_url) ?>" class=td-post-category><?= $rel->cat_name ?></a> 
                                </div>
                                <div class=item-details>
                                    <h3 class="entry-title td-module-title"><a href="<?= y_url_read($rel->post_id, $rel->post_url) ?>" rel="bookmark" title="<?= $rel->post_title_id ?>"><?= $rel->post_title_id ?>
                                    </a></h3>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        
                        
        			</div>
        		</div>
        	</div>-->

        </div>
        </div>
    	<!-- end column side left -->
        
        <!-- column side right -->
        <div class="td-pb-span4 td-main-sidebar" role=complementary>
        <div class=td-ss-main-sidebar>
        	<?php $this->load->view('frontend/_sidebar'); ?>
        </div>
        </div>
        <!-- end column side right -->
    </div>
    </article>

</div>
</div>