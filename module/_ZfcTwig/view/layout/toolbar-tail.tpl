{% if sessionAdmin.hasPrivilege() %}
<div id="lightbox-blackbox"></div>
<div id="lightbox-whitebox">
	<div class='closer'></div>
	<div class='content'></div>
</div>
<div class="ajaxbox">Loading......</div>
<div class="mini-brick-mask"></div>
{% endif %}