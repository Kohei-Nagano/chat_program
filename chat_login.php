<!DOCTYPE html>
<html>
<head>
<title>Chat-Login</title>
<meta charset="utf-8">

</head>
<body>

<h1>Chat</h1>

<! [入力フォーム] >
<form method="POST" action="chat.php" onsubmit="return( confirm('この内容で書き込んでよろしいですか？') )">
<table>
<tr>
  <td>Login ID</td>
  <td><input type="text" name="login_id"></td>
</tr>
<tr>
  <td>Password</td>
  <td><input type="password" name="password"></td>
</tr>
<tr>
  <td></td>
  <td><input type="submit" value="Login"></td>
</tr>
</table>
</form>

</body>
</html>

