<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
{{ headMeta() }}
{{ headTitle() }}
{% include 'layout/head-client' %}
</head>

<body>
{% include 'layout/toolbar' %}

<div class='bg-wrapper'>
{% include 'layout/body-head' %}
{% include 'layout/body-main' %}
{% include 'layout/body-tail' %}
</div>

{% include 'layout/toolbar-tail' %}
</body>
</html>