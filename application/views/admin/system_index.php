<?php echo getListHeader($listHeader['location'], $listHeader['actions']);?>

<div class="main_hd notpd">
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="uio-tab-items active">
			<a href="#home" aria-controls="home" role="tab" data-toggle="tab">站点设置</a>
		</li>
		<li role="presentation" class="uio-tab-items">
			<a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">店铺等级</a>
		</li>
		<li role="presentation" class="uio-tab-items">
			<a href="#offers" aria-controls="profile" role="tab" data-toggle="tab">提现规则</a>
		</li>
	</ul>
</div>

<div class="tab-content">
	<div role="tabpanel" class="tab-pane active"  id="home">
		<form class="form-horizontal uio-form-box" id="system_form" action="" onsubmit="javascript:return false;">
			<input type="hidden" name="action" value="site">
			<div class="form-group">
				<label  class="col-sm-2 control-label">网站名称：</label>
				<div class="col-sm-5">
					<input type="text" class="form-control" placeholder="网站名称" name="site_name" value="<?php echo isset($system['site_name'] ) && !empty($system['site_name']) ? $system['site_name'] : '';?>" />
				</div>
				<div class="col-sm-4 tips-msg"></div>
			</div>
			<div class="form-group">
				<label  class="col-sm-2 control-label">网站logo：</label>
				<div class="col-sm-7 uio-file">
					<input type="hidden" name="site_logo" id="site_logo" value="<?php echo isset($system['site_logo']) && !empty($system['site_logo']) ? $system['site_logo'] : '';?>" />
					<input type="file" class="form-control input-file" placeholder="" id="file_upload" name="file_upload" />
					<img src="<?php echo isset($system['site_logo']) && !empty($system['site_logo']) ? base_url('uploads/'.$system['site_logo']) : base_url('static/image/lib/avatar.png');?>" alt="" id="site_logo_view" />
				</div>
				 
			</div>
			<div class="form-group">
				<label   class="col-sm-2 control-label">ICP证书号：</label>
				<div class="col-sm-7">
					<input type="text" class="form-control" placeholder="ICP证书号" name="icp_number" value="<?php echo isset($system['icp_number']) ? $system['icp_number'] : '';?>" />
				</div>
			</div>
			<div class="form-group">
				<label   class="col-sm-2 control-label">平台联系电话：</label>
				<div class="col-sm-7">
					<input type="text" class="form-control" placeholder="平台联系电话" name="site_phone" value="<?php echo isset($system['site_phone']) ? $system['site_phone'] : '';?>" />
				</div>
			</div>
			<div class="form-group">
				<label  class="col-sm-2 control-label">APP令牌时效：</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" placeholder="默认7天过期" name="app_token_day" value="<?php echo isset($system['app_token_day']) ? $system['app_token_day'] : '';?>" />
				</div>
				<div class="col-sm-2">
					<span style="line-height: 34px;">天</span>
				</div>
			</div>
			<div class="form-group">
				<label  class="col-sm-2 control-label">站点状态：</label>
				<div class="col-sm-7">
					<div class="radio-inline">
						<label>
							<input type="radio" name="site_satus" value="1" <?php if(!isset($system['site_satus']) || (isset($system['site_satus']) && $system['site_satus'] == 1)){echo 'checked="checked"';}?> />
							开启
						</label>
					</div>
					<div class="radio-inline">
						<label>
							<input type="radio" name="site_satus" value="0" <?php if(isset($system['site_satus']) && $system['site_satus'] == 0){echo 'checked="checked"';}?> />
							关闭
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label   class="col-sm-2 control-label">关闭原因：</label>
				<div class="col-sm-7">
					<textarea class="form-control" rows="6" placeholder="关闭原因" name="reson"><?php echo isset($system['reson']) ? $system['reson'] : '';?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label"></label>
				<div class="col-sm-7">
					<input type="submit" name="buttonSubmit" id="buttonSubmit" class="btn btn-success col-sm-3" value="提交" />
				</div>
			</div>
		</form>
	</div>
	<div role="tabpanel" class="tab-pane" id="profile">
		<div class="uio-row-mo clearfix">
			<div class="col-md-4 inline-input uio-nomar">
				<input type="text" class="form-control" placeholder="请输入店铺等级名称" name="storeLevel" id="storeLevel" value="" />
			</div>
			<div class="col-md-1 text-right"><a href="javascript:;" class="btn btn-success btn-add-grades">添加</a></div>
		</div>
		<div class="uio-row mr"> 
			<div class="col-md-4 inline-input inline-input-list">
				<?php if($system['storeLevel']){ ?>
				<?php $aStoreLevel = json_decode($system['storeLevel'], true); ?>
				<?php foreach($aStoreLevel as $key=>$val){ ?>
				<div class="inline">
					<input type="text" class="form-control" placeholder="请输入等级" value="<?php echo $val;?>" />	
					<button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>	
				</div>
				<?php } ?>
				<?php } ?>
			</div>
		</div>
	</div>
	<div role="tabpanel" class="tab-pane"  id="offers">
		<form class="form-horizontal uio-form-box" id="offers_form" action="" onsubmit="javascript:return false;">
			<input type="hidden" name="action" value="offers">
			<div class="form-group">
				<label  class="col-sm-2 control-label">分佣最低额度：</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" placeholder="0" name="min_commission" value="<?php echo isset($system['min_commission']) ? $system['min_commission'] : 0;?>" />
				</div>				
				<div class="col-sm-3">
					<span style="line-height: 34px;">交易金额/次【0表示不限】</span>
				</div>
				<div class="col-sm-4 tips-msg"></div>
			</div>
			<div class="form-group">
				<label  class="col-sm-2 control-label">提现频率：</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" placeholder="0" name="offers_frequency" value="<?php echo isset($system['offers_frequency']) ? $system['offers_frequency'] : 0;?>" />
				</div>
				<div class="col-sm-3">
					<span style="line-height: 34px;">次/天【0表示不限】</span>
				</div>
				<div class="col-sm-4 tips-msg"></div>
			</div>
			<div class="form-group">
				<label  class="col-sm-2 control-label">提现最低额度：</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" placeholder="0" name="min_offers" value="<?php echo isset($system['min_offers']) ? $system['min_offers'] : 0;?>" />
				</div>
				<div class="col-sm-3">
					<span style="line-height: 34px;">金额/次【0表示不限】</span>
				</div>
				<div class="col-sm-4 tips-msg"></div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label"></label>
				<div class="col-sm-7">
					<input type="submit" name="buttonSubmit" id="buttonSubmit" class="btn btn-success col-sm-3" value="提交" />
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
var storeLevelList = <?php echo isset($system['storeLevel']) ? $system['storeLevel'] : json_encode(array());?>;
$(function(){
	$(".btn-add-grades").on("click",function(){
		var storeLevel = $("#storeLevel").val();
		if(! storeLevel.length){
			showError("请输入店铺等级名称再添加！");
			$("#storeLevel").focus();
			return false;
		}
		if(storeLevelList.indexOf(storeLevel) != -1){
			showError("请勿重复添加相同店铺等级名称！");
			$("#storeLevel").focus();
			return false;
		}

		require_url = '<?php echo site_url(array($this->router->directory, $this->router->class, 'done'));?>';
		var data = {};
		data.action = 'storeLevel';
		data.storeLevel = storeLevel;
		postData(data, function(res){
			if(res.code == 0){
				$("#storeLevel").val('');
				var cloneStr='<div class="inline">' +
							'<input type="text" class="form-control" placeholder="请输入等级" value="'+storeLevel+'" />' +
							'<button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
						'</div>';
				$(".inline-input-list").append(cloneStr);
			}else{
				showError(res.msg);
			}
		});
	});
	$("body").on("click",".uio-row .close",function(){
		showError("暂时不支持删除操作");
		// $(this).parent(".inline").remove();
	});
	$("#file_upload").uploadify({
		// 'formData': {'base_dir': 'admin'},
		'height': '34',
		'width': '120',
		'buttonText': '上传图片',
		'buttonClass': 'btn btn-default files col-sm-3',
		'fileTypeExts': '*.gif; *.jpg; *.png',
		'swf': "<?php echo base_url('static/js/uploadify/uploadify.swf')?>",
		'uploader': "<?php echo site_url(array($this->router->directory, 'index', 'do_upload'));?>",
		'onInit': function(){
			$(".uploadify-queue").hide();
		},
		'onUploadStart': function(file){
			console.log(file);
		},
		'onUploadSuccess': function(file, data, res){
			if(res){
				var ret = JSON.parse(data);
				if(ret.code == 0){
					$("#site_logo").val(ret.data.file_name);
					$("#site_logo_view").attr('src', ret.data.site_url);
					showSuccess("文件上传成功！");
				}
			}
		},
		'onUploadError': function(file, errorCode, errorMsg, errorString){
			showError(file.name + "上传失败！" + errorString);
		}
	});
	$("form#system_form").validate({ 
		errorPlacement: function(error, element){
			$(element).parent().siblings(".tips-msg").append(error);
	    },
		errorElement: 'label',
		submitHandler: function(){
			require_url = '<?php echo site_url(array($this->router->directory, $this->router->class, 'done'));?>';
			var data = formatForm($("form#system_form").serializeArray());
			postData(data, function(res){
				if(res.code == 0){
					showSuccess(res.msg);
				}else{
					showError(res.msg);
				}
			});
		},
		errorClass: 'invalid',
		rules: {
			site_name: {
				required: true,
			}
		},
		messages: {		
			site_name: {
				required: "<i class='icon-exclamation-sign'></i>网站名称不能为空",
			}
		}
	});
	$("form#offers_form").validate({ 
		errorPlacement: function(error, element){
			$(element).parent().siblings(".tips-msg").append(error);
	    },
		errorElement: 'label',
		submitHandler: function(){
			require_url = '<?php echo site_url(array($this->router->directory, $this->router->class, 'done'));?>';
			var data = formatForm($("form#offers_form").serializeArray());
			postData(data, function(res){
				if(res.code == 0){
					showSuccess(res.msg);
				}else{
					showError(res.msg);
				}
			});
		},
		errorClass: 'invalid',
		rules: {
			min_commission: {
				min: 0,
			},
			offers_frequency: {
				min: 0,
			},
			min_offers: {
				min: 0,
			}
		},
		messages: {		
			min_commission: {
				min: "输入值不能小于{0}",
			},
			offers_frequency: {
				min: "输入值不能小于{0}",
			},
			min_offers: {
				min: "输入值不能小于{0}",
			}
		}
	});
});
</script>