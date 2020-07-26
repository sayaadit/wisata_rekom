<div class="panel panel-default flat border-top-xlg border-success">
    <table class="table table-bordered table-striped table-hover" id="table">
        <thead>
            <tr>
                <th width="85%">Nama Kategori</th>
                <th width="15%">&nbsp;</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<div class="modal fade" id="frmbox" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success-700">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><i class="fa fa-navicon"></i> &nbsp;<?= 'Form '.$title ?></h4>
            </div>
            <form id="frm" class="form-horizontal">
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="box-body" style="padding-bottom:0px">
                        <div class="form-group form-group-sm">
                            <label for="pus_name" class="col-sm-3 control-label">Nama Kategori</label>
                            <div class="col-sm-9">
                            	<input type="text" class="form-control input-sm" name="inp[cat_name]" id="cat_name" required>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-labeled btn-xs pull-left" data-dismiss="modal">
                	<b><i class="icon-switch"></i></b> Batal
                </button>                
                <button type="button" class="btn btn-success btn-labeled btn-xs" id="act-save" onclick="save('insert')">
                	<b><i class="icon-floppy-disk"></i></b> Simpan
                </button>
        		<button type="button" class="btn btn-success btn-labeled btn-xs" id="act-update" onclick="save('update')">
                	<b><i class="icon-floppy-disk"></i></b> Simpan Perubahan
                </button>
                </div>                  
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="frmboxdel" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success-700">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><i class="fa fa-navicon"></i> &nbsp;<?= 'Form '.$title ?></h4>
            </div>
            <form id="frmdel">
                <input type="hidden" name="cid" id="cid">
                <div class="modal-body">
                    <div class="box-body" style="padding-bottom:0px">
                        <div class="form-group form-group-sm">
                            <label class="control-label">Anda akan menghapus kategori <span id="cname" style="font-weight:bold">Atraksi</span>.<br>
                            Semua artikel dalam kategori tersebut akan dipindahkan kedalam kategori:</label>
                            <div>
                            	<?= form_dropdown('csubstitute', array(), '', 'class="form-control input-xs" id="csubstitute" required'); ?>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-labeled btn-xs pull-left" onClick="del_tdklanjut()">
                	<b><i class="icon-switch"></i></b> Batal
                </button>                
                <button type="button" class="btn btn-success btn-labeled btn-xs" id="act-save" onclick="del_lanjut()">
                	<b><i class="icon-floppy-disk"></i></b> Lanjutkan
                </button>
                </div>                  
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('backend/tpl_footer'); ?>

<script type="text/javascript">
var tb 		= '#table';      
var baseurl = '<?= y_url_admin() ?>/ms_category';

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
		],
		'drawCallback': function(setting) {
			var api = this.api();
			var js = api.rows().data();			
			var html = '';
			$.each(js, function(key, value) {
				html += '<option value="'+value[2]+'">'+value[0]+'</option>';
			});
			$('#csubstitute').html(html);
		}
    });
	
	$('.dataTables_filter input[type=search]').attr('placeholder','Pencarian');

    $('.dataTables_length select').select2({
        minimumResultsForSearch: Infinity,
        width: 'auto'
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
	if($("#frm").valid())
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

function del(id, txt)
{
	if(confirm(' Kategori : '+txt+'\n Apakah anda yakin akan menghapus kategori tersebut ?')) 
	{
		$('#cname').html(txt);
		$("#csubstitute option[value='"+id+"']").remove();
		$('#cid').val(id);
		$('#frmboxdel').modal({keyboard: false, backdrop: 'static'});
	}
}

function del_lanjut()
{
	$.ajax({
		url:baseurl+'/delete',
		global:false,
		type:'post',
		data: ({id : $("#cid").val(), substitute : $("#csubstitute").val() }),
		async:false,
		success: function(e) { 
			if(e == 'ok;') 
			{
				_reload();
				$("#frmboxdel").modal('hide');
			} 
			else alert('Data gagal dihapus, silahkan ulangi kembali');
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

function del_tdklanjut()
{
	_reload();
	$("#frmboxdel").modal('hide');
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