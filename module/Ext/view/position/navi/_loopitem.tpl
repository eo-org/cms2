{% macro loop(node, trailIds) %}
{% spaceless %}
	{% if node.resourceId in trailIds%}
    <li class='{{node.className}}'>
    	<a class='{{node.className}}' href='{{ node.link }}'>{{ node.label }}</a>
    {% else %}
    <li class='{{node.className}} selected'>
    	<a class='{{node.className}} selected' href='{{ node.link }}'>{{ node.label }}</a>
    {% endif %}
    {% if node.children %}
        <ul>
        {% for childNode in node.children %}
            {{ _self.loop(childNode, trailIds) }}
        {% endfor %}
        </ul>
    {% endif %}
    </li>
{% endspaceless %}
{% endmacro %} 