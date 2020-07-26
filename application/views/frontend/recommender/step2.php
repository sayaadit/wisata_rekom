<style>
div.list-group-item:hover {
	color:#333;
	background-color:#f5f5f5
}
.list-group-item > a > i {
    margin-right: 7px;
}

</style>
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content">
        <form class="wizard"><div class="steps clearfix"><ul role="tablist">
        	<li role="tab" class="first done" aria-disabled="false" aria-selected="true">
            	<a id="steps-uid-0-t-0" href="recommender" aria-controls="steps-uid-0-p-0">
                    <span class="number">1</span> Pilih Destinasi Wisata
            	</a>
            </li>
            <li role="tab" class="second current" aria-disabled="false" aria-selected="true">
            	<a id="steps-uid-0-t-1" href="javascript:;" aria-controls="steps-uid-0-p-1">                	
                	<span class="current-info audible">current step: </span>
                    <span class="number">2</span> Pilih Hotel dan Preferensi
                </a>
            </li>
            <li role="tab" class="disabled" aria-disabled="true">
            	<a id="steps-uid-0-t-2" href="javascript:;" aria-controls="steps-uid-0-p-2"><span class="number">3</span> Hasil Rekomendasi</a>
            </li>
    	</ul></div></form>
    </div>
</div>
<!-- /page header -->

<!-- Page container -->
<div class="page-container">

<!-- Page content -->
<div class="page-content">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-white border-top-primary border-top-lg">
                <div class="panel-heading">
                    <h6 class="panel-title">Destinasi Wisata Terpilih</h6>
                </div>

                <div class="panel-body" style="min-height:316px">                
                    <div class="list-group no-border" id="rec-list">
                    	<?php foreach($locs as $loc) { ?>
                        <div class="list-group-item" id="rec-list-<?= $loc->post_id ?>" data-dest="<?= $loc->post_id ?>">
                        	<a href="javascript:;" onClick="remove_rec_list('rec-list-<?= $loc->post_id ?>')">
                            	<i class="icon-close2 text-danger"></i>
                            </a> 
							<?= $loc->post_title_id ?>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                
                <div class="panel-footer no-padding">
                    <a href="recommender" class="btn btn-default btn-block no-border">Pilih Ulang Destinasi Wisata</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-white border-top-primary border-top-lg">
                <div class="panel-heading">
                    <h6 class="panel-title">Pilih Hotel dan Algoritma</h6>
                </div>

                <div class="panel-body" style="min-height:350px">
                    <div class="form-group">
                        <label>Pilih salah satu hotel / penginapan sebagai titik awal dan akhir dari perjalanan wisata</label>
                        <?= form_dropdown('hotel', $hotel, '', 'class="form-control select2" id="hotel" required'); ?>
                    </div>	
                    <div class="form-group">
                        <label>Algoritma Rekomendasi</label>
                        <?= form_dropdown('algorithm', $algorithm, '', 'class="form-control select2" id="algorithm" required'); ?>
                    </div>				
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-white border-top-primary border-top-lg">
                <div class="panel-heading">
                    <h6 class="panel-title">Preferensi</h6>
                </div>

                <div class="panel-body" style="min-height:350px">
                    <p><strong>Rute Kunjungan Wisata Yang Bagaimana, Yang Anda Inginkan ? <em>(Masukkan Bobot Antara 0 - 1)</em></strong></p>
                    <div class="form-group">
                        <label>Ingin Mengunjungi Destinasi Wisata Sebanyak Mungkin</label>
                        <input type="text" class="form-control ion-input-slider" id="visit">
                    </div>

                    <div class="form-group">
                        <label>Rte Wisata Yang Meminimalkan Biaya</label>
                        <input type="text" class="form-control ion-input-slider" id="price">
                    </div>

                    <div class="form-group">
                        <label>Ingin Destinasi Wisata Yang Populer</label>
                        <input type="text" class="form-control ion-input-slider" id="rating">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    	<div class="col-md-12">
        	<div class="panel panel-flat panel-body text-center">
            	<button type="button" class="btn bg-blue" onClick="recommendation_step2()">
                    <i class="icon-search4 text-size-base position-left"></i> Rekomendasikan
                </button>
            </div>
        </div>
    </div>

<?php $this->load->view('frontend/tpl_rec_footer'); ?>

<script type="text/javascript" src="assets/backend/js/plugins/sliders/ion_rangeslider.min.js"></script>
	<script type="text/javascript" src="assets/backend/js/plugins/forms/selects/select2.min.js"></script>

<script>
$(function() {	
	$(".ion-input-slider").ionRangeSlider({
        min: 0,
        max: 1,
        from: 1,
		step: 0.1
    });
	
	$('select.select2').select2();
});

function get_destination(id)
{		
	$.ajax({
		url:'recommender/get_destination',
		global:false,
		async:false,
		type:'post',
		data: ({ id : id }),
		success: function(e) {
			$('#destination-list').html(e);
		},
		error : function() {
			alert('<?= $this->config->item('alert_error') ?>');	 
		},
		beforeSend : function() {
			$('#loading-img').show();
		},
		complete : function() {
			$('#loading-img').hide();
		}
	});	
}

function add_rec_list(id, txt)
{
	var html = '<div class="list-group-item" id="rec-list-'+id+'"><a href="javascript:;" onClick="remove_rec_list(\'rec-list-'+id+'\')"><i class="icon-close2 text-danger"></i></a> '+txt+'</div>';
	$('#rec-list').append(html);
}

function remove_rec_list(id)
{
	$('#'+id).remove();
}

function recommendation_step2()
{
	if($('.list-group-item').length <= 1)
	{
		alert("Silahkan pilih destinasi wisata tujuan terlebih dahulu\n(Minimal 2 destinasi wisata)");
		return false;
	}
	
	if($('#hotel').val() == '')
	{
		alert("Silahkan pilih hotel terlebih dahulu");
		return false;
	}
	
	var dest = '';
	$('.list-group-item').each(function(i, obj) {
		dest += $(this).data('dest')+'-';		
	});
	dest = dest.slice(0,-1);
	
	var hotel = $('#hotel').val();
	var visit = $('#visit').val();
	var price = $('#price').val();
	var rating = $('#rating').val();
	var algorithm = $('#algorithm').val();
	
	window.location.href = '<?= base_url() ?>recommender/result?dest='+dest+'&hotel='+hotel+'&visit='+visit+'&price='+price+'&rating='+rating+'&algorithm='+algorithm;
}
</script>
