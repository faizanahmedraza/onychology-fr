
<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (isset($_REQUEST['paidchange'])) {

print_r($_POST);

   $paidchange = $_REQUEST['paidchange'];
   $myidok = $_REQUEST['myidok'];
   $myeventok = $_REQUEST['myeventok'];

   require_once 'inc/bussol.conf.php';

	$querycatalogue2 = "SELECT datesubscribed FROM $myeventok WHERE id='$myidok'";
    $resultcatalogue2 = mysqli_query($conn,$querycatalogue2);

	$resultcatalogue2 = mysqli_query($conn,$querycatalogue2);
	while($row = mysqli_fetch_row($resultcatalogue2)){
  	$datesubscribed = $row[0];
    }


    $querycatalogue = "UPDATE $myeventok SET paid='$paidchange', datesubscribed='$datesubscribed' WHERE id='$myidok'";
    $resultcatalogue = mysqli_query($conn,$querycatalogue);

}
}


?>
