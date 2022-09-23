
<?php
function adminer_object() {
  
  class AdminerSoftware extends Adminer {
    
    function name() {
      // custom name in title and heading
      return 'Onychology Admin Editor by Bussol';
    }
    
    function credentials() {
      // server, username and password for connecting to database
      return array('localhost', 'admin_onycho1', 't0Ju@11a');
    }
    
    function database() {
      // database name, will be escaped by Adminer
      return 'admin_onycho';
    }
 
  function tableName($tableStatus) {
    return h($tableStatus["congres_2017"]);
  }

  function selectImportPrint() {

  }

  function selectEmailPrint($blah, $nein) {
  }  
    
  }
  
  return new AdminerSoftware;
}

include "./editor.php";


?>
