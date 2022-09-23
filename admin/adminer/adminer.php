
<?php
function adminer_object() {
  
  class AdminerSoftware extends Adminer {
    
    function name() {
      // custom name in title and heading
      return 'Onychology Admin Editor';
    }
    
    function credentials() {
      // server, username and password for connecting to database
      return array('localhost', 'onycholo_admin', 'WWuNN!!=O~OB');
    }
    
    function database() {
      // database name, will be escaped by Adminer
      return 'onycholo_onycho1';
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
