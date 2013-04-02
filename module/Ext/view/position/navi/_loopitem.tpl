{% macro loop(node, trailIds) %}
{% spaceless %}
    <li>
    	{% if node.resourceId in trailIds%}
    	<a class='selected' href='{{ node.link }}'>{{ node.label }}</a>
    	{% else %}
    	<a href='{{ node.link }}'>{{ node.label }}</a>
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