<?php
// クラス読み込み
require('chat.class.php');
?>

<!DOCTYPE html>
<html lang = “ja”>
<head>
<meta charset = “UFT-8”>
<title>Chat-History</title>
</head>
<body>
<!- heading ->
<h1>Chat History</h1>
<!- heading ->

<form method="POST" action="chat_history.php">
<input type="submit" value="Refresh" />
</form>

<!- chat_log ->
<table>
<?php for ($i=0; $i<=15; $i++) { ?>
<tr>
<td><?php echo Chat::get_user_name(Chat::getLog($i)['user_id']); ?></td>
<td><?php echo Chat::getLog($i)['text']; ?></td>
<td><?php echo "(".Chat::getLog($i)['date'].")";?></td> 
</tr>
<?php } ?>
</table>
<!- chat_log ->

<hr>

<form method="POST" action="chat_history.php">
<input type="submit" value="Refresh" />
</form>

<a href="javascript:;" onclick="window.close();">Close</a>
</body>
</html>
