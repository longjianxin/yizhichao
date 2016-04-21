<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="main_hd main_index">

	<div class="row index_show_area">
		<div class="col-md-8 uio-count">
			<ul>
				<li  class="index_tap_item ">
					<p>今日提现人数： <a href="javascript:;" title="（店铺[<?php echo $offer_store['number'];?>]，代理/推广员[<?php echo $offer_agent['number'];?>]）"><?php echo $offer_store['number'] + $offer_agent['number'];?></a>人</p>
					<p>提现人次： <a href="javascript:;" title="（店铺[<?php echo $offer_store['times'];?>]，代理/推广员[<?php echo $offer_agent['times'];?>]）"><?php echo $offer_store['times'] + $offer_agent['times'];?></a>次</p>
					<p>总金额： <a href="javascript:;" title="（店铺[<?php echo $offer_store['total'];?>]，代理/推广员[<?php echo $offer_agent['total'];?>]）"><?php echo $offer_store['total'] + $offer_agent['total'];?></a>元</p> 
				</li>
				<li class="index_tap_item ">
					<p>今日入驻店铺数： <a href="javascript:;"><?php echo $store_yes;?></a>个</p>
					<p>待审核店铺数： <a href="javascript:;"><?php echo $store_check;?></a>个</p>
					<p>总店铺数：<a href="javascript:;"><?php echo $store_total['number'];?></a>个</p> 
				</li>
			</ul>
		</div>
		<div class="col-md-4">
			<ul>
				<li class="index_tap_item ">
					<p>今日交易次数：<a href="javascript:;"><?php echo $order['number'];?></a>次</p>
					<p>交易总金额：<a href="javascript:;"><?php echo $order['total'];?></a>元</p>
					<p>&nbsp;</p> 
				</li>
			</ul>
		</div>
	</div>
</div>
<div class="charts-box">
	<div class="mark-list"> 
		<div id="ECharts" style="width:100%;height:650px;"></div> 
	</div>
</div>
<script type="text/javascript"> 
	var myChart = echarts.init(document.getElementById('ECharts'));
	myChart.showLoading();

	require_url = '<?php echo site_url(array($this->router->directory, $this->router->class, 'map'));?>';
	getData({}, 'json', function(res){
		myChart.hideLoading();
		if(res.code == 0){
			var title = [];
			var selected = {};//默认选中状态
			for(var i in res.data){
				title.push(res.data[i]['name']);
				if(i == 0){
					selected[res.data[i]['name']] = true;
				}else{
					selected[res.data[i]['name']] = false;
				}				
			}
			var option = {
			    title: {
			        text: '全国地图热图展示',
			        subtext: '业务热图展示',
			        left: 'left'
			    },
			    tooltip: {
			        trigger: 'item'
			    },
			    legend: {
			        orient: 'horizontal',
			        left: 'center',
			        data: title,
			        selectedMode: 'single',
			        selected: selected
			    },
			    toolbox: {
			        show: true,
			        orient: 'horizontal',
			        left: 'right',
			        top: 'top',
			        feature: {
			            saveAsImage: {}
			        }
			    },
			    series: res.data
			};
			myChart.setOption(option);
		}else{
			showError(res.msg);
		}
	});
</script>