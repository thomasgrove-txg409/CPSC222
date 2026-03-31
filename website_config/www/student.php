<?php
class Student
{
private $fname;
private $lname;
private $id;
private $courses;

public function __construct($fname,$lname,$id,$courses)
{
$this->setFname($fname);
$this->setLname($lname);
$this->setId($id);
$this->setCourses($courses);
}

private function setFname($fname){$this->fname=$fname;}
private function setLname($lname){$this->lname=$lname;}
private function setId($id){$this->id=$id;}
private function setCourses($courses){$this->courses=$courses;}

public function getFname(){return $this->fname;}
public function getLname(){return $this->lname;}
public function getId(){return $this->id;}
public function getCourses(){return $this->courses;}
}
?>
