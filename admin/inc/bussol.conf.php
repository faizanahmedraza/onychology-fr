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
//$mylink = mysqli_connect($myhostname,$myusername,$mypassword)
//                 or die("Could not connect: " . mysqli_error());
//mysqli_set_charset('utf8',$mylink);
//
//// make $mydbselect the current db
//mysqli_select_db($mydbselect, $mylink)
//                 or die ("Can't use $mydbselect : " . mysqli_error());


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