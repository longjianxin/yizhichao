<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>web os --- 管理</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('static/css/lib/base.css');?>" />
	<?php if(ENVIRONMENT == 'development'){ ?>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('static/css/lib/bootstrap.min.css');?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('static/js/summernote/summernote.css');?>" />
	<?php }else{ ?>
	<link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
	<link href="//cdn.bootcss.com/summernote/0.8.1/summernote.css" rel="stylesheet">
	<?php } ?>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('static/css/scss/main.css');?>" /> 
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('static/css/lib/datetimepicker.css');?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('static/css/lib/jquery.mCustomScrollbar.min.css');?>">
	<script type="text/javascript">
	var static_base_url = "<?php echo base_url();?>";
	</script>
</head>
<body>	
	<div class="header">
		
		<nav class="navbar navbar-inverse">
			<div class="container">
				<div class="container-fluid">
					<div class="navbar-header ellipsis">
						<a class="navbar-brand" href="javascript:;" onclick="clickMenu('<?php echo site_url(array($this->router->directory, $this->router->class, 'main'));?>', -1)">
							<?php echo $system['site_name'];?>
						</a>
					</div>
					<div class="collapse navbar-collapse" >
					    <ul class="nav navbar-nav">
					    	<?php foreach($menu as $i=>$item){ ?>
					        <li id="navbar-nav-<?php echo $i;?>">
					        	<a href="javascript:;">
					        		<?php echo $item['name'];?>
					        		<?php if($item['list']){ ?><span class="caret"></span><?php } ?>
					        	</a>
					        	<?php if($item['list']){ ?>
					        	<div class="silde_down">
									<?php foreach($item['list'] as $j=>$rows){ ?>
									<dl class="nav_menu">

									<?php if(isset($rows['list'])){ ?>
									<dt class="menu_title"> <i class="glyphicon <?php echo $rows['class_name'];?>"></i>
										<?php echo $rows['name'];?>
									</dt>
									<?php foreach($rows['list'] as $k=>$row) { ?>
									<dd class="menu_item" data-num="<?php echo $i.'-'.$j.'-'.$k;?>" data-val="<?php echo site_url(array($row['d'],$row['c'],$row['m']));?>"><!-- selected -->
										<a href="javascript:;"><?php echo $row['name'];?></a>
									</dd>
									<?php } ?>
									<?php }else{ ?>
									<dt class="menu_title" data-num="<?php echo $i.'-'.$j.'-0';?>" data-val="<?php echo site_url(array($rows['d'],$rows['c'],$rows['m']));?>"> <i class="glyphicon <?php echo $rows['class_name'];?>"></i>
										<?php echo $rows['name'];?>
									</dt>
									<?php } ?>

									</dl>
									<?php } ?>
					        	</div>
					        	<?php } ?>
					        </li>
					    	<?php } ?>					        
					    </ul> 
						<ul class="nav navbar-nav navbar-right nav-out-wrap">
							<li>
								<div class="rom">
									<img src="<?php echo avatar($this->aSession['data']['header']);?>" height="40" width="40" alt="点击编辑"  /> 
									
									<div class="rom-fl"> 
										<p>
											<?php if($this->aSession['account_type'] == 1){ ?>
											<span class="sys_type t1">管理员</span> 								
											<?php }else{ ?>
												<?php if($this->aSession['data']['parent_id'] == 0){ ?>
												<span class="sys_type t2">代理</span> 
												<?php }else{ ?>
												<span class="sys_type t3">推广员</span> 
												<?php } ?>
											<?php } ?>  
										</p>
										<p>
											<span class="login_user"><?php echo $this->aSession['account'];?></span> 		
										</p>
									</div>
								</div>
								<div class="uio-con">   
									<p>
										<span class="usercenter" id="bindUser">个人中心</span>
									</p>
									<p>
										<a  class="btn-loginout" href="<?php echo site_url('admin/login/login_out');?>" id="login_out"><i class="glyphicon glyphicon-off"></i>退出</a>
									</p>
								</div>
							</li> 
						</ul>
					</div>
				</div>
			</div>
		</nav>	 
	</div>
	<div class="container">
		<div class="row uio-rows">
			<div class="left-layout">
				<div class="menu_box">
				<?php foreach($menu as $key=>$val){ ?>
					<div id="menuBar_<?php echo $key;?>" style="display: none;" class="menuBar">
					<?php foreach($val['list'] as $i=>$item){ ?>
					<dl class="menu no_extra">
						<?php if(isset($item['list'])){ ?>
						<dt class="menu_title"> <i class="glyphicon <?php echo $item['class_name'];?>"></i>
							<?php echo $item['name'];?>
						</dt>
						<?php foreach($item['list'] as $j=>$row) { ?>
						<dd class="menu_item" data-num="<?php echo $key.'-'.$i.'-'.$j;?>" data-val="<?php echo site_url(array($row['d'],$row['c'],$row['m']));?>"><!-- selected -->
							<a href="javascript:;"><?php echo $row['name'];?></a>
						</dd>
						<?php } ?>
						<?php }else{ ?>
						<dt class="menu_title" data-num="<?php echo $key.'-'.$i.'-0';?>" data-val="<?php echo site_url(array($item['d'],$item['c'],$item['m']));?>"> <i class="glyphicon <?php echo $item['class_name'];?>"></i>
							<?php echo $item['name'];?>
						</dt>
						<?php } ?>
					</dl>
					<?php } ?>
					</div>
				<?php } ?>
				</div>
			</div>
			<div class="right-layout">
				<div id="mainPage" >					
				</div>
			</div>
		</div>
	</div>

	<!-- <footer class="footer">
		<div class="container footerbg">
			<ul class="links ft">
				<li class="links_item no_extra">
					<a href="javascript:;" target="_blank">关于我们</a>
				</li>
				<li class="links_item">
					<a href="javascript:;" target="_blank">服务协议</a>
				</li>
				<li class="links_item">
					<a href="javascript:;" target="_blank">运营规范</a>
				</li>
				<li class="links_item">
					<a href="javascript:;" target="_blank">辟谣中心</a>
				</li>
				<li class="links_item">
					<a href="javascript:;" target="_blank">客服中心</a>
				</li>
				<li class="links_item">
					<a href="javascript:;" target="_blank">联系邮箱</a>
				</li>
				<li class="links_item">
					<p class="copyright">Copyright © 2012-<?php echo mdate("%Y");?> BDHS. All Rights Reserved.</p>
				</li>
			</ul>
		</div>
	</footer> -->
	<div style="display: none; width:600px;overflow: hidden;padding:15px 0;" id="user">
		<form class="form-horizontal" id="chang_account" action="" onsubmit="javascript:return false;"> 
			<div class="form-group">
				<label for="account" class="col-md-3 control-label">姓名：</label>
				<div class="col-sm-9" style="padding-left:0;">
					<div class="col-sm-8">
						<label for="account" class="control-label"><?php echo $this->aSession['data']['name'];?></label>
					</div>
					<div class="col-sm-4 tips-msg"></div>
				</div>
			</div>
			<?php if($this->aSession['account_type'] == 1){ ?>
			<div class="form-group">
				<label for="account" class="col-md-3 control-label">登录账号：</label>
				<div class="col-sm-9" style="padding-left:0;">
					<div class="col-sm-8 ">
					<input type="input" class="form-control"  name="account" placeholder="<?php echo $this->aSession['data']['account'];?>" value="<?php echo $this->aSession['data']['account'];?>" />
					</div>
					<div class="col-sm-4 tips-msg"></div>
				</div>
			</div>
			<div class="form-group">
				<label for="email" class="col-md-3 control-label">邮箱账号：</label>
				<div class="col-sm-9" style="padding-left:0;">
					<div class="col-sm-8 ">
					<input type="input" class="form-control"  name="email" placeholder="<?php echo $this->aSession['data']['email'];?>" value="<?php echo $this->aSession['data']['email'];?>" />
					</div>
					<div class="col-sm-4 tips-msg"></div>
				</div>
			</div> 
			<?php }else{ ?>
			<div class="form-group">
				<label for="account" class="col-md-3 control-label">登录手机号：</label>
				<div class="col-sm-9" style="padding-left:0;">
					<div class="col-sm-8 ">
					<label for="account" class="control-label"><?php echo $this->aSession['data']['phone'];?></label>
					<input type="hidden" class="form-control"  name="account" value="<?php echo $this->aSession['data']['phone'];?>" />
					</div>
					<div class="col-sm-4 tips-msg"></div>
				</div>
			</div>
			<?php } ?>
			<div class="form-group">
				<label for="usericon" class="col-md-3 control-label">头像：</label>
				<div class="col-sm-9" style="padding-left:0;">
					<div class="col-sm-12 user_file_img">
						<input type="hidden" name="usericon" id="usericon" value="<?php echo $this->aSession['data']['header'];?>" />
						<div class="col-md-3" style="padding-left:0;">
							<input type="file" class="form-control input-file" placeholder="" id="usericon_upload" name="usericon_upload" />
						</div>
						<div class="col-md-4" style="margin-left: 20px;">
							<img src="<?php echo avatar($this->aSession['data']['header']);?>" alt="" id="usericon_view" />
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="new_password" class="col-md-3 control-label">新密码：</label>		 
				<div class="col-sm-9" style="padding-left:0;">
					<div class="col-sm-8">
						<input type="password" class="form-control" id="new_password"  name="new_password" value="" placeholder="新密码" />
					</div>
					<div class="col-sm-4 tips-msg"></div>
				</div>
			</div>
			<div class="form-group">
				<label for="account" class="col-md-3 control-label">当前密码：</label>
				<div class="col-sm-9" style="padding-left:0;">
					<div class="col-sm-8">
						<input type="password" class="form-control"  name="password" placeholder="当前密码" value="" />
					</div>
					<div class="col-sm-4 tips-msg"></div>
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-md-3 control-label"></label>
				<div class="col-sm-5">
					<input type="submit" name="buttonSubmit" id="buttonSubmit" class="btn btn-success col-sm-3" value="提交" /> 
				</div>
			</div>
		</form> 
	</div>
	<?php if(ENVIRONMENT == 'development'){ ?>
	<script type="text/javascript" src="<?php echo base_url('static/js/jquery-1.9.1.min.js')?>"></script>
	<script type="text/javascript" src="<?php echo base_url('static/js/bootstrap.min.js')?>"></script>
	<script type="text/javascript" src="<?php echo base_url('static/js/jquery.cookie.js')?>"></script>
	<?php }else{ ?>
	<script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
	<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="//apps.bdimg.com/libs/jquery.cookie/1.4.1/jquery.cookie.js"></script>
	<?php } ?>
	
	<script type="text/javascript" src="<?php echo base_url('static/js/jquery.mCustomScrollbar.min.js')?>"></script>
	<script type="text/javascript" src="<?php echo base_url('static/js/jquery.validate.min.js')?>"></script>
	<!-- 复制 -->
	<script type="text/javascript" src="<?php echo base_url('static/js/clipboard.min.js')?>"></script>
	<!-- 复制 -->
	<!-- 弹窗 -->
	<?php if(ENVIRONMENT == 'development'){ ?>
	<script type="text/javascript" src="<?php echo base_url('static/js/layer/layer.js')?>"></script>
	<?php }else{ ?>
	<script src="//apps.bdimg.com/libs/layer/2.1/layer.js"></script>
	<?php } ?>
	<!-- 弹窗 -->
	<!-- 时间 -->
	<script type="text/javascript" src="<?php echo base_url('static/js/jquery.datetimepicker.full.min.js')?>"></script>
	<!-- 时间 -->
	<!-- 报表 -->
	<?php if(ENVIRONMENT == 'development'){ ?>
	<script type="text/javascript" src="<?php echo base_url('static/js/echarts.min.js')?>"></script>
	<?php }else{ ?>
	<script src="//cdn.bootcss.com/echarts/3.0.0/echarts.min.js"></script>
	<?php } ?>	
	<script type="text/javascript" src="<?php echo base_url('static/js/china.js')?>"></script>
	<!-- 报表 -->
	<!-- 上传 -->
	<script type="text/javascript" src="<?php echo base_url('static/js/uploadify/jquery.uploadify.min.js')?>"></script>
	<!-- 上传 -->
	<!-- 富文本 -->
	<?php if(ENVIRONMENT == 'development'){ ?>
	<script type="text/javascript" src="<?php echo base_url('static/js/summernote/summernote.min.js')?>"></script>
	<script type="text/javascript" src="<?php echo base_url('static/js/summernote/lang/summernote-zh-CN.min.js')?>"></script>
	<?php }else{ ?>
	<script src="//cdn.bootcss.com/summernote/0.8.1/summernote.min.js"></script>
	<script src="//cdn.bootcss.com/summernote/0.8.1/lang/summernote-zh-CN.min.js"></script>
	<?php } ?>	
	<!-- 富文本 -->
	<script type="text/javascript" src="<?php echo base_url('static/js/base.js')?>"></script>
	<script type="text/javascript">
		var require_page_url = '';//翻页请求url
		var default_directory = "<?php echo $this->router->directory;?>";//默认管理平台目录
		if(default_directory == getCookie('default_directory')){
			if(require_url = getCookie('require_url')){
				console.log(1);
			}else{
				console.log(2);
				require_url = '<?php echo site_url(array($this->router->directory, $this->router->class, 'main'));?>';
				setCookie('data_num', 0);
				setCookie('require_url', require_url);
			}			
		}else{
			console.log(3);
			require_url = '<?php echo site_url(array($this->router->directory, $this->router->class, 'main'));?>';
			setCookie('data_num', 0);
			setCookie('require_url', require_url);
		}
		setCookie('default_directory', "<?php echo $this->router->directory;?>");
		
		$(function(){
			$.datetimepicker.setLocale("ch");

			$("#bindUser").click(function(){
				layer.open({
					type: 1,
					area: ['600px'], 
					title: '个人信息',
					content: $('#user')
				});
			});
			$("#usericon_upload").uploadify({
				'formData': {'base_dir': '<?php echo $this->router->directory;?>'},
				'height': '34',
				'width': '120',
				'buttonText': '上传头像',
				'buttonClass': 'btn btn-default files col-sm-3',
				'fileTypeExts': '*.gif; *.jpg; *.png',
				'swf': "<?php echo base_url('static/js/uploadify/uploadify.swf')?>",
				'uploader': "<?php echo site_url(array($this->router->directory, 'index', 'do_upload'));?>",
				'onInit': function(){
					$(".uploadify-queue").hide();
				},
				'onUploadStart': function(file){
					// console.log(file);
				},
				'onUploadSuccess': function(file, data, res){
					if(res){
						var ret = JSON.parse(data);
						if(ret.code == 0){
							$("#usericon").val(ret.data.file_name);
							$("#usericon_view").attr('src', ret.data.site_url);
							showSuccess("文件上传成功！");
						}
					}
				},
				'onUploadError': function(file, errorCode, errorMsg, errorString){
					showError(file.name + "上传失败！" + errorString);
				}
			});
			$("form#chang_account").validate({ 
				errorPlacement: function(error, element){
					$(element).parent().siblings(".tips-msg").append(error);
			    },
				errorElement: 'label',
				submitHandler: function(){
					require_url = '<?php echo site_url(array($this->router->directory, 'index', 'chang_account'));?>';
					var data = formatForm($("form#chang_account").serializeArray());
					postData(data, function(res){
						if(res.code == 0){
							layer.msg("编辑个人信息成功，请重新登录！", {time:2000}, function(){
								window.location.href = "<?php echo site_url(array('work', 'login', 'login_out'));?>";
							});
						}else{
							showError(res.msg);
						}
					});
				},
				errorClass: 'invalid',
				rules: {
					account: {
						required: true,
					},
					email: {
						email: true,
					},
					password: {
						required: true
					}
				},
				messages: {
					account: {
						required: "<i class='icon-exclamation-sign'></i>登录账号不能为空",
					},
					email: {
						email: "<i class='icon-exclamation-sign'></i>邮箱格式不正确",
					},
					password: {
						required: "<i class='icon-exclamation-sign'></i>密码不能为空",
					}
				}
			});
		});
    </script>    
    <script type="text/javascript" src="<?php echo base_url('static/js/admin.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('static/js/region.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('static/js/store_category.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('static/js/store_class.js')?>"></script>
</body>
</html>