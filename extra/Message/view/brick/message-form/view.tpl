<form class='messageform' method='POST' action='/message/create'>
{{ printHiddenInfo(messageForm) }}
<ul>
{{ printElements(messageForm) }}
</ul>
<input class='messageform-submit' type='submit' value='提交' />
</form>