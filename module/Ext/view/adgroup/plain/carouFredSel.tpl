<ul id='carouFredSel-items' class='brick-ad-plain'>
{% for row in rowset %}
	<li>
		<a href='{{row.link}}' title='{{ row.label }}'>
			<img src='{{row.filename|outputImage}}' />
		</a>
	</li>
{% endfor %}
</ul>
<a id="carouFredSel-prev" href="#">&lt;&lt;</a>
<a id="carouFredSel-next" href="#">&gt;&gt;</a>
<div id="carouFredSel-pager"></div>