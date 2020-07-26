<div class="panel panel-default flat border-top-xlg border-success">
    <table class="table table-bordered table-striped table-hover" id="table">
        <thead>
            <tr>
                <th width="15%">Tanggal</th>
                <th width="40%">Judul</th>
                <th width="15%">Tipe</th>
                <th width="15%">Status</th>
                <th width="15%">&nbsp;</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<?php $this->load->view('backend/tpl_footer'); ?>

<script type="text/javascript">
var tb 		= '#table';      
var baseurl = '<?= y_url_admin() ?>/gallery';

$(document).ready(function() {	
    $(tb).dataTable({
        'ajax': {
            'url':baseurl+'/json'
		},
		'order':[
			[0, 'asc']
		],
		'columnDefs': [ 
			{ 'targets': -1, 'searchable': false, 'orderable': false, 'className': 'center' } 
		]
    });
	
	$('.dataTables_filter input[type=search]').attr('placeholder','Pencarian');

    $('.dataTables_length select').select2({
        minimumResultsForSearch: Infinity,
        width: 'auto'
    });
});
	
function add()
{
	window.location.href = baseurl+'/form';
}

function publish(id, status)
{
	if(confirm(' ID = '+id+'\n Apakah anda yakin akan '+(status == 1 ? 'publish' : 'unpublish')+' postingan tersebut ?')) {
	$.ajax({
		url:baseurl+'/publish',
		global:false,
		type:'post',
		data: ({id : id, status : status}),
		async:false,
		success: function() { _reload(); },
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
}

function _reload()
{
	$(tb).dataTable().fnDraw();
}
</script>