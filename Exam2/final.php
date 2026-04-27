<?php
session_start();

function filter($data)
{
$data = trim($data);
$data = preg_replace("/[^a-zA-Z0-9]/", "", $data);
return $data;
}

function auth($u,$p)
{
$file = file("auth.db");

foreach($file as $line)
{
$parts = explode("\t",trim($line));

if(count($parts) >= 2)
{
$user = $parts[0];
$pass = $parts[1];


if($u == $user && password_verify($p,$pass))
{
return true;
}

}

}

return false;
}

function header_page()
{
echo "<h1>CPSC222 Final Exam</h1><hr>";
}

function footer_page()
{
echo "<hr>";
echo date("Y-m-d h:i:s A");
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{
$u = filter($_POST["user"]);
$p = filter($_POST["pass"]);

if(auth($u,$p))
{
$_SESSION["user"] = $u;
}
else
{
$error = "Invalid login ...";
}
}

header_page();

if(!isset($_SESSION["user"]))
{
if(isset($error))
{
echo "<p>$error</p>";
}

echo '
<form method="POST">
Username:<br>
<input type="text" name="user"><br>
Password:<br>
<input type="password" name="pass"><br>
<input type="submit" value="Login">
</form>
';

footer_page();
exit();
}

echo "<h2>Welcome, ".$_SESSION["user"]."! <a href='final_logout.php'>(Log Out)</a></h2>";


if(isset($_GET["page"]) && $_GET["page"] == "adminpanel")
{
echo "<a href='final.php'>< Back to Dashboard</a><br><br>";
echo "<h3>About the Author</h3>";
echo "<img src='thomas.jpg' width='200'><br>";
echo "<p> My name is Thomas Grove, a junior at SFU. Most of my interests are releated to reading or video games. I can't say I've read anything good recently because Ready Player One wasn't as good the second time, and the sequel was dreadful. My favorite games are Arknights and Arena Breakout Infinite. After graduation, I planning on doing whatever the government tells me to do, as long as it pays well.</p>";
footer_page();
exit();
}

if(!isset($_GET["page"]))
{
echo "<p>Dashboard:</p>";
echo "<ul>";
echo "<li><a href='?page=userlist'>User list</a></li>";
echo "<li><a href='?page=grouplist'>Group list</a></li>";
echo "<li><a href='?page=syslog'>Syslog</a></li>";
echo "</ul>";

footer_page();
exit();
}

$page = filter($_GET["page"]);

echo "<a href='final.php'>< Back to Dashboard</a><br><br>";

if($page == "userlist")
{
echo "<h3>User list</h3>";
echo "<table border='1'>";

$file = file("/etc/passwd");

foreach($file as $line)
{
$data = explode(":",trim($line));

echo "<tr>";
for($i=0;$i<count($data);$i++)
{
echo "<td>".$data[$i]."</td>";
}
echo "</tr>";
}

echo "</table>";
}


elseif($page == "grouplist")
{
echo "<h3>Group list</h3>";
echo "<table border='1'>";

$file = file("/etc/group");

foreach($file as $line)
{
$data = explode(":",trim($line));

echo "<tr>";
for($i=0;$i<count($data);$i++)
{
echo "<td>".$data[$i]."</td>";
}
echo "</tr>";
}

echo "</table>";
}


elseif($page == "syslog")
{
echo "<h3>Syslog</h3>";
echo "<table border='1'>";

$file = file("/var/log/syslog");

foreach($file as $line)
{
$data = preg_split("/\s+/",$line,5);

echo "<tr>";
for($i=0;$i<count($data);$i++)
{
echo "<td>".$data[$i]."</td>";
}
echo "</tr>";
}

echo "</table>";
}

else
{
echo "Invalid page";
}

footer_page();
?>
