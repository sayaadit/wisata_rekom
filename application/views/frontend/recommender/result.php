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
            	<a id="steps-uid-0-t-0" href="recommender" aria-controls="steps-uid-0-p-0">
                    <span class="number">1</span> Pilih Destinasi Wisata
            	</a>
            </li>
            <li role="tab" class="second done" aria-disabled="false" aria-selected="true">
            	<a id="steps-uid-0-t-1" href="recommender/step2?dest=<?= $this->input->get('dest') ?>" aria-controls="steps-uid-0-p-1">  
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
	
    <?php if($error) { ?>
    <div class="panel panel-danger">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-warning"></i> <span class="text-semibold">Error!</span></h6>
        </div>
        <div class="panel-body">
            <h3 style="text-align:center"><?= $etext ?></h3>
            <?php 
            echo $output;
            // echo $solution;
            echo $fitness;
            // $array_hasil = json_decode($result);
            // $myArray = json_decode($array_hasil);
            // echo ($myArray);
            ?>
            <!-- echo ($json); -->
            <p align="center">
                <a class="btn btn-primary btn-labeled btn-xs" href="recommender/step2?dest=<?= $this->input->get('dest') ?>">
                    <b><i class="icon-chevron-left"></i></b> Kembali
                </a>
                <button type="button" class="btn btn-success btn-labeled btn-xs" onClick="window.location.reload()">
                    <b><i class="icon-sync"></i></b> Ulangi Kembali
                </button>
            </p>
        </div>
    </div>
    <?php } else { ?>
    
    <!-- timeline -->
    <div class="timeline timeline-left"><div class="timeline-container">
        <?php 
		$hari = array('1' => 'Pertama', '2' => 'Kedua', '3' => 'Ketiga');
		for($i=1; $i<=3; $i++) { 
		
		$day = 'day'.$i; 
		if(isset($result->$day->index) && !empty($result->$day->index)) { 
        ?>
        <!-- timeline block 1 -->
        <div class="timeline-row">
            <div class="timeline-icon">
                <div class="bg-info-400">
                    <i class="icon-location4"></i>
                </div>
            </div>
            
            <div class="panel panel-flat border-top-primary border-top-lg">
                <div class="panel-heading">
                    <h6 class="panel-title">Hasil Rekomendasi Perjalanan Wisata Anda: <strong>Hari <?= $hari[$i] ?></h6>
                    <!--<div class="heading-elements">
                        <ul class="icons-list">
                            <li><a data-action="collapse"></a></li>
                            <li><a data-action="reload"></a></li>
                            <li><a data-action="close"></a></li>
                        </ul>
                    </div>-->
                </div>
        
                <div class="panel-body">                    	
                    <div class="row">
                        <div class="col-md-4">
                            <?php $waktu = $result->$day->waktu; ?>
                            <table width="100%" class="table">
                            <tbody>
                                <tr>
                                    <td width="70%">
                                        <div class="media-left media-middle">
                                            <a href="#" class="btn bg-pink btn-rounded btn-icon btn-xs">
                                                <span class="letter-icon">A</span>
                                            </a>
                                        </div>
                                        <div class="media-left">
                                            <div class=""><a href="#" class="text-default text-semibold"><?= $hotel->post_title_id ?></a></div>
                                            <div class="text-muted text-size-small">
                                                <span class="status-mark border-blue position-left"></span>
                                                Berangkat : <?= date('H:i', strtotime($waktu[0])) ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td width="30%"><span class="text-muted">Hotel</span></td>
                                </tr>
                                
                                <?php $dec=66; $iwaktu=1; $index = $result->$day->index; foreach($index as $dx => $d) { $loc = $locs[$d]; ?>
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
                                                <?php $w = strtotime($waktu[$iwaktu]); $k = $loc->post_kunjungan_sec > 0 ? $loc->post_kunjungan_sec : 3600; 
													  echo date('H:i', $w).' - '.date('H:i', $w + $k ); 
													  $iwaktu++; 
												?>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="text-muted">Dest. Wisata</span></td>
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
                                                Sampai Hotel : <?= date('H:i', strtotime($waktu[$iwaktu])) ?>
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
                            
                            <?php $index = $result->$day->index; foreach($index as $dx => $d) { $loc = $locs[$d]; ?>
                            wisata_<?= $day ?>.push({
                                'id' : '<?= $dx ?>',
                                'name' : "<?= $loc->post_title_id ?>",
                                'lat' : '<?= $loc->post_lat ?>', 
                                'long' : '<?= $loc->post_long ?>', 
                            });
                            <?php } ?>
                        </script>
                    </div>						
                </div>
            </div>
        </div>
        <!-- end timeline block 1 -->
        <?php } } ?>
        <script language="javascript">
            var origin_lat  = <?= $hotel->post_lat ?>;
            var origin_long = <?= $hotel->post_long ?>;
        </script>		
	</div></div>
    <!-- end timeline -->
	<?php } ?>
</div>
<!-- /main content -->

<?php $this->load->view('frontend/tpl_rec_footer'); ?>

<script type="text/javascript" src="assets/backend/js/plugins/forms/tags/tagsinput.min.js"></script>
<script type="text/javascript" src="assets/backend/js/plugins/forms/tags/tokenfield.min.js"></script>
<script type="text/javascript" src="assets/backend/js/plugins/ui/prism.min.js"></script>
<script type="text/javascript" src="assets/backend/js/plugins/forms/inputs/typeahead/typeahead.bundle.min.js"></script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA23XyUKzbMG_pYCj50Pef-73RClPQHiDk&libraries=geometry,places"></script>




<script>
var map = [];
var directionsService = [];
var directionsDisplay = [];

$(function() {
	
	for(ix=1; ix<=3; ix++)
	{
		if( $('#map-day'+ix).length > 0 ) {
			maps_recommender_result(ix);
		};
	}

});

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
