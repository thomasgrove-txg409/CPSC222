<?php
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
$e_name = $_POST["e_name"];
$hrs = floatval($_POST["hrs"]);
$rate = floatval($_POST["rate"]);
$fed_t = floatval($_POST["fed_t"]);
$state_t = floatval($_POST["state_t"]);

$fed_t = $fed_t * 0.01;
$state_t = $state_t * 0.01;

$gross = $hrs * $rate;
$fed_w = $gross * $fed_t;
$state_w = $gross * $state_t;
$deduct = $fed_w + $state_w;
$net = $gross - $deduct;
$annual = $gross * 52;

if ($annual <= 11925)
{$bracket = "10%";}
elseif ($annual <= 48475)
{$bracket = "12%";}
elseif ($annual <= 103350)
{$bracket = "22%";}
elseif ($annual <= 197300)
{$bracket = "24%";}
elseif ($annual <= 250525)
{$bracket = "32%";}
elseif ($annual <= 626350)
{$bracket = "35%";}
else
{$bracket = "37%";}
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payroll Calculator</title>
    <style>
        table { border-collapse: collapse; width: 50%; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
<h1>Payroll Calculator</h1>

<form method="POST">
Name:<br>
<input type="text" name="e_name"><br>
Hours Worked:<br>
<input type="number" step="0.1" name="hrs"><br>
Pay Rate:<br>
<input type="number" step="0.01" name="rate"><br>
Federal Tax Rate:<br>
<input type="number" step="0.01" name="fed_t"><br>
State Tax Rate:<br>
<input type="number" step="0.01" name="state_t"><br><br>
<input type="submit" value="Calculate">
</form>

<?php
$fed_t = $fed_t * 100;
$state_t = $state_t * 100;
#I think this was the easiest way to convert back into percentages for display.


if ($_SERVER["REQUEST_METHOD"] == "POST")
{
echo "<h2>Payroll Results</h2>";
echo "<table>";
echo "<tr><td>Employee Name</td><td>$e_name</td></tr>";
echo "<tr><td>Hours Worked</td><td>".number_format($hrs,1)."</td></tr>";
echo "<tr><td>Pay Rate</td><td>$".number_format($rate,2)."</td></tr>";
echo "<tr><td>Gross Pay</td><td>$".number_format($gross,2)."</td></tr>";
echo "<tr><td colspan='2'><b>Deductions</b></td></tr>";
echo "<tr><td>Federal Withholding (".($fed_t)."%)</td><td>$".number_format($fed_w,2)."</td></tr>";
echo "<tr><td>State Withholding (".($state_t)."%)</td><td>$".number_format($state_w,2)."</td></tr>";
echo "<tr><td>Total Deductions</td><td>$".number_format($deduct,2)."</td></tr>";
echo "<tr><td>Net Pay</td><td>$".number_format($net,2)."</td></tr>";
echo "<tr><td colspan='2'>Tax Bracket: <b>$bracket</b></td></tr>";
echo "</table>";
}
?>
</body>
</html>
