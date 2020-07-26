<style>
.navigation-custom > li > a {
	padding: 1px 20px;
    min-height: 0px;
}

/* Selected Image */
div.selected-image{
	/*padding-top: 1px;
	min-height: 250px;
	position: relative;*/
}
.selected-image-wrapper img{
	display: block;
}
.selected-image-wrapper{
	position: relative;
	cursor: pointer;
}
#selected-image-none {
	width: 285px;
	height: 169px;
	margin: 0px auto;
	border: 1px solid #d9d9d9;
	background: url('assets/backend/images/media/please-select-media.jpg');
	
	-moz-box-shadow: 0px 1px 3px #eee;
	-webkit-box-shadow: 0px 1px 3px #eee;
	box-shadow: 0px 1px 3px #eee;
}
.selected-image ul {
	padding-left:0px;
	list-style:none;
}
.selected-image ul li {
	float: left;
	margin: 0px 15px 15px 0px;
}
.selected-image ul li img{
	width: 160px;
	height: 110px;
}
.selected-image-element{
	position: absolute;
	bottom: 0px;
	right: 0px;
}
.unpick-image{
	width: 21px;
	height: 19px;
	float: left;
	cursor: pointer;
	background: url('assets/backend/images/media/delete-item.png');
}
.edit-image{
	width: 21px;
	height: 19px;
	float: left;
	cursor: pointer;
	background: url('assets/backend/images/media/edit-item.png');
}
.show-media{
	position: absolute;
	bottom: 0px;
	right: 0px;
	margin-right: 20px;
	padding: 3px 12px 3px 12px;
	color: #999;
}
#show-media-text{
	font-size: 10px;
	float: left;
}

.loading-media-image{
	margin: 2px 0px 0px 5px;
	float: left;
	width: 16px;
	height: 11px;
	background: url('assets/backend/images/media/loading2.gif');
}
.slider-detail-wrapper{
	position: absolute;
	z-index: 30;
	margin-left: -179px;
	min-width: 358px;
	top: 10px;
	left: 50%;
	padding: 4px;
	display: none;
	background: url('assets/backend/images/media/edit-slider-boverlay.png');
}.slider-detail{
	padding-top: 7px;
	z-index: 31;
	background: url('assets/backend/images/media/edit-slider-woverlay.png');
}
li.default{
	display: none;
}
li.slider-image-init{
	padding: 5px;
	background-color: #ffffff;
	
	-moz-box-shadow: 1px 1px 4px #ccc;
	-webkit-box-shadow: 1px 1px 4px #ccc;
	box-shadow: 1px 1px 4px #ccc;
}

/* Media Image Gallery 
div.media-image-gallery-wrapper{
	border-top: 1px solid #e5e5e5;
	border-bottom: 1px solid #e5e5e5;
	background: url('assets/backend/images/media/gdl-media-bg.png');
	min-height: 30px;
	margin-top: 20px;
}.media-image-gallery{
	position: relative;
}*/

.media-image-gallery ul{
	margin-top: 0px;
	margin-left: 0px;
	padding-left: 0px;
	list-style:none;
}
.media-image-gallery > ul > li{
	float: left;
	margin: 0px 15px 15px 0px;
}
	
.media-image-gallery ul li img{
	padding: 4px;
	cursor: pointer;
	background-color: #ffffff;
	width: 70px;
	height: 70px;
	display: block;
	
	-moz-box-shadow: 1px 1px 3px #bbb;
	-webkit-box-shadow: 1px 1px 3px #bbb;
	box-shadow: 1px 1px 3px #bbb;
}



.media-title{
	font-weight: bold;
	color: #797979;
	font-size: 14px;
	margin: 30px 0px 0px 20px;
	float: left;
	text-shadow: #fff 2px 2px;
}.media-gallery-nav{
	margin: 0px 20px 0px 20px;
	float: right;
}.media-gallery-nav ul li{
	list-style: none;
	margin: 0px;
	color: #7f7f7f;
	background-color: #ddd;
	margin-left: 8px;
	width: 20px;
	height: 20px;
	text-align: center;
	line-height: 20px;
	border: 1px solid #d4d4d4;
	background-image: url('assets/backend/images/media/gdl-nav-bg.png');
	
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
}.media-gallery-nav ul a li {
	color: #adadad;
	background-color: #f0f0f0;
}.media-gallery-nav ul a li.nav-first{
	color: #adadad;
	background-image: url('assets/backend/images/media/nav-first.png');
}.media-gallery-nav ul a li.nav-last{
	color: #adadad;
	background-image: url('assets/backend/images/media/nav-last.png');	
}.media-gallery-nav ul a:hover li {
	color: #7f7f7f;
	background-color: #ddd;
	cursor: pointer;
}.slider-placeholder{
	float: left;
}
</style>

<form action="<?= $action ?>" method="post" enctype="multipart/form-data">
<?php if($edit) { ?>
<input type="hidden" name="id" id="id" value="<?= $data->post_id ?>">
<?php } ?>
<div class="container-detached">
    <div class="content-detached">
    	<!-- left -->
        <div class="panel panel-default flat border-top-xlg border-success">
            <div class="panel-body">
                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" name="inp[post_title_id]" id="post_title_id" class="form-control" value="<?= $edit ? $data->post_title_id : '' ?>">
                </div>
        
                <div class="form-group">
                    <label>Konten</label>
                    <textarea name="inp[post_content_id]" id="post_content_id" rows="4" cols="4"><?= $edit ? $data->post_content_id : '' ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>Konten Singkat (Preview)</label>
                    <textarea name="inp[post_excerpt_id]" id="post_excerpt_id" class="form-control" rows="4" cols="4"><?= $edit ? $data->post_excerpt_id : '' ?></textarea>
                </div>
            </div>
        </div>
        
        <div class="image-picker" id="image-picker">
            <input type="hidden" class="slider-num" id="slider-num" name="" value="2">
            
            <!-- media picker -->
            <div class="panel panel-default flat border-top-xlg border-success" style="margin-bottom:5px">
                <div class="panel-body media-image-gallery" id="media-image-gallery">
                    <div class="row" style="margin-bottom:10px">
                        <div class="col-md-5">
                            Pilih media yang akan dimasukkan dalam gallery
                        </div>
                        <div class="col-md-7 text-right">
                            <ul class="pagination pagination-separated pagination-xs">
                                <li><a href="#">&lsaquo;</a></li>
                                <li class="active"><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li class="disabled"><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li><a href="#">&rsaquo;</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <ul id="media-container"></ul>
                </div>
            </div>
            
            <!-- selected image -->
            <div class="panel panel-flat">
                <div class="panel-body selected-image" id="selected-image">
                    <div id="selected-image-none"></div>
                    
                    <ul class="ui-sortable">
                        <li id="default" class="default ui-sortable-handle">
                            <div class="selected-image-wrapper">
                                <img src="#">
                                <div class="selected-image-element">
                                    <div id="unpick-image" class="unpick-image"></div>
                                    <br class="clear">
                                </div>
                            </div>
                            <input type="hidden" class="slider-image-url" id="gallery-images-pick">
                        </li>
                        <?php if($edit && !empty($images)) { foreach($images as $image) { ?>
                        <li id="slider-image-init" class="slider-image-init" style="">
                            <div class="selected-image-wrapper">
                                <img src="<?= $image->pg_img ?>" rel="<?= $image->pg_img ?>">
                                <div class="selected-image-element">
                                    <div id="unpick-image" class="unpick-image"></div>
                                    <br class="clear">
                                </div>
                            </div>
                            <input class="slider-image-url" id="gallery-images-pick" name="gallery-images-pick[]" value="<?= $image->pg_img ?>" type="hidden">
                        </li>
                        <?php } } ?>
                    </ul>
                </div>
            </div>
            <!-- end selected image -->    
        </div>  
        
        <!-- tags -->
        <div class="panel panel-white">
            <div class="panel-heading">
                <h5 class="panel-title">Tags</h5>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                    </ul>
                </div>
            </div>

            <div class="panel-body">                
                <div class="form-group">
					<input type="text" value="<?= $edit && !empty($tag) ? $tag->tags : '' ?>" data-role="tagsinput" name="tags" id="tags">
                </div>
            </div>
        </div>
        <!-- end tags -->
        
        <!-- video -->
        <div class="panel panel-white">
            <div class="panel-heading">
                <h5 class="panel-title">SEO (Search Engine Optimization)</h5>
                <div class="heading-elements">
                    <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                    </ul>
                </div>
            </div>

            <div class="panel-body">
                <div class="form-group">
                    <label>Judul SEO</label>
                    <input type="text" name="inp[post_seo_title]" id="post_seo_title" class="form-control" value="<?= $edit ? $data->post_seo_title : '' ?>">
                </div>
                <div class="form-group">
                    <label>Deskripsi SEO (Maksimal 160 karakter)</label>
                    <input type="text" name="inp[post_seo_desc]" id="post_seo_desc" class="form-control" value="<?= $edit ? $data->post_seo_desc : '' ?>">
                </div>
                <div class="form-group">
                    <label>Keywoord (Kata Kunci) SEO (Pisahkan dengan <strong>koma (,)</strong> antar keywoord)</label>
                    <input type="text" name="inp[post_seo_keywoord]" id="post_seo_keywoord" class="form-control" value="<?= $edit ? $data->post_seo_keywoord : '' ?>">
                </div>
            </div>
        </div>
        <!-- end video -->      
        <!-- end left -->

    </div>
</div>

<!-- Detached sidebar -->
<div class="sidebar-detached">
    <div class="sidebar sidebar-default">
        <div class="sidebar-content">
            <!-- Action buttons -->
            <div class="sidebar-category">
                <div class="category-content no-padding">
                    <ul class="navigation navigation-alt navigation-custom navigation-accordion" style="padding-bottom:0px">
                        <li>
                            <a href="javascript:;"><i class="icon-calendar2"></i> <?= $edit ? date('d/m/Y H:i', strtotime($data->post_date)) : date('d/m/Y H:i') ?></a>
                        </li>
                        <li>
                            <a href="javascript:;"><i class="icon-file-check"></i> <?= $edit ? ($data->post_status == 1 ? 'Publish' : 'Non Aktif') : 'Non Aktif' ?></a>
                        </li>
                    </ul>
                </div>
                
                <div class="category-content">
                    <div class="row">
                        <div class="col-xs-6">
                            <button type="submit" class="btn bg-success btn-block btn-float btn-float-lg">
                                <i class="icon-floppy-disk"></i> <span><?= $edit ? 'Update' : 'Publish' ?></span>
                            </button>
                        </div>
                        
                        <div class="col-xs-6">
                            <a href="<?= y_url_admin() ?>/gallery" class="btn bg-pink btn-block btn-float btn-float-lg"><i class="icon-switch"></i> <span>Batal</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /action buttons -->
        </div>
    </div>
</div> 
<!-- end detached sidebar -->
</form>       

<?php $this->load->view('backend/tpl_footer'); ?>
<script type="text/javascript" src="assets/backend/js/plugins/forms/tags/tagsinput.min.js"></script>
<script type="text/javascript" src="assets/backend/js/plugins/forms/tags/tokenfield.min.js"></script>
<script type="text/javascript" src="assets/backend/js/plugins/forms/inputs/typeahead/typeahead.bundle.min.js"></script>

<script src="assets/backend/js/core/libraries/jquery_ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="assets/backend/js/plugins/editors/ckeditor/full/ckeditor.js"></script>

<script type="text/javascript">
var tb 		= '#table';      
var baseurl = '<?= y_url_admin() ?>/ms_kategori';

$(document).ready(function() { 	
	
	CKEDITOR.replace( 'post_content_id', {
        height: '400px',
		fullPage: true,
		allowedContent: true
    });
	
	// Decide to show select-image-none element for each image chooser
	$('.image-picker').each(function(){
		if($(this).find('#selected-image ul').children().size() > 1 ){
			$(this).find('#selected-image-none').css('display','none');
		}
	});
	
	// Bind the edit and delete image button
	$('.edit-image').click(function(){
		$(this).parents('li').find('#slider-detail-wrapper').fadeIn();
	});
	$('.gdl-button#gdl-detail-edit-done').click(function(){
		$(this).parents('#slider-detail-wrapper').fadeOut();
	});
	$('.unpick-image').click(function(){
		$(this).bindImagePickerUnpick();
	});
	$.fn.bindImagePickerUnpick = function(){
		var deleted_image = $(this);
		
		if(confirm('Are you sure to do this?')) {
			deleted_image.parents('li').slideUp('200',function(){
				$(this).remove();
			});
			if ( deleted_image.parents('#image-picker').find('#selected-image ul').children().size() == 2 ){
				deleted_image.parents('#image-picker').find('#selected-image-none').slideDown();
			}
			deleted_image.parents('#image-picker').find('input#slider-num').attr('value',function(){
				return parseInt($(this).attr('value')) - 1;
			});
		}
	};
	
	// Bind the navigation bar and call server using ajax to get the media for each page
	$('div.selected-image ul').sortable({ tolerance: 'pointer', forcePlaceholderSize: true, placeholder: 'slider-placeholder', cancel: '.slider-detail-wrapper' });
	$('.media-gallery-nav ul a li').click(function(){
		$(this).bindImagePickerClickPage();
	});
	$.fn.bindImagePickerClickPage = function(){
		var image_picker = $(this).parents('#image-picker');
		var current_gallery = image_picker.find('#media-image-gallery');
		var paged = $(this).attr('rel');
		current_gallery.slideUp('200');
		image_picker.find('#show-media-text').html('Loading');
		image_picker.find('#show-media-image').addClass('loading-media-image');
		$.post(ajaxurl,{ action:'get_media_image', page: paged },function(data){
			paged='';
			current_gallery.html(data);
			current_gallery.find('ul li img').bind('click',function(){
				$(this).bindImagePickerChooseItem();
			});
			current_gallery.find('#media-gallery-nav ul a li').bind('click',function(){
				$(this).bindImagePickerClickPage();
			});
			current_gallery.slideDown('200');
			image_picker.find('#show-media-text').html('');
			image_picker.find('#show-media-image').removeClass();
		});
	}
	
	// Bind the image when user choose item
	/*$('.image-picker').find('#media-image-gallery').find('ul li img').click(function(){
		$(this).bindImagePickerChooseItem();
	});*/
	
	$('.image-picker').on('click', '#media-image-gallery > ul > li > img', function() {
		$(this).bindImagePickerChooseItem();	
	});
	
	$.fn.bindImagePickerChooseItem = function(){
		var clone = $(this).parents('#image-picker').find('#default').clone(true);
		clone.find('input, textarea, select').attr('name',function(){
			return $(this).attr('id') + '[]';
		});
		clone.attr('id','slider-image-init');
		clone.attr('class','slider-image-init');
		clone.css('display','none');
		clone.find('.slider-image-url').attr('value', $(this).attr('rel')); 
		clone.find('img').attr('src',$(this).attr('rel')); 
		clone.find('img').attr('rel', $(this).attr('rel')); 
		$(this).parents('#image-picker').find('#selected-image-none').slideUp();
		$(this).parents('#image-picker').find('#selected-image ul').append(clone);
		$(this).parents('#image-picker').find('#selected-image ul li').not('#default').slideDown('200');
		$(this).parents('#image-picker').find('input#slider-num').attr('value',function(){
			return parseInt($(this).attr('value')) + 1;
		});
	}
	
	var substringMatcher = function() {
        return function findMatches(q, cb) {
            var matches = [];			
			var strs = get_tags(q);
            
            $.each(strs, function(i, str) {
                matches.push({ value: str });
            });
			
			console.log(matches);
            cb(matches);
        };
    };
	
	$('#tags').tagsinput('input').typeahead(
        {
            hint: true,
            highlight: true,
            minLength: 3
        },
        {
            name: 'states',
            displayKey: 'value',
            source: substringMatcher()
        }
    ).bind('typeahead:selected', $.proxy(function (obj, datum) {  
        this.tagsinput('add', datum.value);
        this.tagsinput('input').typeahead('val', '');
    },  $('#tags') ));
	
	ins_media_load(1);
	
});

function get_tags(q)
{
	var r = [];
	
	$.ajax({
		url:'<?= y_url_admin() ?>/posts/get_tags',
		global:false,
		async:false,
		dataType:'json',
		type:'post',
		data: ({ q : q }),
		success: function(e) {
			r = e;
		},
		error : function() {
			alert('<?= $this->config->item('alert_error') ?>');	 
		}
	});
	
	return r;
}

function ins_media_load(page)
{
	$.ajax({
		url:'<?= y_url_admin() ?>/media/load_json',
		global:false,
		async:false,
		dataType:'json',
		type:'post',
		data: ({ page : page }),
		success: function(e) {
			if(!e.empty)
			{
				var html = '';
				$.each(e.data, function(key, value) {
					html += '<li><img src="'+value.img+'" attid="'+value.id+'" rel="'+value.img+'"></li>';
				});
				
				$('#media-container').html(html);
			}
			else
			{
				ins_full = true;
			}
		},
		error : function() {
			alert('<?= $this->config->item('alert_error') ?>');	 
		},
		beforeSend : function() {
			//$('#loading-img').show();
		},
		complete : function() {
			//$('#loading-img').hide();
		}
	});
}
</script>