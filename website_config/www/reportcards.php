<?php
include "student.php";
include "grade.php";

$s = array();

$s[0] = new Student("Kevin","Slonka",1001,array("CPSC222"=>98,"CPSC111"=>76,"CPSC333"=>82));
$s[1] = new Student("Joe","Schmoe",1005,array("CPSC122"=>88,"CPSC411"=>46,"CPSC323"=>72));
$s[2] = new Student("Stewie","Griffin",1009,array("CPSC244"=>68,"CPSC116"=>96,"CPSC345"=>82));
?>

<!DOCTYPE html>
<html>
<head>
<title>Students</title>
</head>
<body>

<h1>Student Records</h1>

<?php
for($i=0;$i<count($s);$i++)
{
echo "<table border='1'>";
echo "<tr><td>Name</td><td>".$s[$i]->getLname().", ".$s[$i]->getFname()."</td></tr>";
echo "<tr><td>Student ID</td><td>".$s[$i]->getId()."</td></tr>";
echo "<tr><td>Grades</td><td><ul>";

foreach($s[$i]->getCourses() as $course=>$grade)
{
echo "<li>".$course." - ".$grade."% ".getLetter($grade)."</li>";
}

echo "</ul></td></tr>";
echo "</table><br>";
}
?>

</body>
</html>
