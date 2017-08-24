<div style="background:black;-webkit-border-radius:15px;-moz-border-radius:15px;border-radius:15px;color:#FF0000">
	<span style="float:none;margin:0 auto;">Or add it into another php file and include it with a simple statement!</span>
</div>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
Username: <input type="text" name="username" placeholder="HINT: better" /><br/>
Password: <input type="password" name="pass" placeholder="done this way!" />
<input type="hidden" name="loginForm" value="1" />
<input type="submit" value="login" />
</form>