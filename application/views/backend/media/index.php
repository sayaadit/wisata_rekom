<div id="image-container"></div>

<div class="modal fade" id="frmbox" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header bg-pink">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><i class="fa fa-navicon"></i> &nbsp;<?= 'Form '.$title ?></h4>
            </div>
            <div class="modal-body" id="dropzone-container"></div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="frmboxdetail" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-pink">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><i class="fa fa-navicon"></i> &nbsp;<?= 'Form '.$title ?></h4>
            </div>
            <div class="modal-body">
            	<div class="row">
                	<div class="col-md-7" style="background-color:#efefef; min-height:200px">
                    	<img class="images-preview">
                    </div>
                    <div class="col-md-5"><form class="form-horizontal" action="#">
                    	<div class="form-group">
                            <label class="col-lg-3 control-label">Filename:</label>
                            <div class="col-lg-9">
                                <div class="form-control-static" id="filename" style="word-wrap: break-word;"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Date:</label>
                            <div class="col-lg-9">
                                <div class="form-control-static" id="date"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Type:</label>
                            <div class="col-lg-9">
                                <div class="form-control-static" id="type"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Size:</label>
                            <div class="col-lg-9">
                                <div class="form-control-static" id="resolution"></div>
                            </div>
                        </div>
                    </form></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-power-off"></i> Batal</button>
                
                <button type="button" class="btn btn-success" id="act-save" onclick="save('insert')"><i class="fa fa-save"></i> Copy URL</button>
            </div> 
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('backend/tpl_footer'); ?>
<script type="text/javascript" src="assets/backend/js/plugins/uploaders/dropzone.min.js"></script>

<script type="text/javascript">
var tb 		= '#table';      
var baseurl = '<?= y_url_admin() ?>/media';
var count_image = 0;
var pages = 1;

$(document).ready(function() {	
    $('#frmbox').on('hidden.bs.modal', function () {
    	if(count_image > 0)
		{
			reloaded($('#paged').val());
		}
		count_image = 0;
	});
	
	reloaded(pages);
	
	$('.details').click(function() {
		detail($(this));
	});
});
	
function add()
{
	$('#dropzone-container').empty();
	$('#dropzone-container').html('<p>Silahkan drag dan drop file anda disini</p><form class="dropzone" id="dropzone_multiple" enctype="multipart/form-data"></form>');
	
	Dropzone.autoDiscover = false;

	$("#dropzone_multiple").dropzone({
		url: '<?= y_url_admin() ?>/media/insert',
		method: 'post',
		paramName: "file",
		acceptedFiles: "image/*,application/pdf,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/vnd.ms-powerpoint,application/zip,application/x-rar-compressed,text/plain",
		addRemoveLinks: true,
		thumbnailWidth:"165", 
		thumbnailHeight:"100",
		dictDefaultMessage: 'Drop file anda disini <span>atau CLICK DISINI</span>',
		
		removedfile: function(file) {
			var token = file.token;    
			if(file.serverFileName!=undefined) var name = file.serverFileName; 
			$.ajax({
				type: 'POST',
				url:'<?= y_url_admin() ?>/media/delete_token',
				data:{token:token},
				success: function() {
					count_image--;
					var _ref;
					return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
				},
				error: function() {
					alert('<?= $this->config->item('alert_error') ?>');
				}
			});        
		},
		
		init: function() {
			thisDropzone = this;
      
			this.on("sending",function(a,b,c) {
				a.token = Math.random();
				c.append("token_foto", a.token);
			});
			
			this.on("addedfile", function(file) {
				
			});
			
			this.on("success", function(file, response) {
				var obj = JSON.parse(response);
				if(obj.status)
				{
					var aa = file.previewElement.querySelector("[data-dz-name]");
					aa.dataset.dzName = obj.name;
					file.serverFileName = obj.name;
					aa.innerHTML = obj.name;
					
					count_image++;
				}
				else
				{
					var node, _i, _len, _ref, _results;
					var message = obj.error; // modify it to your error message
					file.previewElement.classList.add("dz-error");
					_ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
					_results = [];
					for (_i = 0, _len = _ref.length; _i < _len; _i++) 
					{
						node = _ref[_i];
						_results.push(node.textContent = message);
					}
					
					return _results;
				}
			});
		}          
	});
	
	$('#frmbox').modal({keyboard: false, backdrop: 'static'});
}

function reloaded(page)
{		
	$.ajax({
		url:baseurl+'/load',
		global:false,
		async:false,
		type:'post',
		data: ({ page : page }),
		success: function(e) {
			pages = page;
			$('#image-container').html(e);
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

function detail(items)
{
	$('div#filename').html(items.data('filename'));
	$('div#date').html(items.data('date'));
	$('div#type').html(items.data('type')+' (.'+items.data('ext')+')');
	$('div#resolution').html(items.data('size')+' ('+items.data('resolution')+')');
	$('.images-preview').attr('src', items.data('img'));
	if(items.data('type') == 'image')
		$('.images-preview').attr('src', items.data('img')).attr('width', '100%')
	else
		$('.images-preview').attr('src', items.data('img')).removeAttr('width');
	
	$('#frmboxdetail').modal({keyboard: false, backdrop: 'static'});
}

function del(id)
{
	if(confirm(' ID : '+id+'\n Apakah anda yakin akan menghapus media tersebut ?')) 
	{
		$.ajax({
			url:baseurl+'/delete',
			global:false,
			async:false,
			type:'post',
			data: ({ id : id }),
			success: function(e) {
				reloaded(pages);
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

function _reload()
{
	$(tb).dataTable().fnDraw();
}
</script>