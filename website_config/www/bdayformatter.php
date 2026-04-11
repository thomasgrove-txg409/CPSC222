<?php

function filter($data)
{
$data = trim($data);
$data = preg_replace("/[^a-zA-Z0-9\s\-\:]/", "", $data);
return $data;
}

function n_format($m,$d,$y,$h,$min,$ampm)
{
$time = "$m $d $y $h:$min $ampm";
$ts = strtotime($time);
return date("l F jS, Y - g:ia", $ts); 
}

function iso_format($m,$d,$y,$h,$min,$ampm)
{
$time = "$m $d $y $h:$min $ampm";
$ts = strtotime($time);
return date("Y-m-d H:i:s", $ts);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Birthday Formatter</title>
</head>
<body>

<h1>Birthday Formatter</h1>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
$m = filter($_POST["month"]);
$d = filter($_POST["day"]);
$y = filter($_POST["year"]);
$h = filter($_POST["hour"]);
$min = filter($_POST["minute"]);
$ampm = filter($_POST["ampm"]);

echo n_format($m,$d,$y,$h,$min,$ampm);
echo "<br><br>";
echo "<a href='?iso=1&m=$m&d=$d&y=$y&h=$h&min=$min&ampm=$ampm'>Show date in ISO format</a>";
}

elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["iso"]))
{
$m = filter($_GET["m"]);
$d = filter($_GET["d"]);
$y = filter($_GET["y"]);
$h = filter($_GET["h"]);
$min = filter($_GET["min"]);
$ampm = filter($_GET["ampm"]);

echo iso_format($m,$d,$y,$h,$min,$ampm);
}

else 
{
?>

<form method="POST">
<table border="1">
<tr>
<th>Month</th>
<th>Day</th>
<th>Year</th>
<th>Hour</th>
<th>Minute</th>
<th>AM/PM</th>
</tr>

<tr>
<td>
<select name="month">
<option>January</option>
<option>February</option>
<option>March</option>
<option>April</option>
<option>May</option>
<option>June</option>
<option>July</option>
<option>August</option>
<option>September</option>
<option>October</option>
<option>November</option>
<option>December</option>
</select>
</td>

<td>
<select name="day">
<?php
for($i=1;$i<=31;$i++)
{
echo "<option>$i</option>";
}
?>
</select>
</td>

<td>
<select name="year">
<?php
for($i=1909;$i<=2026;$i++)
{
echo "<option>$i</option>";
}
?>
</select>
</td>

<td>
<select name="hour">
<?php
for($i=1;$i<=12;$i++)
{
echo "<option>$i</option>";
}
?>
</select>
</td>

<td>
<select name="minute">
<?php
for($i=0;$i<=59;$i++)
{
$v = str_pad($i,2,"0",STR_PAD_LEFT);
echo "<option>$v</option>";
}
?>
</select>
</td>

<td>
<select name="ampm">
<option>AM</option>
<option>PM</option>
</select>
</td>
</tr>

<!--I know your screenshots had Formate but I assume that's a typo. -->
<tr>
<td colspan="6" style="text-align:center;">
<input type="submit" value="Format Date">
</td>
</tr>

</table>
</form>

<?php
}
?>
