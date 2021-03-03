<?
$link = mysqli_connect("cloud503.nic.ua", "gravisco_moskal", "ssa260579", "gravisco_account");
//mysqli_select_db("gravisco_account");
mysqli_set_charset($link, 'utf8');

if(isset($_POST['login']))
{
$query = mysqli_query($link, "SELECT * FROM users WHERE user_login='".mysqli_real_escape_string($link, $_POST['login'])."' LIMIT 1");
    $data = mysqli_fetch_assoc($query);
    # Сравниваем пароли
    if($data['user_password'] === md5(md5($_POST['password'])))
    {
	session_start();
    	$_SESSION['user_id'] = $data['user_id'];
		$_SESSION['user_name'] = $data['user_name'];
    	$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
    }
	header("Location: https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
  	exit;
}

if (isset($_GET['action']) AND $_GET['action']=="logout") {
  session_start();
  session_destroy();
  header("Location: https://".$_SERVER['HTTP_HOST']."/");
  exit;
}
if (isset($_REQUEST[session_name()])) session_start();
if (isset($_SESSION['user_id']) AND $_SESSION['ip'] == $_SERVER['REMOTE_ADDR']) return;
else {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf8"/>
	<title>Вход - Учетная система GRAVIS</title>
	<meta name="ROBOTS" content="NONE"/>	
	<link rel="stylesheet" type="text/css" href="/css/main.css"  media="all"/>
</head>
<body>
<center>
<strong>Вход</strong></br>
<form method="POST">
Имя пользователя: <input type="text" name="login"></br>
Пароль: <input type="password" name="password"></br>
<input type="submit" value="Войти"><br>
</form>
</center>
</body>
</html>
<? 
}
exit;
?>