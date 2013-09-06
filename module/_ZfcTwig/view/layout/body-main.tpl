<div class='body_main_frame' layoutId='{{ layoutDoc.getId() }}'>
{% for stage in stageList %}
<div id="{{stage.uniqueId}}" class='stage' type='{{ stage.type }}' stage-id='{{ stage.stageId }}'>

{% for typeArr in stage.type|split('-') %}
{% set spriteName = stage.stageId~'-'~loop.index0 %}
{% set spriteDivId = stage.uniqueId~'-'~loop.index0 %}
<div id='{{spriteDivId}}' stage-id='{{ stage.stageId }}' sprite-name='{{ spriteName }}' class='sprite grid-{{ typeArr }}'>
{{ brickViewList[spriteName]|raw }}
</div>
{% endfor %}

<div class='clear'></div>
</div>
{% endfor %}
</div>