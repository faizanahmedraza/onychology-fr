<?php
require_once 'inc/bussol.conf.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $module1 = mysqli_real_escape_string($conn,trim($_POST['module_1']));
    $module2 = mysqli_real_escape_string($conn,trim($_POST['module_2']));
    $module3 = mysqli_real_escape_string($conn,trim($_POST['module_3']));
    $module4 = mysqli_real_escape_string($conn,trim($_POST['module_4']));
    $module5 = mysqli_real_escape_string($conn,trim($_POST['module_5']));
    $module6 = mysqli_real_escape_string($conn,trim($_POST['module_6']));
    $moduleTotal = mysqli_real_escape_string($conn,trim($_POST['module_total']));

    $packageModule = mysqli_real_escape_string($conn,trim($_POST['package_module']));
    $packageModuleA = mysqli_real_escape_string($conn,trim($_POST['package_module_a']));

    $prenom = mysqli_real_escape_string($conn,trim($_POST["prenom"]));
    $nom = mysqli_real_escape_string($conn,trim($_POST["nom"]));
    $specialite = mysqli_real_escape_string($conn,trim($_POST["specialite"]));
    $specialite_autre = mysqli_real_escape_string($conn,trim($_POST["specialite_autre"]));

    $INAMI = mysqli_real_escape_string($conn,trim($_POST["INAMI"]));
    $INAMI2 = mysqli_real_escape_string($conn,trim($_POST["INAMI2"]));
    $INAMI3 = mysqli_real_escape_string($conn,trim($_POST["INAMI3"]));
    $INAMI4 = mysqli_real_escape_string($conn,trim($_POST["INAMI4"]));

    $inamifinal = $INAMI . "/" . $INAMI2 . "/" . $INAMI3 . "/" . $INAMI4;

    $foreign_number = mysqli_real_escape_string($conn,trim($_POST["foreign_number"]));
    $rue = mysqli_real_escape_string($conn,trim($_POST["rue"]));
    $numero = mysqli_real_escape_string($conn,trim($_POST["numero"]));
    $codepostal = mysqli_real_escape_string($conn,trim($_POST["codepostal"]));
    $ville = mysqli_real_escape_string($conn,trim($_POST["ville"]));
    $pays = mysqli_real_escape_string($conn,trim($_POST["pays"]));
    $telephone = mysqli_real_escape_string($conn,trim($_POST["tel"]));
    $gsm_med = mysqli_real_escape_string($conn,trim($_POST["gsm_med"]));
    $Emailsub_med = mysqli_real_escape_string($conn,trim($_POST["Emailsub_med"]));

    $lang = mysqli_real_escape_string($conn,trim($_POST["lang"]));

    $adresse = mysqli_real_escape_string($conn,trim($_POST['Emailsub_med']));
}

$selectedModules = "";
$module1_2 = "";
if ((isset($moduleTotal) && !empty($moduleTotal))) {
    $tempArr = array();
    if (!empty($module1)) {
        $module1_2 = 'Module1';
        array_push($tempArr, 'Module1');
    }
    if (!empty($module2)) {
        $module1_2 = 'Module2';
        array_push($tempArr, 'Module2');
    }
    if (!empty($module3)) {
        $module3 = 'Module3';
        array_push($tempArr, 'Module3');
    }
    if (!empty($module4)) {
        $module4 = 'Module4';
        array_push($tempArr, 'Module4');
    }
    if (!empty($module5)) {
        $module5 = 'Module5';
        array_push($tempArr, 'Module5');
    }
    if (!empty($module6)) {
        $module6 = "Module6";
        array_push($tempArr, 'Module6');
    }
    $selectedModules = implode(',', $tempArr);
    $amount = $moduleTotal;
} elseif ((isset($packageModule) && !empty($packageModule))) {
    $selectedModules = "TOUS les MODULES";
    $amount = $packageModule;
} elseif ((isset($packageModuleA) && !empty($packageModuleA))) {
    $selectedModules = "Inscription pour toute la session pour les dermatologues en formation (internes)";
    $amount = $packageModuleA;
}

function VerifierAdresseMail($adresse)
{
    $Syntaxe = '#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
    if (preg_match($Syntaxe, $adresse))
        return true;
    else
        return false;
}

if (VerifierAdresseMail($adresse)) {
    include_once 'init.php';
} else {
    $message = urlencode("Le courriel est invalide!");
    header("Location:" . $_SERVER[HTTP_REFERER] . "?message=" . $message);
}

$moyen_paiement = 'virement';

$type_paiement = 'anticipatif';

$type_inscription = 'Participant';

$year_event = "2022";

$queryadduser = "INSERT INTO Onychologycourse_2021(year_event,firstname, lastname, specialite, specialite_autre, INAMI, foreign_number, recipientmail, rue, numero, codepostal, ville, pays, telephone, gsm_med, type_inscription, prix_total, type_paiement, moyen_paiement, lang,FridayLiveTrainees,FridayLivePhysician,FridayBasicPhysician01,FridayBasicPhysician02,SaturdayBasicPhysician,SaturdayExpert01Physician,SaturdayExpert02Physician) VALUES ('$year_event','$prenom','$nom','$specialite','$specialite_autre','$inamifinal','$foreign_number','$adresse','$rue','$numero','$codepostal','$ville','$pays','$telephone','$gsm_med','$type_inscription','$amount','$type_paiement','$moyen_paiement','$lang','$packageModuleA','$packageModule','$module1_2','$module3','$module4','$module5','$module6')";

if (!mysqli_query($conn, $queryadduser)) {
    ?>
    <html>
    <head>
        <!-- Basic -->
        <meta charset="utf-8">
    </head>
    <script>
        alert(
            <?php
            urlencode("Error: " . $queryadduser . "<br>" . mysqli_error($conn));
            ?>
        );
        document.location.href = "index.php";
    </script>
    </html>
    <?php
}

$emailConfig = [
    'host' => "mail.onychologycourse.a2hosted.com",
    'port' => 2525,
    'username' => "_mainaccount@onychologycourse.a2hosted.com",
    'password' => "HM_Onychology:2022$",
    'address' => "event@onychologycourse.eu",
    'from' => "Onychology",
    'encryption' => null,
    'debug' => 0,
];

$mail = new MailSender($emailConfig);
$toAddress = (string)$adresse;
$toName = $prenom . ' ' . $nom;
$subject = "Inscription au cours d'onychologie";

$adminTemplate = file_get_contents('admin-template.php');
$adminTemplatePath = str_replace('{{amount}}', $amount, $adminTemplate);
$adminTemplatePath = str_replace('{{prenom}}', $prenom, $adminTemplatePath);
$adminTemplatePath = str_replace('{{nom}}', $nom, $adminTemplatePath);
$adminTemplatePath = str_replace('{{specialite}}', $specialite, $adminTemplatePath);
$adminTemplatePath = str_replace('{{email}}', $Emailsub_med, $adminTemplatePath);
$adminTemplatePath = str_replace('{{pays}}', $pays, $adminTemplatePath);
$adminTemplatePath = str_replace('{{ville}}', $ville, $adminTemplatePath);
$adminTemplatePath = str_replace('{{gsm_med}}', $gsm_med, $adminTemplatePath);
$adminTemplatePath = str_replace('{{phone}}', $telephone, $adminTemplatePath);
$adminTemplatePath = str_replace('{{selectedModules}}', $selectedModules, $adminTemplatePath);


$customerTemplate = file_get_contents('customer-template.php');
$customerTemplatePath = str_replace('{{amount}}', $amount, $customerTemplate);
$customerTemplatePath = str_replace('{{prenom}}', $prenom, $customerTemplatePath);
$customerTemplatePath = str_replace('{{nom}}', $nom, $customerTemplatePath);


$mail->sendMail('event@onychologycourse.eu', 'Onychology', $subject, $adminTemplatePath);
$customerRes = $mail->sendMail($toAddress, $toName, $subject, $customerTemplatePath);

if ($customerRes) {
    ?>
    <html>
    <head>
        <!-- Basic -->
        <meta charset="utf-8">
    </head>
    <script>
        alert('Vous vous êtes inscrit avec succès!\nMerci pour votre inscription. Nous sommes impatients de vous rencontrer. Pour toute question, n’hésitez pas à envoyer un email à event@onychologycourse.eu');
        document.location.href = "index.php";
    </script>
    </html>
    <?php
} else {
    ?>
    <html>
    <head>
        <!-- Basic -->
        <meta charset="utf-8">
    </head>
    <script>
        alert('Erreur lors de l\'envoi de l\'e-mail.');
        document.location.href = "index.php";
    </script>
    </html>
    <?php
}
?>