<html>
<head>
<title>Untitled Document</title>

<script language="javascript" src="https://code.jquery.com/jquery-1.11.1.min.js" type="text/javascript"></script>

<script language="javascript" type="text/javascript">

send_data = function(name,myidok,myeventok) {

        $.ajax({
      url: "ajax.php",
            data: {'paidchange' : name, 'myidok' : myidok, 'myeventok' : myeventok},
            type: "POST",
            cache: false

    }).done(function(data, status, xml) {

         var obj = jQuery.parseJSON(data);

        }).fail(function(jqXHR, textStatus, errorThrown) {


        }).always(function() {


        });

}


function gotoajax(myid,myevent){
        var cb = $("input#paid");

        if (cb.is(":checked")) {
            send_data(cb.val(),myid,myevent);
        } else {
            send_data("non",myid,myevent);
        }
        return false; 
 
}
</script>

</head>
<body>
<?php $id="15";?>
<?php $event="guatemala";?>
<input type="checkbox" id="paid" name="paid" value="oui" OnClick="javascript:send_data(<?php echo $id;?>,'<?php echo $event;?>');" <?php if ($paid == "oui") { ?>checked <?php } ?>/>


</form>
</body>
</html>