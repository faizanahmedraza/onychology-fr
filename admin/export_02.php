<?php
require_once 'inc/bussol.conf.php';
// Liste les donn�es de la table
// -------------------------------------------
$resQuery = mysqli_query($conn,"SELECT * FROM Onychologycourse_2019 where lang='fr'");

header("Content-Type: application/csv-tab-delimited-table");
header("Content-disposition: filename=Onychologycourse_2019_fr.csv");

if (mysqli_num_rows($resQuery) != 0) {
    // titre des colonnes
    $fields = mysqli_num_fields($resQuery);
    $i = 0;
    while ($i < $fields) {
        $colObj = mysqli_fetch_field_direct($resQuery, $i);
        echo $colObj->name . ",";
        $i++;
    }
    echo "\n";

    // donn�es de la table
    while ($arrSelect = mysqli_fetch_array($resQuery, MYSQLI_ASSOC)) {
        foreach ($arrSelect as $elem) {
            echo "$elem,";
        }
        echo "\n";
    }
}
?>