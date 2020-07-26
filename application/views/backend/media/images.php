<div class="row" style="padding-left:15px">
	<?php $thumb = $this->config->item('thumb'); ?>
	<?php foreach($data as $row) { ?>
    <div class="col-lg-3 col-sm-3 col-xs-3" style="width:125px; height:100px; padding-right:5px; padding-left:0px; margin-bottom:5px; padding-bottom:0px; overflow:hidden">
        <div class="thumbnail" style="margin-bottom:5px">
            <div class="thumb" style="height:91px; overflow:hidden; background-color:#efefef">
                <?php if($row->media_type == 'image') { ?>
                <img src="<?= file_exists($row->media_path.$row->media_url.'-'.$thumb['medium']['width'].'x'.$thumb['medium']['height'].'.'.$row->media_ext) ? $row->media_path.$row->media_url.'-'.$thumb['medium']['width'].'x'.$thumb['medium']['height'].'.'.$row->media_ext : 'assets/backend/images/noimages/no.jpg' ?>" alt="<?= $row->media_name ?>">
                <div class="caption-overflow">
                    <span>
                        <button class="btn border-white text-white btn-flat btn-icon btn-rounded details" data-filename="<?= $row->media_file ?>" data-date="<?= y_date_text($row->media_date) ?>" data-type="<?= $row->media_type ?>" data-ext="<?= $row->media_ext ?>" data-resolution="1000x1000" data-size="12.3Mb" data-img="<?= $row->media_path.$row->media_file ?>"><i class="icon-plus3"></i></button>
                        <button onclick="del(<?= $row->media_id ?>)" class="btn border-white text-white btn-flat btn-icon btn-rounded ml-5"><i class="icon-trash"></i></button>
                    </span>
                </div>
                <?php } else { ?>
                <img src="assets/backend/images/noimages/<?= $row->media_ext ?>.jpg" alt="<?= $row->media_name ?>">
                <div class="caption-overflow">
                    <span>
                        <button class="btn border-white text-white btn-flat btn-icon btn-rounded details" data-filename="<?= $row->media_file ?>" data-date="<?= y_date_text($row->media_date) ?>" data-type="<?= $row->media_type ?>" data-ext="<?= $row->media_ext ?>" data-resolution="1000x1000" data-size="12.3Mb" data-img="assets/backend/images/noimages/<?= $row->media_ext ?>.jpg"><i class="icon-plus3"></i></button>
                        <button onclick="del(<?= $row->media_id ?>)" class="btn border-white text-white btn-flat btn-icon btn-rounded ml-5"><i class="icon-trash"></i></button>
                    </span>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php } ?>
</div>

<div class="row text-center" style="padding-left:15px">
	<input type="hidden" name="paged" id="paged" value="<?= $paged ?>">
	<?php 
	$limit = 40;
	if($count > $limit)
	{
		$jml = ceil($count/$limit);
	?>
    <ul class="pagination pagination-separated">
        <li><a href="<?= $paged > 1 ? 'javascript:reloaded('.($paged-1).')' : 'javascript:;' ?>">&lsaquo;</a></li>
        <?php for($page = 1; $page <= $jml; $page++) { ?>
        <li <?= $page == $paged ? 'class="active"' : '' ?>><a href="javascript:reloaded(<?= $page ?>)"><?= $page ?></a></li>
        <?php } ?>
        <li><a href="<?= $paged < $jml ? 'javascript:reloaded('.($paged+1).')' : 'javascript:;' ?>">&rsaquo;</a></li>
    </ul>
    <?php } ?>
</div>