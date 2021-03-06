{% import "book\\index\\_loopitem.tpl" as item %}

{% block header %}{% endblock %}
{% if displayBrickName %}
<div class='brick-name'>{{ brickName }}</div>
{% endif %}
<ul>
{% for node in bookIndex %}
	{{ item.loop(node, bookAlias, trailIds) }}
{% endfor %}
</ul>
<div class='clear'></div>
{% block footer %}{% endblock %}