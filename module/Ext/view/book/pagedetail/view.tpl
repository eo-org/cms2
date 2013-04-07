{% if doc %}
	{% if showTitle == 'y' %}
	<div class='title'>{{ doc.getLabel() }}</div>
	{% endif %}
	
	<div class='content'>
		{{ doc.getFulltext()|raw }}
	</div>
{% else %}
	<div class='error'>对不起，你寻找的文章不存在！</div>
{% endif %}