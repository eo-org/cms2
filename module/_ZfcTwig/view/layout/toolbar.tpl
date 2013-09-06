{% if sessionAdmin.hasPrivilege() %}
<div class='toolbar'>
	<div class='main'>
		<ul class='left'>
			<li>
				<select id='layout-selector' name='layout'>
					<optgroup label='默认页面'>
						<option value='/' data-layoutAlias='index'>首页</option>
						<option value='/book.shtml' data-layoutAlias='book'>默认手册</option>
						<option value='/article-0.shtml' data-layoutAlias='article'>文章内容</option>
						<option value='/list-0/page1.shtml' data-layoutAlias='list'>文章列表</option>
						<option value='/product-0.shtml' data-layoutAlias='product'>产品详情</option>
						<option value='/product-list-0/page1.shtml' data-layoutAlias='product-list'>产品列表</option>
						<option value='/search/product.shtml' data-layoutAlias='search'>搜索结果</option>
						<!-- option value='/shop/index/' data-layoutAlias='shop'>购物车</option>
						<option value='/shop/order/' data-layoutAlias=shop-order'>订单页面</option>
						<option value='/shop/payment-gateway/' data-layoutAlias='shop-payment-gateway'>支付页面</option -->
					</optgroup>
					<optgroup label='错误页面'>
						<option value='/error-401.shtml' data-layoutAlias='401'>401</option>
						<option value='/error-404.shtml' data-layoutAlias='404'>404</option>
					</optgroup>
					<optgroup label='用户页面'>
						<option value='/user' data-layoutAlias='user'>用户管理</option>
					</optgroup>
					<!-- optgroup label='购物车页面'>
						<option value='/shop/index/' data-layoutAlias='shop'>购物车</option>
						<option value='/shop/order/' data-layoutAlias=shop-order'>订单页面</option>
						<option value='/shop/payment-gateway/' data-layoutAlias='shop-payment-gateway'>支付页面</option>
					</optgroup -->
					<optgroup label='自定义页面'>
					{%
					for doc in userLayoutDocs
					%}
						<option value='/{{ doc.alias }}.layout' data-layoutAlias='{{ doc.alias }}'>{{ doc.label }}[{{ doc.type }}]</option>
					{%
					endfor
					%}
					</optgroup>
					<option style='background: #789; border-radius: 2px; font: italic;' value='#/admin/layout.ajax/create'>创建新页面</option>
				</select>
			</li>
			<li><a id='enter-stage-mode' href='javascript:void(0);'>页面编辑</a></li>
			<li><a id='enter-sprite-mode' href='javascript:void(0);'>添加模块</a></li>
			<li><a id='enter-brick-mode' href='javascript:void(0);'>编辑页面模块</a></li>
			{% if sessionAdmin.getUserData('userType') == 'designer' %}
				{% if sessionAdmin.getUserData('localCssMode') == 'active'%}
			<li><a id='unload-local-css' href='javascript:void(0);' style='color: red;'>停止读取本地CSS</a></li>
			<li><a id='reload-local-css' href='javascript:void(0);' style='color: green;'>Reload CSS</a></li>
			{%
				else
			%}
			<li><a id='load-local-css' href='javascript:void(0);'>读取本地CSS</a></li>
				{% endif %}
			{% endif %}
		</ul>
		<ul class='right'>
			<li><a href='#/admin/layout.ajax/edit/id/{{ layoutFront.getLayoutId() }}'>编辑页面属性</a></li>
			<li><a id='enter-normal-mode' href='javascript:void(0);'>退出编辑模式</a></li>
		</ul>
	</div>
	<div class='sub'>
		<div typeId='0' class='sprite-type' draggable='true'>100%</div>
		<div typeId='1' class='sprite-type' draggable='true'>50%|50%</div>
		<div typeId='2' class='sprite-type' draggable='true'>25%|75%</div>
		<div typeId='3' class='sprite-type' draggable='true'>33%|66%</div>
		<div typeId='4' class='sprite-type' draggable='true'>66%|33%</div>
		<div typeId='5' class='sprite-type' draggable='true'>75%|25%</div>
		<div typeId='6' class='sprite-type' draggable='true'>33|33|33</div>
		<div typeId='7' class='sprite-type' draggable='true'>25|50|25</div>
		<div typeId='8' class='sprite-type' draggable='true'>25|25|25|25</div>
		<div class='clear'></div>
		
		<div style='margin: 5px;'>拖动方框至页面，为此布局添加新的STAGE。确认布局方式后点击[保存布局方案]以保存当前设置。(点击右上角[退出编辑模式]放弃所做的修改)</div>
		<div class='button' id='save-sprite-layout'>保存页面布局</div>
	</div>
</div>
<script>
	var layoutAlias = "{{ layoutFront.getLayoutAlias() }}";
	$('#layout-selector').change(function() {
		window.location.href = $(this).val();
	});
	$('#layout-selector').find('option').each(function(i, ls) {
		if($(ls).attr('data-layoutAlias') == layoutAlias) {
			$(ls).attr('selected', 'selected');
		}
	});
</script>
{% endif %}