<div class="box box-success">
    <!--<div class="box-header">
    <h3 class="box-title">Responsive Hover Table</h3>
    </div>--><!-- /.box-header -->
    <div class="box-body">
        <div class="dt-toolbar row">
        	<div class="col-md-8">
            	<a href="javascript:add()" class="btn btn-primary"><i class="fa fa-user-plus"></i> Tambah Data</a>
            </div>
            <div class="col-md-4">
            	<div class="input-group" style="padding:0px">
                    <span class="input-group-addon" style="background-color:#fcfcfc"><i class="fa fa-search"></i></span>
                    <input type="text" class="form-control" placeholder="Pencarian (enter)" name="search" id="search">
                </div>
            </div>
        </div>
        <table id="table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="35%">Nama Lengkap</th>
                    <th width="15%">Username</th>
                    <th width="35%">Userlevel</th>
                    <th width="15%">&nbsp;</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->

<div class="modal fade" id="frmbox" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><i class="fa fa-navicon"></i> &nbsp;<?= 'Form '.$title ?></h4>
            </div>
            <form id="frm" class="form-horizontal">
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="box-body" style="padding-bottom:0px">
                        <div class="form-group">
                            <label for="pus_name" class="col-sm-3 control-label">Nama Lengkap</label>
                            <div class="col-sm-9">
                            	<input type="text" class="form-control" name="inp[user_fullname]" id="user_fullname" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pus_name" class="col-sm-3 control-label">Username</label>
                            <div class="col-sm-9">
                            	<input type="text" class="form-control" name="inp[user_name]" id="user_name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pus_name" class="col-sm-3 control-label">User Level</label>
                            <div class="col-sm-9">
                            	<?= form_dropdown('inp[user_level]', $level, '', 'class="form-control" id="user_level"'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pus_name" class="col-sm-3 control-label">Password</label>
                            <div class="col-sm-9">
                            	<input type="password" class="form-control" name="inp[user_password]" id="user_password" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pus_name" class="col-sm-3 control-label">Ulangi Password</label>
                            <div class="col-sm-9">
                            	<input type="password" class="form-control" name="repassword" id="repassword" required>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><i class="fa fa-power-off"></i> Batal</button>
                
                <button type="button" class="btn btn-success" id="act-save" onclick="save('insert')"><i class="fa fa-save"></i> Simpan</button>
        		<button type="button" class="btn btn-success" id="act-update" onclick="save('update')"><i class="fa fa-save"></i> Update</button>
                </div>                  
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('tpl_footer'); ?>
<script type="text/javascript" src="assets/plugins/datatables/media/js/dataTables.defaultajax.js"></script>

<script>
var tb 		= '#table';      
var baseurl = 'ms_users';
var form1   = $('#frm');
var validator = form1.validate();
var dt;

$(document).ready(function() {	
	dt = $(tb).DataTable( {
        'dom': "<'dt-tabletools'T>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",
		'ajax': {
            'url': baseurl+'/json'
        },
		'order':[
			[0, 'asc']
		],
		'columnDefs': [ 
			{ 'targets': 3, 'searchable': false, 'orderable': false, 'className': 'center' } 
		]
    } );
	
	//dt.order([ 1, 'asc' ]).draw();
	
	$('input#search').keypress(function(e) {
		if(e.keyCode==13)
			$(tb).dataTable().fnFilter( $('input#search').val() );
	});
});
	
function add()
{
	_reset();
	$('#act-save').show();
	$('#act-update').hide();
	$('#frmbox').modal({keyboard: false, backdrop: 'static'});
}

function edit(id)
{		
	$.ajax({
		url:baseurl+'/edit',
		global:false,
		async:false,
		dataType:'json',
		type:'post',
		data: ({ id : id }),
		success: function(e) {
			_reset();
			$('#act-save').hide();
			$('#act-update').show();
			$('#id').val(id);
			$.each(e, function(key, value) {
				$('#'+key).val(value);
			});
			$('#user_password').val('');
			$('#user_password').removeAttr('required');
			$('#repassword').removeAttr('required');
			$('#frmbox').modal({keyboard: false, backdrop: 'static'});
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

function save(url)
{
	if(form1.valid())
	{
		$.ajax({
			url:baseurl+'/'+url,
			global:false,
			async:false,
			type:'post',
			data: $('#frm').serialize(),
			success : function(e) {
				if(e == 'ok;') 
				{
					_reload();
					$("#frmbox").modal('hide');
				} 
				else alert('Data gagal disimpan, silahkan ulangi lagi');
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
}

function del(id)
{
	if(confirm(' ID = '+id+'\n Apakah anda yakin akan menghapus data tersebut ?')) {
	$.ajax({
		url:baseurl+'/delete',
		global:false,
		type:'post',
		data: ({id : id}),
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

function _reset()
{
	validator.resetForm();
	$("label.error").hide();
 	$(".error").removeClass("error");
	$('#frm')[0].reset();
}

function _reload()
{
	$(tb).dataTable().fnDraw();
}
</script>