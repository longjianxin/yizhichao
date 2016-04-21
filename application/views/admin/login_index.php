<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>web os ---login</title>
	<?php if(ENVIRONMENT == 'development'){ ?>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('static/css/lib/bootstrap.min.css');?>" />
	<?php }else{ ?>
	<link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
	<?php } ?>
	<style type="text/css"> 
		body{
		background:url(<?php echo base_url('static/image/static/login-bg.jpg');?>) no-repeat; 
		background-size:cover;
		background-attachment:fixed;
		}
		.form-signin {
			 
			padding: 15px;
			margin: 0 auto;
		}
		.form-signin .form-signin-heading,
		.form-signin .checkbox {
		margin-bottom: 20px;
		}
		.form-signin .checkbox {
		font-weight: normal;
		}
		.form-signin .form-control {
			position: relative;
			height: auto;
			-webkit-box-sizing: border-box;
			box-sizing: border-box;
			 
			font-size: 14px;
			border-radius:0; border: 0;
		}
		.form-signin .form-control:focus {
		z-index: 2;
		}
		 
		.container{  
			font-family:微软雅黑;
			padding:0;
			width: 360px; 
			position:absolute;
			left:50%;
			top:50%;
			margin-left:-180px;
			margin-top:-160px;
			background:#fff;
		  	border-radius:2px;
		
		}
		.form-signin{padding:0;}
		.form-signin h2{margin:0; font-size:18px; font-weight:bold; margin-top:30px; margin-left:-16px;}
		.form-group{ }
		.form-signin input[type="password"]{margin-bottom:0;}
		.nav-tabs{
			border:none;
			border-bottom:1px solid #e3e3e3;
			 
		}
		.nav-tabs>li>a{
			border-radius:0;
		}
		.nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover{
			border:0;
			background-color:#eee;
			color:#333;
		}
		.nav-tabs>li>a{
			border:none;
		}
		.tab-content{ 
			 padding:0 15px 15px 15px;
			 overflow: hidden;
		}
		

		.form-horizontal .form-group{
			position:relative;
			margin: 15px 0;
			border:1px solid #e3e3e3;
			float:left;
			margin-left:15px;
		}
		.form-horizontal .form-group i{
			font-size:13px;
			color:#ccc;
			 position:absolute; 
			left:9px; 
			top:9px; 
		}
		.form-group label{
			float:left;
			display:inline-block;
			width:30px;
			height:32px;
			margin:0;
			overflow: hidden;
			position:relative;
			border-right:1px solid #e3e3e3;
		}
		.form-group.notbor{
			border:0;
		}
		.form-control{
			 float:left;
			 width:267px;
			 border:none;
			 box-shadow:none;
		}

		.form-control:focus{
			box-shadow:none;
		}
		input[type=submit].btn-block{
			background:#4cae4c; 
			border:1px solid #4cae4c; 
			width:297px;
		}
		.btn-block:hover{
			background:#449d44;
		}
		input:-webkit-autofill { 
			-webkit-box-shadow: 0 0 0px 1000px white inset ;
		 
			border-radius: 0 4px 4px 0 ;
		}
</style>

</head>

<body>
	<div class="alert alert-danger text-center" style="border-radius:0;display: none;" role="alert" id="error">
		<span id="errorMsg"></span>
		<button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="container">		
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="uio-tab-items active" data-type="1">
				<a href="#home" aria-controls="home" role="tab" data-toggle="tab">管理登录</a>
			</li>
		</ul>

		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="home"> 
				<form class="form-signin form-horizontal" id="login_in" action="" onsubmit="javascript:return false;">
					<input type="hidden" name="account_type" value="1" />
					<h2 class="form-signin-heading"></h2>
					<div class="form-group">
						<label><i class="glyphicon glyphicon-user"></i></label>
						
							<input type="text" id="account" name="account" autocomplete="off" class="form-control" placeholder="请输入登录帐号" required autofocus />
						
					</div>
					<div class="form-group">
							<label><i class="glyphicon glyphicon-lock"></i></label>
						
						<input type="password" id="password" name="password" autocomplete="off" class="form-control" placeholder="请输入登录密码" required />
					</div>
					<div class="form-group notbor">
						<input type="submit" name="buttonSubmit" id="buttonSubmit" class="btn  btn-primary btn-block pull-right" value="登录" />
					</div>
				</form>
			</div>
		</div>

		
	</div>
	<?php if(ENVIRONMENT == 'development'){ ?>
	<script type="text/javascript" src="<?php echo base_url('static/js/jquery-1.9.1.min.js')?>"></script>
	<script type="text/javascript" src="<?php echo base_url('static/js/bootstrap.min.js')?>"></script>
	<script type="text/javascript" src="<?php echo base_url('static/js/layer/layer.js')?>"></script>
	<?php }else{ ?>
	<script src="//cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
	<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="//apps.bdimg.com/libs/layer/2.1/layer.js"></script>
	<?php } ?>
	<script type="text/javascript" src="<?php echo base_url('static/js/jquery.validate.min.js')?>"></script>
	<script type="text/javascript" src="<?php echo base_url('static/js/base.js')?>"></script>
	<script type="text/javascript">
	$(function(){
		$(".uio-tab-items").click(function(){
			$("input[name='account_type']").val($(this).attr('data-type'));
		});
		$(".close").click(function(){
			$("#error").fadeOut(1000);
		});
		$("form#login_in").validate({
			errorPlacement: function(error, element){
				$("#errorMsg").html(error);
				$("#error").fadeIn(2000);
		    },
			errorElement: 'label',
			submitHandler: function(){
				require_url = '';
				switch(parseInt($("input[name='account_type']").val())){
					case 1:
						require_url = '<?php echo site_url(array('admin', 'login', 'login_in'));?>';
						break;
					case 2:
						require_url = '<?php echo site_url(array('agent', 'login', 'login_in'));?>';
						break;
					default:
						showError("登录类型未知！");
						break;
				}

				if(require_url.length > 0){
					var data = formatForm($("form#login_in").serializeArray());
					postData(data, function(res){
						if(res.code == 0){
							layer.msg("登录成功，即将跳入管理平台！", {time:1000}, function(){
								window.location.href = res.data.url;
							});						
						}else{
							showError(res.msg);
						}
					});
				}
			},
			errorClass: 'invalid',
			rules: {
				account: {
					required: true,
				},
				password: {
					required: true
				}
			},
			messages: {
				account: {
					required: "登录帐号不能为空！",
				},
				password: {
					required: "登录密码不能为空！",
				}
			}
		});
	});
	</script>
</body>
</html>