<dl>
{% for code,filter in filterArr %}
<dt>{{filter.label}}</dt>
<dd>
	<ul>
		{% if getArrayValue(currentQuery, code, 'all') == 'all' %}
		<li class='all'><span>不限</span></li>
		{% else %}
		<li class='all'><a href='{{ code | query('all', currentQuery) | raw}}'>不限</a></li>
		{% endif %}
	{% for optVal,optLabel in filter.optVal%}
		{% if getArrayValue(currentQuery, code) == optVal %}
		<li><span>{{optLabel}}</span></li>
		{% else %}
		<li><a class='' href='{{ code | query(optVal, currentQuery) | raw}}'>{{optLabel}}</a></li>
		{% endif %}
	{% endfor %}
	</ul>
</dd>
{% endfor %}
</dl>