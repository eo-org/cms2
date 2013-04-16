<link href="{{ siteConfig('extUrl') }}/reset.css" media="screen" rel="stylesheet" type="text/css" >
<link href="{{ siteConfig('libUrl') }}/front/style/sprite.css" media="screen" rel="stylesheet" type="text/css" >
<script type="text/javascript" src="{{ siteConfig('extUrl') }}/src/jquery.1.8.3.min.js"></script>
{% for js in jsList %}
<script type="text/javascript" src="{{ siteConfig('libUrl') }}/front/script/effect/{{ js }}"></script>
{% endfor %}
{% for css in cssList %}
<link type="text/css" href="{{ siteConfig('libUrl') }}/front/script/effect/{{ css }}" media="screen" rel="stylesheet">
{% endfor %}

<script>
window.ORG_CODE = "{{ siteConfig('organizationCode') }}";
window.SITE_FOLDER = "{{ siteConfig('remoteSiteId') }}";
</script>

{% if sessionAdmin.hasPrivilege %}
<script type="text/javascript" src="{{ siteConfig('extUrl') }}/src/underscore.1.3.1.min.js"></script>
<script type="text/javascript" src="{{ siteConfig('extUrl') }}/src/backbone.0.9.1.min.js"></script>
<!--link	type="text/css"			href="http://minify.enorange.cn/?b=resource/cms/v4/admin/style&f=structure.css,front.css" media="screen" rel="stylesheet" -->
<link type="text/css" href="{{ siteConfig('libUrl') }}/admin/style/structure.css" media="screen" rel="stylesheet">
<link type="text/css" href="{{ siteConfig('libUrl') }}/admin/style/front.css" media="screen" rel="stylesheet">

<!--  script type="text/javascript"	src="http://minify.enorange.cn/?b=resource&f=ext/func.js,ext/jquery.ndd.js,cms/v2/script/front.js,cms/v2/script/lightbox.js,cms/v2/script/links.js,cms/v2/script/bootstrap.js,cms/v2/script/icon-selector.js"></script -->
<script type="text/javascript"	src="{{ siteConfig('extUrl') }}/jquery.ndd.js"></script>
<script type="text/javascript"	src="{{ siteConfig('libUrl') }}/script/front.js"></script>
<script type="text/javascript"	src="{{ siteConfig('libUrl') }}/script/lightbox.js"></script>
<script type="text/javascript"	src="{{ siteConfig('libUrl') }}/script/bootstrap.js"></script>
<script type="text/javascript"	src="{{ siteConfig('libUrl') }}/script/icon-selector.js"></script>
<script type="text/javascript"	src="{{ siteConfig('libUrl') }}/script/codemirror.js"></script>

<script type="text/javascript"	src="{{ siteConfig('extUrl') }}/brick/action-menu/action-menu.front.js"></script>
<link href="{{ siteConfig('extUrl') }}/brick/action-title/action-title.css" media="screen" rel="stylesheet" type="text/css" >
<link href="{{ siteConfig('extUrl') }}/brick/action-menu/action-menu.css" media="screen" rel="stylesheet" type="text/css" >

<!-- script type="text/javascript"	src="{{ siteConfig('extUrl') }}/ckeditor/ckeditor.js"></script -->

<link type="text/css" href="{{ siteConfig('extUrl') }}/codemirror/codemirror.css" media="screen" rel="stylesheet">
<script type="text/javascript" src="{{ siteConfig('extUrl') }}/codemirror/codemirror.js"></script>
<script type="text/javascript" src="{{ siteConfig('extUrl') }}/codemirror/mode/xml.js"></script>
<script type="text/javascript" src="{{ siteConfig('extUrl') }}/codemirror/mode/javascript.js"></script>
<script type="text/javascript" src="{{ siteConfig('extUrl') }}/codemirror/mode/css.js"></script>
<script type="text/javascript" src="{{ siteConfig('extUrl') }}/codemirror/mode/htmlmixed.js"></script>

<script>
/************************************/
/*Declear Global Javascript Items****/
/************************************/
var LAYOUT_STAGE_CHANGED = false;
var CURR_STATUS;
var STAGE_ID;
var SPRITE_NAME;
var MINI_BRICK_MASK;

var WB;
var FINDER;
var EventMessenger = {};
_.extend(EventMessenger, Backbone.Events);
</script>
{% endif %}

{{ headLink() }}
{{ headScript() }}