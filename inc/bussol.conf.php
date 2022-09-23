<?php
/*
   This script must be included in all the pages which use a connection to the mysql database.
   Either connection succeeds, or an error message is brought back and the script stops.
 
   Written by Christophe Bonnarens
   Created on 01-04-2008
*/
// We define working variable
// Hostname 
//$myhostname = "localhost";
//// Username
//$myusername = "admin_onycho1";
//$mypassword = "t0Ju@11a";
//// DB select
//$mydbselect = "admin_onycho";
//
//// Connect to the database.....
//$mylink = mysql_connect($myhostname,$myusername,$mypassword)
//                 or die("Could not connect: " . mysql_error());
//mysql_set_charset('utf8',$mylink);
//
//// make $mydbselect the current db
//mysql_select_db($mydbselect, $mylink)
//                 or die ("Can't use $mydbselect : " . mysql_error());


//new connection script
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admin_onycho";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn,'utf8');
?>