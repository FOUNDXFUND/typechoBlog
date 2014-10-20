<?php


$con = mysql_connect("localhost","root","johnsneakers");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
echo 1;
// some code

mysql_close($con);
