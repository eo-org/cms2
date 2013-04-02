<ul class='brick-ad-plain'>
{% for row in rowset %}
	<li>
		<a href='{{row.link}}' title='{{ row.label }}'>
			<img src='{{row.filename|outputImage}}' />
		</a>
	</li>
{% endfor %}
</ul>