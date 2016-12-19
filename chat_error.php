<?php
// クラス読み込み
require('chat.class.php');
// クエリの取得
$cd = $_REQUEST['cd'];
// エラーメッセージ取得
$message = Chat::getErrorMessage($cd);
?>

<!DOCTYPE html>
<html>
<head>
<title>Chat-Error101</title>
<meta charset="utf-8">
<style type="text/css">
<!--
h2 {
color: red;
}
h3 {
color: red;
}
-->
</style>
</head>
<body>

<h1>Chat</h1>	
<h2>Error</h2>
<h3><?php print $message; ?></h3>

<form action="chat_login.php">
<input type="submit" value="back" />
</form>

</body>
</html>
