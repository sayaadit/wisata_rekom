<div class="td-a-rec td-a-rec-id-sidebar">
	<?php if(isset($homepage) && $homepage) { ?><span class="td-adspot-title">- Travel CRS Application -</span><?php } ?>
    <div class="td-visible-desktop">
		<a href="<?= base_url() ?>recommender">
        	<img class="td-retina" style="max-width:300px" src="assets/frontend/images/banner1.jpg" alt="" width="300" height="250">
        </a>
	</div>
    <div class="td-visible-tablet-landscape">
    	<a href="<?= base_url() ?>recommender">
        	<img class="td-retina" style="max-width:300px" src="assets/frontend/images/banner1.jpg" alt="" width="300" height="250">
        </a>
    </div>
    <div class="td-visible-tablet-portrait">
    	<a href="<?= base_url() ?>recommender">
        	<img class="td-retina" style="max-width:200px" src="https://demo.tagdiv.com/newspaper/wp-content/uploads/2016/01/rec200.jpg" alt="" width="200" height="200">
        </a>
    </div>
    <div class="td-visible-phone">
    	<a href="<?= base_url() ?>recommender">
        	<img class="td-retina" style="max-width:300px" src="assets/frontend/images/banner1.jpg" alt="" width="300" height="250">
        </a>
    </div>
</div>

<?php $cats = $this->db->query("SELECT * FROM ms_category ORDER BY cat_name ASC")->result(); ?>
<div class="td_block_wrap td_block_popular_categories td_color_blue widget widget_categories td-pb-border-top td_block_template_1">
	<h4 class="block-title"><span class="td-pulldown-size">POPULAR CATEGORY</span></h4>
    <ul class="td-pb-padding-side">
    	<?php foreach($cats as $cat) { ?>
    	<li><a href="<?= y_url_cat($cat->cat_id, $cat->cat_url) ?>"><?= $cat->cat_name ?><span class="td-cat-no"><?= $cat->cat_count ?></span></a></li>
        <?php } ?>
    </ul>
</div>

<?php 
if(!isset($homepage) || !$homepage) { 
	$posts = $this->db->query("SELECT * FROM posts WHERE post_type = 'location' ORDER BY post_date DESC LIMIT 0, 4")->result();
?>
<!-- sidebar 2 - event -->
<div class="td_block_wrap td_block_15 td_color_blue td_with_ajax_pagination td-pb-border-top td_block_template_1 td-column-1 td_block_padding">
    <div class="td-block-title-wrap">
        <h4 class="block-title"><span class="td-pulldown-size">DESTINASI WISATA TERUPDATE</span></h4>
    </div>
    <div class="td_block_inner td-column-1">
    	<?php for($row=0; $row<=1; $row++) { ?>
        <div class="td-cust-row">
        	<?php 
			$start = $row*2; for($col=$start; $col<=$start+1; $col++) { 
			if(isset($posts[$col]) && !empty($posts[$col])) { 
            $post = $posts[$col];  
			?>
        	<div class="td-block-span12">
            <div class="td_module_mx4 td_module_wrap td-animation-stack">
                <div class="td-module-image">
                    <div class="td-module-thumb">
                    <a href="<?= y_url_read($post->post_id, $post->post_url) ?>" rel="bookmark" title="<?= $post->post_title_id ?>">
                    	<img width="218" height="150" class="entry-thumb" src="<?= y_image($post->post_img, 'small') ?>" alt="" title="<?= $post->post_title_id ?>"/>
                    </a>
                    </div> 
                </div>
            	<h3 class="entry-title td-module-title">
                	<a href="<?= y_url_read($post->post_id, $post->post_url) ?>" rel="bookmark" title="<?= $post->post_title_id ?>">
						<?= $post->post_title_id ?>
                    </a>
                </h3>
            </div>
        	</div>
            <?php } } ?>
        </div>
        <?php } ?>
        
        <div class="td-load-more-wrap">
        	<a href="<?= base_url() ?>places" class="td_ajax_load_more td_ajax_load_more_js">Selengkapnya <i class="td-icon-font td-icon-menu-down"></i></a>
        </div>
	</div>
</div>
<!-- end sidebar 2 - event -->
<?php } ?>