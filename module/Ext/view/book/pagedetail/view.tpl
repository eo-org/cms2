{% if label %}
	{% if showTitle == 'y' %}
	<div class='title'>{{ label }}</div>
	{% endif %}
	
	<div class='content'>
		{{ fulltext|raw }}
	</div>
{% else %}
	<div class='error'>对不起，你寻找的文章不存在！</div>
{% endif %}