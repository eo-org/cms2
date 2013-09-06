<ul id='disqus-post-holder' data-topic='{{topic}}' data-resource-id='{{resourceId}}'></ul>

<textarea id='disqus-content'></textarea>

<input id='disqus-submit' type='button' name='' value='submit' />

<script id='disqus-post-template' type='text/template'>
<%
var date = new Date(item.created.sec * 1000);
var dateString = date.getFullYear() + "-" + date.getMonth()+1 + "-" + date.getDate() + " " + date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
%>
<li>
	<div class='post-info'>
		<div class='userName'><%=item.userName%></div>
		<div class='date'><%=dateString%></div>
	</div>
	<div class='post-content'>
		<%-item.content%>
	</div>
</li>
</script>