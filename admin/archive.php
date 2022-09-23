<?php
$action = $_GET['action'];
$iddel = $_GET['iddel'];
$evdel = $_GET['evdel'];
if ($action == 'del') {
require_once 'inc/bussol.conf.php';
$querycatalogue = "DELETE FROM ".$evdel." WHERE id=".$iddel."";
$resultcatalogue = mysqli_query($conn,$querycatalogue);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Onychology Course Admin</title>
<link href="../css/style2.css" rel="stylesheet" type="text/css" />

<script language="javascript" src="js/jquery-3.2.0.min.js" type="text/javascript"></script>

<script language="javascript" type="text/javascript">

function send_data(myidok,myeventok,mypaid) {


  var cb = $("input#paid"+mypaid);

  if (cb.is(":checked")) {
    var name = "oui";
  } 
  else {
    var name = "non";  
  }  

   $.post( 'ajax.php' , { paidchange : name, myidok : myidok, myeventok : myeventok }, 
       function( response ) {
         $( "#result" ).html( response );
       }
    );
  
  var name = "";
  var myidok = "";
  var myeventok = "";
}

</script>

</head>
<body>  
  
  <?php $mypaid = "0"; ?>  

<center>
    <br />
  <p><a style="color: #F00; font-size: 18px;" href="index.php">Upcoming</a></p>
<br>
  <table width="890" border="0" class="tablewhite">
    <tr>
      <td>
<table width="890" border="0" align="center" cellpadding="10" cellspacing="0" class="tablebottom">
    <tr>
      <td class="bordertdleftCopy"><p><?php if ($_GET['msg'] == "Export") { ?><center>Export Success</center> <?php } ?></p>
<strong><span style="font-size: 18px;">Onychology Course 2018 (global) <a href="https://www.onychologycourse.eu/admin/adminer/adminer.php?username=&select=Onychologycourse_2018" target="_blank"><img src="edit.png" align="top"/></a></span></strong><br><br>
        <table width="100%" border="0">
          <tr>
            <td><strong>ID</strong></td>
            <td><strong>First name</strong></td>
            <td><strong>Last name</strong></td>            
            <td><strong>Email</strong></td>
            <td><strong>INAMI</strong></td>     
            <td><strong>Form submitting date</strong></td>
                                     <td><strong>Paid ?</strong></td>            
                                     <td><strong>Edit ?</strong></td>
                                     <td><strong>Del ?</strong></td>
          </tr>
<?php
require_once 'inc/bussol.conf.php';
$myattend = 0;
$querycatalogue2 = "SELECT id FROM Onychologycourse_2018 ORDER BY id";
$resultcatalogue2 = mysqli_query($conn,$querycatalogue2);
while($row2 = mysqli_fetch_row($resultcatalogue2)){
  $myattend = $myattend + 1;
}

$querycatalogue = "SELECT id,firstname,lastname,recipientmail,INAMI,datesubscribed,paid FROM Onychologycourse_2018 ORDER BY id";
$resultcatalogue = mysqli_query($conn,$querycatalogue);
while($row = mysqli_fetch_row($resultcatalogue)){
  $id = $row[0];
  $firstname = $row[1];
  $lastname = $row[2];  
  $email = $row[3]; 
  $INAMI = $row[4];
  $updated = $row[5]; 
  $paid = $row[6];    
 
  
?>
          <tr>
            <td><?php echo $id; ?></td>
            <td><?php echo $firstname; ?></td>
            <td><?php echo $lastname; ?></td>
            <td><?php echo $email; ?></td>
            <td><?php echo $INAMI; ?></td>        
 
                        <td><?php echo $updated; ?></td>
<td><div style="margin-left: 10px;">
<?php $event="Onychologycourse_2018";?>
<input type="checkbox" id="paid<?php echo $mypaid;?>" name="paid<?php echo $mypaid;?>" value="oui" OnClick="javascript:send_data(<?php echo $id;?>,'<?php echo $event;?>',<?php echo $mypaid;?>);" <?php if ($paid == "oui") { ?>checked <?php } ?> />
<?php $mypaid++; ?>
</div>
</td>

                        <td><a href="https://www.onychologycourse.eu/admin/adminer/adminer.php?username=&edit=Onychologycourse_2018&where%5Bid%5D=<?php echo $id; ?>" target="_blank"><img width="24" height="24" src="edit2.png"/></a></td>

                         <td><a href="index.php?action=del&iddel=<?php echo $id;?>&evdel=Onychologycourse_2018" onclick="return confirm('Are you sure you want to delete this item?');"><img src="del.png" width="24" height="24" /></a></td>
          </tr>
<?php } ?>
        </table>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <form id="form1" name="form1" method="post" action="export.php">
            <center>
              <input type="submit" name="button" id="button" value="EXPORT" />
            </center>
        </form>
        <p>&nbsp;</p></td>
    </tr>
  </table>      
      </td>
    </tr>
  </table>
  <br />
</center>
  Subscribed: <?php echo $myattend; ?><br />    


<center>
    <br />
  <br />
  <table width="890" border="0" class="tablewhite">
    <tr>
      <td>
<table width="890" border="0" align="center" cellpadding="10" cellspacing="0" class="tablebottom">
    <tr>
      <td class="bordertdleftCopy"><p><?php if ($_GET['msg'] == "Export") { ?><center>Export Success</center> <?php } ?></p>
<strong><span style="font-size: 18px;">Onychology Course 2018 (Français) <a href="https://www.onychologycourse.eu/admin/adminer/adminer.php?username=&select=Onychologycourse_2018&where%5B0%5D%5Bcol%5D=lang&where%5B0%5D%5Bop%5D=&where%5B0%5D%5Bval%5D=fr&where%5B01%5D%5Bcol%5D=&where%5B01%5D%5Bop%5D=&where%5B01%5D%5Bval%5D=&limit=50" target="_blank"><img src="edit.png" align="top"/></a></span></strong><br><br>
        <table width="100%" border="0">
          <tr>
            <td><strong>ID</strong></td>
            <td><strong>First name</strong></td>
            <td><strong>Last name</strong></td>            
            <td><strong>Email</strong></td>
            <td><strong>INAMI</strong></td>     
            <td><strong>Form submitting date</strong></td>
                                     <td><strong>Paid ?</strong></td>            
                                     <td><strong>Edit ?</strong></td>
                                     <td><strong>Del ?</strong></td>
          </tr>
<?php
require_once 'inc/bussol.conf.php';
$myattend = 0;
$querycatalogue2 = "SELECT id FROM Onychologycourse_2018 where lang='fr' ORDER BY id";
$resultcatalogue2 = mysqli_query($conn,$querycatalogue2);
while($row2 = mysqli_fetch_row($resultcatalogue2)){
  $myattend = $myattend + 1;
}

$querycatalogue = "SELECT id,firstname,lastname,recipientmail,INAMI,datesubscribed,paid FROM Onychologycourse_2018 where lang ='fr' ORDER BY id";
$resultcatalogue = mysqli_query($conn,$querycatalogue);
while($row = mysqli_fetch_row($resultcatalogue)){
  $id = $row[0];
  $firstname = $row[1];
  $lastname = $row[2];  
  $email = $row[3]; 
  $INAMI = $row[4];
  $updated = $row[5]; 
  $paid = $row[6];    
 
  
?>
          <tr>
            <td><?php echo $id; ?></td>
            <td><?php echo $firstname; ?></td>
            <td><?php echo $lastname; ?></td>
            <td><?php echo $email; ?></td>
            <td><?php echo $INAMI; ?></td>        
 
                        <td><?php echo $updated; ?></td>
<td><div style="margin-left: 10px;">
<?php $event="Onychologycourse_2018";?>
<input type="checkbox" id="paid<?php echo $mypaid;?>" name="paid<?php echo $mypaid;?>" value="oui" OnClick="javascript:send_data(<?php echo $id;?>,'<?php echo $event;?>',<?php echo $mypaid;?>);" <?php if ($paid == "oui") { ?>checked <?php } ?> />
<?php $mypaid++; ?>
</div>
</td>

                        <td><a href="https://www.onychologycourse.eu/admin/adminer/adminer.php?username=&edit=Onychologycourse_2018&where%5Bid%5D=<?php echo $id; ?>" target="_blank"><img width="24" height="24" src="edit2.png"/></a></td>

                         <td><a href="index.php?action=del&iddel=<?php echo $id;?>&evdel=Onychologycourse_2018" onclick="return confirm('Are you sure you want to delete this item?');"><img src="del.png" width="24" height="24" /></a></td>
          </tr>
<?php } ?>
        </table>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <form id="form1" name="form1" method="post" action="export2.php">
            <center>
              <input type="submit" name="button" id="button" value="EXPORT" />
            </center>
        </form>
        <p>&nbsp;</p></td>
    </tr>
  </table>      
      </td>
    </tr>
  </table>
  <br />
</center>
  Subscribed: <?php echo $myattend; ?><br /> 

<center>
    <br />
  <br />
  <table width="890" border="0" class="tablewhite">
    <tr>
      <td>
<table width="890" border="0" align="center" cellpadding="10" cellspacing="0" class="tablebottom">
    <tr>
      <td class="bordertdleftCopy"><p><?php if ($_GET['msg'] == "Export") { ?><center>Export Success</center> <?php } ?></p>
<strong><span style="font-size: 18px;">Onychology Course 2018 (English) <a href="https://www.onychologycourse.eu/admin/adminer/adminer.php?username=&select=Onychologycourse_2018&where%5B0%5D%5Bcol%5D=lang&where%5B0%5D%5Bop%5D=&where%5B0%5D%5Bval%5D=en&where%5B01%5D%5Bcol%5D=&where%5B01%5D%5Bop%5D=&where%5B01%5D%5Bval%5D=&limit=50" target="_blank"><img src="edit.png" align="top"/></a></span></strong><br><br>
        <table width="100%" border="0">
          <tr>
            <td><strong>ID</strong></td>
            <td><strong>First name</strong></td>
            <td><strong>Last name</strong></td>            
            <td><strong>Email</strong></td>
            <td><strong>INAMI</strong></td>     
            <td><strong>Form submitting date</strong></td>
                                     <td><strong>Paid ?</strong></td>            
                                     <td><strong>Edit ?</strong></td>
                                     <td><strong>Del ?</strong></td>
          </tr>
<?php
require_once 'inc/bussol.conf.php';
$myattend = 0;
$querycatalogue2 = "SELECT id FROM Onychologycourse_2018 where lang='en' ORDER BY id";
$resultcatalogue2 = mysqli_query($conn,$querycatalogue2);
while($row2 = mysqli_fetch_row($resultcatalogue2)){
  $myattend = $myattend + 1;
}

$querycatalogue = "SELECT id,firstname,lastname,recipientmail,INAMI,datesubscribed,paid FROM Onychologycourse_2018 where lang ='en' ORDER BY id";
$resultcatalogue = mysqli_query($conn,$querycatalogue);
while($row = mysqli_fetch_row($resultcatalogue)){
  $id = $row[0];
  $firstname = $row[1];
  $lastname = $row[2];  
  $email = $row[3]; 
  $INAMI = $row[4];
  $updated = $row[5]; 
  $paid = $row[6];    
 
  
?>
          <tr>
            <td><?php echo $id; ?></td>
            <td><?php echo $firstname; ?></td>
            <td><?php echo $lastname; ?></td>
            <td><?php echo $email; ?></td>
            <td><?php echo $INAMI; ?></td>        
 
                        <td><?php echo $updated; ?></td>
<td><div style="margin-left: 10px;">
<?php $event="Onychologycourse_2018";?>
<input type="checkbox" id="paid<?php echo $mypaid;?>" name="paid<?php echo $mypaid;?>" value="oui" OnClick="javascript:send_data(<?php echo $id;?>,'<?php echo $event;?>',<?php echo $mypaid;?>);" <?php if ($paid == "oui") { ?>checked <?php } ?> />
<?php $mypaid++; ?>
</div>
</td>

                        <td><a href="https://www.onychologycourse.eu/admin/adminer/adminer.php?username=&edit=Onychologycourse_2018&where%5Bid%5D=<?php echo $id; ?>" target="_blank"><img width="24" height="24" src="edit2.png"/></a></td>

                         <td><a href="index.php?action=del&iddel=<?php echo $id;?>&evdel=Onychologycourse_2018" onclick="return confirm('Are you sure you want to delete this item?');"><img src="del.png" width="24" height="24" /></a></td>
          </tr>
<?php } ?>
        </table>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <form id="form1" name="form1" method="post" action="export3.php">
            <center>
              <input type="submit" name="button" id="button" value="EXPORT" />
            </center>
        </form>
        <p>&nbsp;</p></td>
    </tr>
  </table>      
      </td>
    </tr>
  </table>
  <br />
</center>
  Subscribed: <?php echo $myattend; ?><br />       
</body>
</html>