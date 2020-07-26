<style>
.table > tbody > tr:last-child > td {
    border-bottom: 1px solid #ddd;
}

.map-basic {
	width:100%;
	height:550px;
}
</style>
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content">
        <form class="wizard"><div class="steps clearfix"><ul role="tablist">
        	<li role="tab" class="first done" aria-disabled="false" aria-selected="true">
            	<a id="steps-uid-0-t-0" href="javascript:;" aria-controls="steps-uid-0-p-0">
                    <span class="number">1</span> Pilih Destinasi Wisata
            	</a>
            </li>
            <li role="tab" class="second done" aria-disabled="false" aria-selected="true">
            	<a id="steps-uid-0-t-1" href="javascript:;" aria-controls="steps-uid-0-p-1">  
                    <span class="number">2</span> Pilih Hotel dan Preferensi
                </a>
            </li>
            <li role="tab" class="third current" aria-disabled="false" aria-selected="true">
            	<a id="steps-uid-0-t-2" href="javascript:;" aria-controls="steps-uid-0-p-2">
                	<span class="current-info audible">current step: </span>
                    <span class="number">3</span> Hasil Rekomendasi
                </a>
            </li>
    	</ul></div></form>
    </div>
</div>
<!-- /page header -->

<!-- Page container -->
<div class="page-container">

<!-- Page content -->
<div class="page-content">

<!-- Main content -->
<div class="content-wrapper">
	
    <div class="panel panel-flat">
        <!--<div class="panel-heading">
            <h6 class="panel-title">Hasil Rekomendasi Perjalanan Wisata Anda</h6>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
        </div>-->

        <div class="panel-body">
            <!----><div class="tabbable">
                <ul class="nav nav-tabs nav-tabs-highlight">
                    <li class="active"><a href="#tab-day1" data-toggle="tab"><i class="icon-menu7 position-left"></i> Hari Pertama</a></li>
                    <?php if(isset($result->day2->index) && !empty($result->day2->index)) { ?>
                    <li><a href="#tab-day2" data-toggle="tab"><i class="icon-mention position-left"></i> Hari Kedua</a></li>
                    <?php } ?>
                    <?php if(isset($result->day3->index) && !empty($result->day3->index)) { ?>
                    <li><a href="#tab-day3" data-toggle="tab"><i class="icon-mention position-left"></i> Hari Ketiga</a></li>
                    <?php } ?>
                </ul>

                <div class="tab-content">
					<?php for($i=1; $i<=3; $i++) { $day = 'day'.$i; if(isset($result->$day->index) && !empty($result->$day->index)) { ?>
                    <div class="tab-pane <?= $i==1 ? 'active' : ''?>" id="tab-<?= $day ?>">                    	
                    	<div class="row">
                        	<div class="col-md-4">
                            	<?php 
									$waktu = $result->$day->waktu; 
									$waktu = $waktu[0]; 
								?>
                            	<table class="table text-nowrap">
                                <tbody>
                                	<tr>
                                        <td>
                                            <div class="media-left media-middle">
                                                <a href="#" class="btn bg-pink btn-rounded btn-icon btn-xs">
                                                    <span class="letter-icon">A</span>
                                                </a>
                                            </div>
                                            <div class="media-left">
                                                <div class=""><a href="#" class="text-default text-semibold"><?= $hotel->post_title_id ?></a></div>
                                                <div class="text-muted text-size-small">
                                                    <span class="status-mark border-blue position-left"></span>
                                                    <?= $waktu[0] ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="text-muted">Hotel</span></td>
                                    </tr>
                                    
									<?php $dec=66; $iwaktu=1; $index = $result->$day->index; foreach($index[0] as $dx => $d) { $loc = $locs[$d]; ?>
                                    <tr>
                                        <td>
                                            <div class="media-left media-middle">
                                                <a href="#" class="btn bg-teal-400 btn-rounded btn-icon btn-xs">
                                                    <span class="letter-icon"><?php echo chr($dec); $dec++; ?></span>
                                                </a>
                                            </div>
                                            <div class="media-left">
                                                <div class=""><a href="#" class="text-default text-semibold"><?= $loc->post_title_id ?></a></div>
                                                <div class="text-muted text-size-small">
                                                    <span class="status-mark border-blue position-left"></span>
                                                    <?php echo $waktu[$iwaktu]; $iwaktu++; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="text-muted">Destinasi Wisata</span></td>
                                    </tr>
                                    <?php } ?>
                                    
                                    <tr>
                                        <td>
                                            <div class="media-left media-middle">
                                                <a href="#" class="btn bg-pink btn-rounded btn-icon btn-xs">
                                                    <span class="letter-icon"><?= chr($dec) ?></span>
                                                </a>
                                            </div>
                                            <div class="media-left">
                                                <div class=""><a href="#" class="text-default text-semibold"><?= $hotel->post_title_id ?></a></div>
                                                <div class="text-muted text-size-small">
                                                    <span class="status-mark border-blue position-left"></span>
                                                    <?= $waktu[$iwaktu] ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="text-muted">Hotel</span></td>
                                    </tr>
                                </tbody>
                            	</table>
                            </div>
                        	<div class="col-md-8">
                        		<div class="map-container map-basic" id="map-<?= $day ?>"></div>
                            </div>
                            <script language="javascript">
								var wisata_<?= $day ?> = [];
								
								<?php $index = $result->$day->index; foreach($index[0] as $dx => $d) { $loc = $locs[$d]; ?>
								wisata_<?= $day ?>.push({
									'id' : '<?= $dx ?>',
									'name' : '<?= $loc->post_title_id ?>',
									'lat' : '<?= $loc->post_lat ?>', 
									'long' : '<?= $loc->post_long ?>', 
								});
								<?php } ?>
							</script>
                    	</div>
                    </div>
                    <?php } } ?>
                    <script language="javascript">
						var origin_lat  = <?= $hotel->post_lat ?>;
						var origin_long = <?= $hotel->post_long ?>;
					</script>				
                </div>
            </div>
        </div><!---->
	</div>

</div>
<!-- /main content -->

<?php $this->load->view('frontend/tpl_rec_footer'); ?>

<script type="text/javascript" src="assets/backend/js/plugins/forms/tags/tagsinput.min.js"></script>
<script type="text/javascript" src="assets/backend/js/plugins/forms/tags/tokenfield.min.js"></script>
<script type="text/javascript" src="assets/backend/js/plugins/ui/prism.min.js"></script>
<script type="text/javascript" src="assets/backend/js/plugins/forms/inputs/typeahead/typeahead.bundle.min.js"></script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBU1ki_pY1AVnOdBKqVSG97F3oW-hjTvh0&libraries=geometry,places"></script>




<script>
var map = [];
var directionsService = [];
var directionsDisplay = [];
var statusx = [];
statusx[1] = true;
statusx[2] = false;
statusx[3] = false;

$(function() {
	
/*statusx.push(true);
statusx.push(true);
statusx.push(true);*/
	
	console.log(statusx[1]);
	
	/*for(ix=1; ix<=3; ix++)
	{
		if( $('#map-day'+ix).length > 0 ) {
			$('a[href="#tab-day'+ix+'"]').on('shown.bs.tab', function(e) {
		if(!statusx[ix])
		{
			console.log(ix);
			maps_recommender_result(ix);
			statusx[ix] = true;
		}
	});
		};
	}*/
	
	maps_recommender_result(1);
	
	$('a[href="#tab-day2"]').on('shown.bs.tab', function(e) {
		if(!statusx[2])
		{
			console.log('aaaa2');
			maps_recommender_result(2);
			statusx[2] = true;
		}
	});
	
	$('a[href="#tab-day3"]').on('shown.bs.tab', function(e) {
		if(!statusx[3])
		{
			console.log('aaaa3');
			maps_recommender_result(3);
			statusx[3] = true;
		}
	});
	
	/*$('a[href="#tab-day1"]').on('shown.bs.tab', function(e) {
		google.maps.event.trigger(map[1], 'resize');
	});
	$('a[href="#tab-day2"]').on('shown.bs.tab', function(e) {
		google.maps.event.trigger(map[2], 'resize');
	});
	$('a[href="#tab-day3"]').on('shown.bs.tab', function(e) {
		google.maps.event.trigger(map[3], 'resize');
	});*/
	
	//maps_recommender_result();

});

/*var map;

// Map settings
function initialize() {

	map = new google.maps.Map(document.getElementById('map-day1'), {
		center: {lat: -34.397, lng: 150.644},
		zoom: 8
	});
}

// Load map
google.maps.event.addDomListener(window, 'load', initialize);*/

function maps_recommender_result(day)
{
	var _latitude = -6.921531365485566;
	var _longitude = 107.61059082222903;
	
	map[day] = new google.maps.Map(document.getElementById('map-day'+day), {
		center: new google.maps.LatLng(_latitude, _longitude),
		zoom: 12
	});
	
	directionsService[day] = new google.maps.DirectionsService();	
	directionsDisplay[day] = new google.maps.DirectionsRenderer();		
	directionsDisplay[day].setMap(map[day]);
	
	var waypts = [];
	var list_wisata = this['wisata_day' + day];
	
	$.each(list_wisata, function(index, value) {
		waypts.push({
			location : new google.maps.LatLng(value.lat, value.long),
			stopover : true
		});
	}); //console.log(waypts);
		
	var request = {
		origin: 			new google.maps.LatLng(origin_lat, origin_long),
		destination: 		new google.maps.LatLng(origin_lat, origin_long),
		waypoints: 			waypts,
		optimizeWaypoints: 	false,
		travelMode: 		google.maps.TravelMode.DRIVING
	};
		
	directionsService[day].route(request, function(response, status) {
		if (status == google.maps.DirectionsStatus.OK) 
		{
			directionsDisplay[day].setDirections(response);
			/*//console.log(wisata[1]);
			var route = response.routes[0]; //console.log(response);
			var orders = route.waypoint_order; //console.log(orders);
			
			// For each route, display summary information.
			var summaryPanel = document.getElementById('directions-panel');
			var dec;
			summaryPanel.innerHTML = '<b>A. Posisi Anda</b> &raquo; ';
			$.each(orders, function(index, order) {
				dec = parseInt(66)+parseInt(index);
				//console.log(order);
				summaryPanel.innerHTML += '<b>'+String.fromCharCode(dec)+'. '+wisata[order].name+'</b> &raquo; ';
			});
			summaryPanel.innerHTML += '<b>'+String.fromCharCode(parseInt(dec)+parseInt(1))+'. Posisi Anda</b>';*/
		}
		else
		{
			alert('Koneksi terganggu, silahkan refresh halaman ini');	
		}
	});
}
</script>
