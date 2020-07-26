<!-- Main content -->
<div class="content-wrapper">
	
    <div class="timeline timeline-left">
        <div class="timeline-container">
    
            <!-- Sales stats -->
            <div class="timeline-row">
                <div class="timeline-icon">
                    <div class="bg-info-400">
                        <i class="icon-comment-discussion"></i>
                    </div>
                </div>
    
                <div class="panel panel-flat timeline-content">
                    <div class="panel-heading">
                        <h6 class="panel-title">Hari Pertama</h6>
                        <div class="heading-elements">
                            <span class="heading-text"><i class="icon-history position-left text-success"></i> Updated 3 hours ago</span>
    
                            <ul class="icons-list">
                                <li><a data-action="reload"></a></li>
                            </ul>
                        </div>
                    </div>
    
                    <div class="panel-body">
                        <div class="map-container map-basic"></div>
                    </div>
                </div>
            </div>
            <!-- /sales stats -->
            
            <!-- Sales stats -->
            <div class="timeline-row">
                <div class="timeline-icon">
                    <div class="bg-info-400">
                        <i class="icon-comment-discussion"></i>
                    </div>
                </div>
    
                <div class="panel panel-flat timeline-content">
                    <div class="panel-heading">
                        <h6 class="panel-title">Hari Kedua</h6>
                        <div class="heading-elements">
                            <span class="heading-text"><i class="icon-history position-left text-success"></i> Updated 3 hours ago</span>
    
                            <ul class="icons-list">
                                <li><a data-action="reload"></a></li>
                            </ul>
                        </div>
                    </div>
    
                    <div class="panel-body">
                        <div class="map-container map-basic"></div>
                    </div>
                </div>
            </div>
            <!-- /sales stats -->
            
            <!-- Sales stats -->
            <div class="timeline-row">
                <div class="timeline-icon">
                    <div class="bg-info-400">
                        <i class="icon-comment-discussion"></i>
                    </div>
                </div>
    
                <div class="panel panel-flat timeline-content">
                    <div class="panel-heading">
                        <h6 class="panel-title">Hari Ketiga</h6>
                        <div class="heading-elements">
                            <span class="heading-text"><i class="icon-history position-left text-success"></i> Updated 3 hours ago</span>
    
                            <ul class="icons-list">
                                <li><a data-action="reload"></a></li>
                            </ul>
                        </div>
                    </div>
    
                    <div class="panel-body">
                        <div class="map-container map-basic"></div>
                    </div>
                </div>
            </div>
            <!-- /sales stats -->
            
		</div>
	</div>

</div>
<!-- /main content -->

<?php $this->load->view('frontend/tpl_rec_footer'); ?>

<script type="text/javascript" src="assets/backend/js/plugins/forms/tags/tagsinput.min.js"></script>
<script type="text/javascript" src="assets/backend/js/plugins/forms/tags/tokenfield.min.js"></script>
<script type="text/javascript" src="assets/backend/js/plugins/ui/prism.min.js"></script>
<script type="text/javascript" src="assets/backend/js/plugins/forms/inputs/typeahead/typeahead.bundle.min.js"></script>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>

<script>
$(function() {

	var map;

	// Map settings
	function initialize() {

		// Optinos
		var mapOptions = {
			zoom: 12,
			center: new google.maps.LatLng(47.496, 19.037)
		};

		// Apply options
		map = new google.maps.Map($('.map-basic')[0], mapOptions);
	}

	// Load map
	google.maps.event.addDomListener(window, 'load', initialize);

});
</script>
