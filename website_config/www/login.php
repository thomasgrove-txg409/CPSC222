<?php
session_start();

function filter($data)
{
$data = trim($data);
$data = preg_replace("/[^a-zA-Z0-9]/", "", $data);
return $data;
}

function check_login($u,$p)
{
$file = file("users.txt");

foreach($file as $line)
{
$parts = explode(" ", trim($line));
$user = $parts[0];
$pass = $parts[1];

if($u == $user && $p == $pass)
{
return true;
}
}
return false;
}

if(isset($_GET["logout"]))
{
session_destroy();
header("Location: login.php");
exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{
$u = filter($_POST["username"]);
$p = filter($_POST["password"]);

if(check_login($u,$p))
{
$_SESSION["user"] = $u;
}
else
{
$error = "Invalid Login";
}
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
</head>
<body>

<?php

if(isset($_SESSION["user"]))
{
echo "<h2>Hello, ".$_SESSION["user"]."</h2>";
echo "<a href='?logout=1'>Logout</a>";
}

else
{
if(isset($error))
{
echo "<p>$error</p>";
}
?>

<form method="POST">
Username:<br>
<input type="text" name="username"><br>
Password:<br>
<input type="password" name="password"><br><br>
<input type="submit" value="Login">
</form>

<?php
}
?>

</body>
</html>
