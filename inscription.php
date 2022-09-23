<!DOCTYPE html>
<html>

<head>

    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Onychology Course</title>

    <meta name="keywords" content="HTML5 Template"/>
    <meta name="description" content="Porto - Responsive HTML5 Template">
    <meta name="author" content="okler.net">

    <!-- Favicon -->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon"/>
    <link rel="apple-touch-icon" href="img/apple-touch-icon.png">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

    <!-- Web Fonts  -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light"
          rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendor/animate/animate.min.css">
    <link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.min.css">
    <link rel="stylesheet" href="vendor/owl.carousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="vendor/owl.carousel/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="vendor/magnific-popup/magnific-popup.min.css">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="css/theme.css">
    <link rel="stylesheet" href="css/theme-elements.css">
    <link rel="stylesheet" href="css/theme-blog.css">
    <link rel="stylesheet" href="css/theme-shop.css">

    <!-- Current Page CSS -->
    <link rel="stylesheet" href="vendor/rs-plugin/css/settings.css">
    <link rel="stylesheet" href="vendor/rs-plugin/css/layers.css">
    <link rel="stylesheet" href="vendor/rs-plugin/css/navigation.css">

    <!-- Demo CSS -->
    <link rel="stylesheet" href="css/demos/demo-event.css">

    <!-- Skin CSS -->
    <link rel="stylesheet" href="css/skins/skin-event.css">

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="css/custom.css">

    <!-- Head Libs -->
    <script src="vendor/modernizr/modernizr.min.js"></script>

    <script src="vendor/jquery/jquery.min.js"></script>

    <script>
        function checkmeup() {
            alertMessage = "";

            if (document.formEmail.prenom.value == "") {
                alertMessage += "Veuillez entrer votre prénom\n";
            }

            if (document.formEmail.nom.value == "") {
                alertMessage += "Veuillez entrer votre nom\n";
            }

            if (document.formEmail.rue.value == "") {
                alertMessage += "Veuillez entrer votre rue\n";
            }
            if (document.formEmail.numero.value == "") {
                alertMessage += "Veuillez entrer votre numéro de rue\n";
            }
            if (document.formEmail.codepostal.value == "") {
                alertMessage += "Veuillez entrer votre code postal\n";
            }
            if (document.formEmail.ville.value == "") {
                alertMessage += "Veuillez entrer votre ville\n";
            }
            if (document.formEmail.pays.value == "") {
                alertMessage += "Veuillez entrer votre pays\n";
            }
            if (document.formEmail.gsm_med.value == "") {
                alertMessage += "Veuillez entrer votre numéro de gsm\n";
            }
            if (document.formEmail.module_total.value == 0) {
                alertMessage += "Au moins un module doit être sélectionné\n";
            }
            if (document.formEmail.Emailsub_med.value == "") {
                alertMessage += "Veuillez entrer votre adresse email\n";
            } else {
                re = /^[\w\.=-]+@[\w\.-]+\.[a-z]{2,4}$/i;
                if (!re.test(document.formEmail.Emailsub_med.value)) {
                    alertMessage += "L'email n'est pas valide\n";
                }
            }

            // var response = grecaptcha.getResponse();
            //
            // if (response.length == 0) {
            //     alertMessage += "Veuillez effectuer le Captcha.\n";
            // }


            if (alertMessage == "") {
                return true;
            } else {
                alert(alertMessage);
                return false;
            }
        }
    </script>

    <script type="text/javascript">
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-9031537-53', 'auto', {
            'allowLinker': true
        });
        ga('require', 'linker');
        ga('linker:autoLink', ['www.tempodigital.be', 'www.tempodigitaal.be', 'www.mpsservices.be', 'www.tempo30.be']);
        ga('send', 'pageview');
    </script>

    <style>
        #tabInsc p {
            font-size: 1.5em;
            line-height: 2.3em;
        }

        #tabInsc label {
            font-size: 1.5em;
            line-height: 2.3em;
        }
    </style>
</head>


<body data-target="#header" data-spy="scroll" data-offset="100">

<header id="header" class="header-transparent custom-header-transparent-style-1"
        data-plugin-options="{'stickyEnabled': true, 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': true, 'stickyStartAt': 1, 'stickySetTop': '0'}">

    <div style="background-color:#465560;" class="header-body">
        <div class="header-container container">
            <div class="header-row">
                <div class="header-column">
                    <div class="header-row">
                        <div class="header-logo">
                            <a href="demo-event.html">
                                <!-- <img alt="Porto" width="102" height="40" src="img/dme_logo.png"> -->
                            </a>
                        </div>
                    </div>
                </div>
                <div class="header-column justify-content-end">
                    <div class="header-row">
                        <div class="header-nav">
                            <div class="header-nav-main header-nav-main-effect-1 header-nav-main-sub-effect-1">
                                <nav class="collapse">
                                    <ul class="nav nav-pills custom-nav-pills mr-4" id="mainNav">
                                        <li>
                                            <a class="nav-link font-weight-bold" data-hash href="#bannerImage">
                                                Home
                                            </a>
                                        </li>
                                        <li>
                                            <a class="nav-link font-weight-bold" data-hash data-hash-offset="80"
                                               href="#schedule">
                                                Programme
                                            </a>
                                        </li>
                                        <li>
                                            <a class="nav-link font-weight-bold" data-hash data-hash-offset="80"
                                               href="#speakers">
                                                Orateurs
                                            </a>
                                        </li>
                                        <li>
                                            <a class="nav-link font-weight-bold" data-hash data-hash-offset="80"
                                               href="#about">
                                                Historique
                                            </a>
                                        </li>
                                        <li>
                                            <a class="nav-link font-weight-bold" data-hash data-hash-offset="80"
                                               href="#hotels">
                                                Hôtels
                                            </a>
                                        </li>

                                        <!-- <li>
                                            <a class="nav-link font-weight-bold" data-hash data-hash-offset="80" href="#sponsors">
                                                Sponsors
                                            </a>
                                        </li> -->
                                        <li>
                                            <a class="nav-link font-weight-bold" data-hash data-hash-offset="80"
                                               href="#venue">
                                                Accès
                                            </a>
                                        </li>
                                        <!-- <li id="btn_inscription">
                                            <a href="inscription.php"
                                                class="btn btn-primary custom-border-radius custom-btn-style-1 text-3 font-weight-bold text-color-light text-uppercase outline-none"
                                                href="">Inscription <i class="custom-long-arrow-right"
                                                    aria-hidden="true"></i></a>
                                        </li> -->

                                    </ul>
                                </nav>
                            </div>
                            <div class="buy-tickets">
                            </div>
                            <!-- <div>
                                <a style="background-color:#27333b;" href="../en/"
                                    class="btn btn-primary custom-border-radius   font-weight-bold text-color-light text-uppercase  ml-4"
                                    href="">EN</a>
                            </div> -->

                            <button class="btn header-btn-collapse-nav" data-toggle="collapse"
                                    data-target=".header-nav-main nav">
                                <i class="fa fa-bars"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<main role="main">

    <div id="bannerImage">
        <img src="img/event_banner_new.jpg" class="img-responsive" width="100%" height="auto" alt="banner"
             style="margin-top: -2px">
    </div>

    <form id="formEmailId" action="register.php" method="POST" name="formEmail" onsubmit="return checkmeup();">
        <input type="hidden" name="lang" id="lang" value="fr">

        <section id="tabInsc" class="mb-5 mt-5">
            <div class="container">

                <div class="row text-center border-bottom">
                    <div class="col-lg-12">
                        <h3 style="color:#2d3c46;">Vendredi 22 Avril</h3>
                    </div>
                </div>

                <div class="row border pt-3 pb-3 mb-3" style="background-color:#eff3f5;">
                    <div class="col-lg-3">
                        <p><b>MODULE 1</b></p>
                    </div>
                    <div class="col-lg-6 text-center" style="border-left:1px solid #cecece;">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input inuptInscription s1 price m1" id="inscrV1"
                                   name="module_1" value="60" data-price="60">
                            <label class="form-check-label" for="inscrV1"><b>60€</b></label>
                        </div>
                    </div>
                </div>

                <div class="row border pt-3 pb-3 mb-3" style="background-color:#eff3f5;">
                    <div class="col-lg-3">
                        <p><b>MODULE 2</b></p>
                    </div>
                    <div class="col-lg-6 text-center" style="border-left:1px solid #cecece;">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input inuptInscription s1 price m1" id="inscrV3"
                                   name="module_2" value="60" data-price="60">
                            <label class="form-check-label" for="inscrV3"><b>60€</b></label>
                        </div>
                    </div>
                </div>

                <div class="row border pt-3 pb-3 mb-3" style="background-color:#eff3f5;">
                    <div class="col-lg-3">
                        <p><b>MODULE 3</b></p>
                    </div>
                    <div class="col-lg-6 text-center" style="border-left:1px solid #cecece;">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input inuptInscription price m1" id="inscrV5"
                                   name="module_3" value="250" data-price="250">
                            <label class="form-check-label" for="inscrV5"><b>250€</b></label>
                        </div>
                    </div>
                </div>


                <div class="row text-center border-bottom mt-5">
                    <div class="col-lg-12">
                        <h3 style="color:#9e3965;">Samedi 23 Avril</h3>
                    </div>
                </div>

                <div class="row border pt-3 pb-3 mb-3" style="background-color:#eff3f5;">
                    <div class="col-lg-3">
                        <p><b>MODULE 4</b></p>
                    </div>
                    <div class="col-lg-6 text-center" style="border-left:1px solid #cecece;">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input inuptInscription price m1" id="inscrV7"
                                   name="module_4" value="80"
                                   data-price="80">
                            <label class="form-check-label" for="inscrV7"><b>80€</b></label>
                        </div>
                    </div>
                </div>

                <div class="row border pt-3 pb-3 mb-3" style="background-color:#eff3f5;">
                    <div class="col-lg-3">
                        <p><b>MODULE 5</b></p>
                    </div>
                    <div class="col-lg-6 text-center" style="border-left:1px solid #cecece;">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input inuptInscription price m1" id="inscrV9"
                                   name="module_5" value="80"
                                   data-price="80">
                            <label class="form-check-label" for="inscrV9"><b>80€</b></label>
                        </div>
                    </div>
                </div>
                <div class="row border pt-3 pb-3 mb-3" style="background-color:#eff3f5;">
                    <div class="col-lg-3">
                        <p><b>MODULE 6</b></p>
                    </div>
                    <div class="col-lg-6 text-center" style="border-left:1px solid #cecece;">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input inuptInscription price m1" id="inscrV11"
                                   name="module_6" value="80" data-price="80">
                            <label class="form-check-label" for="inscrV11"><b>80€</b></label>
                        </div>
                    </div>
                </div>

                <div class="row border pt-3 pb-3 mb-3" style="background-color:#eff3f5;">
                    <div class="col-lg-3">
                        <p><b>TOUS les MODULES</b></p>
                    </div>
                    <div class="col-lg-6 text-center" style="border-left:1px solid #cecece;">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input inuptInscription m1" id="inscrV12"
                                   name="package_module" value="500" data-price="500">
                            <label class="form-check-label" for="inscrV12"><b>500€</b></label>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="module_total" value=""/>

                <p style="line-height: 20px; color: black;">Total : <span class="totalprice"
                                                                          style="font-size: 22px!important; text-decoration: underline;">0</span><span
                            class="pl-2" style="font-size: 16px!important;">€</span>
                </p>

                <p style="line-height: 20px; color: black;">Inscription pour toute la session pour les dermatologues en
                    formation (internes) : <br/>
                    <span style="font-size: 12px!important;">(Sur présentation d’un document officiel attestant de la formation en cours.)</span>
                </p>


                <div class="row border pt-3 pb-3 mb-3" style="background-color:#eff3f5;">
                    <div class="col-lg-3">

                    </div>
                    <div class="col-lg-6 text-center" style="border-left:1px solid #cecece;">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input inuptInscription m1" id="inscrV13"
                                   name="package_module_a" value="150" data-price="150">
                            <label class="form-check-label" for="inscrV13"><b>150€</b></label>
                        </div>
                    </div>
                </div>

            </div>
        </section>


        <!-- form inscription -->


        <section id="intro" class="section-center pt-4 pb-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="row">


                                <div class="col-md-12">
                                    <label class="label_normal">Votre nom *</label>
                                    <input type="text" value="" maxlength="100" class="form-control" id="nom" name="nom"
                                           value="">
                                </div>
                                <div class="col-md-12" style="margin-top:5px;">
                                    <label class="label_normal">Votre prénom *</label>
                                    <input type="text" value="" maxlength="100" class="form-control" id="prenom"
                                           name="prenom" value="">
                                </div>

                                <div class="col-md-12" style="margin-top:5px;">
                                    <label class="label_normal">Spécialité</label>
                                    <br><select class="form-control" id="specialite" name="specialite">
                                        <option value="#" selected>Veuillez choisir votre spécialité</option>

                                        <option value="Acupuncture">Acupuncture</option>
                                        <option value="Allergology">Allergologie - immunologie</option>
                                        <option value="Pathology">Anatomo-pathologie</option>
                                        <option value="Anaesthesiology">Anesthésiologie</option>
                                        <option value="Angiology">Angiologie</option>
                                        <option value="Medical or Dental Assistant">Assistant</option>
                                        <option value="Biology">Biologie clinique</option>
                                        <option value="Cardiology">Cardiologie</option>
                                        <option value="Interventional Cardiology">Cardiologie Interventionnelle
                                        </option>
                                        <option value="Abdominal / Digestive Surgery">Chirurgie abdominale</option>
                                        <option value="Cardiovascular/Vascular Surgery">Chirurgie cardio-vasculaire
                                        </option>
                                        <option value="General Surgery">Chirurgie générale</option>
                                        <option value="Child Surgery">Chirurgie infantile</option>
                                        <option value="Oral & Maxillofacial Surgery">Chirurgie maxillo-faciale
                                        </option>
                                        <option value="Plastic Surgery">Chirurgie plastique</option>
                                        <option value="Cardiothoracic/ Thoracic Surgery">Chirurgie thoracique
                                        </option>
                                        <option value="Transplant Surgery">Chirurgien transplantation</option>
                                        <option value="Dentistry">Dentisterie</option>
                                        <option value="Dermatology">Dermatologie</option>
                                        <option value="Diabetology">Diabétologie</option>
                                        <option value="Electroencephalography">Electrophysiologie</option>
                                        <option value="Endocrinology">Endocrinologie</option>
                                        <option value="Student">Etudiant</option>
                                        <option value="Forensic Sciences">Expertise</option>
                                        <option value="Fertility">Fertilité</option>
                                        <option value="Gastroenterology">Gastro-entérologie</option>
                                        <option value="Geriatrics">Gériatrie</option>
                                        <option value="Gynaecology">Gynécologie</option>
                                        <option value="Haematology">Hématologie</option>
                                        <option value="Hepatology">Hépatologie</option>
                                        <option value="Homeopathy">Homéopathie</option>
                                        <option value="Hygiene">Hygiène</option>
                                        <option value="Infectious Diseases">Infectiologie</option>
                                        <option value="Physical Therapy">Kinésithérapie</option>
                                        <option value="Acute Medicine">Médecine aigüe</option>
                                        <option value="Occupational Health">Médecine du travail</option>
                                        <option value="General Medicine">Médecine générale</option>
                                        <option value="Intensive Care Medicine">Médecine intensive</option>
                                        <option value="Internal Medicine">Médecine interne</option>
                                        <option value="Nuclear Medicine">Médecine nucléaire</option>
                                        <option value="Sports Medicine">Médecine sportive</option>
                                        <option value="Tropical Medicine">Médecine tropicale</option>
                                        <option value="Mesotherapy">Mésothérapie</option>
                                        <option value="Nephrology">Néphrologie</option>
                                        <option value="Neurosurgery">Neurochirurgie</option>
                                        <option value="Neurology">Neurologie</option>
                                        <option value="Neuro Psychiatry">Neuropsychiatrie</option>
                                        <option value="Obstetrics Gynaecology">Obstétrique</option>
                                        <option value="Oncology">Oncologie</option>
                                        <option value="Ophthalmology">Ophtalmologie</option>
                                        <option value="Orthopaedic Surgery">Orthopédie</option>
                                        <option value="Ear-Nose-Throat Diseases">Oto-rhino-laryngologie</option>
                                        <option value="Paediatrics">Pédiatrie</option>
                                        <option value="Pharmacist">Pharmacien</option>
                                        <option value="Hospital Pharmacy">Pharmacien hospitalier</option>
                                        <option value="Physical Therapy">Physiothérapie</option>
                                        <option value="Pneumology">Pneumologie - phtisiologie</option>
                                        <option value="Neonatology">Néonatologie</option>
                                        <option value="Colorectal Surgery">Proctologie</option>
                                        <option value="Psychiatry">Psychiatrie</option>
                                        <option value="Radiology">Radiologie</option>
                                        <option value="Pharmacy Technician">Radiopharmacien</option>
                                        <option value="Radiotherapy">Radiothérapie</option>
                                        <option value="Rheumatology">Rhumatologie</option>
                                        <option value="Mastology">Sénologie</option>
                                        <option value="Stomatology">Stomatologie</option>
                                        <option value="Tobacco Unit">Tabacologie</option>
                                        <option value="Toxicology">Toxicologie</option>
                                        <option value="Pain Management">Traitement de la douleur</option>
                                        <option value="Traumatology">Traumatologie</option>
                                        <option value="Emergency & Accident">Urgences</option>
                                        <option value="Urology">Urologie</option>
                                        <option value="Veterinary">Vétérinaire</option>
                                    </select>
                                </div>

                                <div class="col-md-12" style="margin-top:5px;">
                                    <label class="label_normal">Spécialité (autre)</label>
                                    <input type="text" value="" maxlength="100" class="form-control"
                                           id="specialite_autre" name="specialite_autre" value="">
                                </div>

                                <div class="col-md-12" style="margin-top:5px;">
                                    <label class="label_normal">Numéro Inami *</label>
                                </div>
                            </div>


                            <div id="champInami" style="display:block;">


                                <div class="row">

                                    <div class="col-md-2 col-xs-2 col-sm-2">

                                        <input onkeypress="validate(event);" type="text" maxlength="1"
                                               class="form-control" id="INAMI" name="INAMI" value="">
                                    </div>

                                    <div class="col-md-5 col-xs-5 col-sm-5">

                                        <input onkeypress="validate(event);" type="text" maxlength="5"
                                               class="form-control" id="INAMI2" name="INAMI2" value="">
                                    </div>

                                    <div class="col-md-2 col-xs-2 col-sm-2">

                                        <input onkeypress="validate(event);" type="text" maxlength="2"
                                               class="form-control" id="INAMI3" name="INAMI3" value="">
                                    </div>

                                    <div class="col-md-3 col-xs-3 col-Sm-3">

                                        <input onkeypress="validate(event);" type="text" maxlength="3"
                                               class="form-control" id="INAMI4" name="INAMI4" value="">
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div id="champRPPS" style="display:block;">

                                    <div class="col-md-12" style="margin-top:5px;">
                                        <label class="label_normal">Autre numéro (Foreign participant)</label>
                                    </div>

                                    <div class="col-md-12">

                                        <input type="text" maxlength="20" class="form-control"
                                               id="foreign_number" name="foreign_number" value="">
                                    </div>


                                </div>


                                <div class="col-md-12" style="margin-top:5px;">
                                    <label class="label_normal">Rue *</label>
                                    <input type="text" maxlength="100" class="form-control" id="rue" name="rue"
                                           value="">
                                </div>
                                <div class="col-md-12" style="margin-top:5px;">
                                    <label class="label_normal">Numéro *</label>
                                    <input type="text" maxlength="100" class="form-control" id="numero"
                                           name="numero" value="">
                                </div>

                                <div class="col-md-12" style="margin-top:5px;">
                                    <label class="label_normal">Code postal *</label>
                                    <input type="text" maxlength="100" class="form-control" id="codepostal"
                                           name="codepostal" value="">
                                </div>


                                <div class="col-md-12" style="margin-top:5px;">
                                    <label class="label_normal">Ville *</label>
                                    <input type="text" maxlength="100" class="form-control" id="Ville"
                                           name="ville" value="">
                                </div>

                                <div class="col-md-12" style="margin-top:5px;">
                                    <label class="label_normal">Pays *</label>
                                    <input type="text" maxlength="100" class="form-control" id="Pays"
                                           name="pays" value="">
                                </div>

                                <div class="col-md-12" style="margin-top:5px;">
                                    <label class="label_normal">Fax </label>
                                    <input type="text" maxlength="100" class="form-control" id="fax" name="fax"
                                           value="">
                                </div>
                                <div class="col-md-12" style="margin-top:5px;">
                                    <label class="label_normal">Téléphone</label>
                                    <input type="text" maxlength="100" class="form-control" id="telephone"
                                           name="tel" value="">
                                </div>

                                <div class="col-md-12" style="margin-top:5px;">
                                    <label class="label_normal">GSM/Mobile *</label>
                                    <input type="text" maxlength="100" class="form-control" id="gsm_med"
                                           name="gsm_med" value="">
                                </div>

                                <div class="col-md-12" style="margin-top:5px;">
                                    <label class="label_normal">E-mail *</label>
                                    <input type="text" maxlength="100" class="form-control" id="Emailsub_med"
                                           name="Emailsub_med" value="">
                                </div>

                                <div class="col-md-12" style="margin-top:5px;">
                                    <br/><br/>
                                    <span style="color:#FF0000; font-weight: bold;">Valider le Captcha est
                                            obligatoire.<br><br>
                                        </span>
                                    <div class="g-recaptcha" data-sitekey="6LekbX0eAAAAAAW6LwquhV4XHjvTSIdVMxzvX0a3"
                                         name="captcha"></div>
                                    <br><br>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="row text-center pt-4 mt-4 pb-4 mb-4">
                    <div class="col-md-12">

                        <input type="submit" id="contactFormSubmit" value="Je valide mon inscription"
                               class="btn btn-primary custom-border-radius custom-btn-style-1 text-3 font-weight-bold text-color-light text-uppercase outline-none"
                               data-loading-text="Loading...">
                    </div>
                </div>


            </div>

        </section>


    </form>


    <section id="venue" class="pt-4">
        <div class="container pt-4 mt-4">
            <div class="row pt-2 mb-3">
                <div class="col">
                    <h2 class="text-color-dark text-uppercase font-weight-bold text-center mb-1">Accès</h2>

                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-10">
                    <div class="custom-venue-address background-color-light row">
                        <div class="col-md-6 d-none d-md-block p-0"
                             style="background-image: url('img/apercu_lieu.jpg'); background-size: cover;"></div>
                        <div class="col-md-6 p-5">
                            <div class="p-2">
                                <div class="text-color-dark font-weight-bold text-uppercase mb-3">CHU Saint Pierre -
                                    Auditoire Bastenie (Forum)
                                </div>
                                <p class="font-weight-normal mb-0"><strong>Adresse :</strong> Rue Haute 322, 1000
                                    Bruxelles</p>
                                <p class="font-weight-normal mb-4">
                                    <strong>Tél :</strong>
                                    <a href="tel:+123456789" class="custom-text-color-def">
                                        +32 (0)487 77 91 08
                                    </a>
                                </p>
                                <a href="http://maps.google.com" target="_blank"
                                   class="btn btn-primary custom-border-radius custom-btn-style-1 text-3 font-weight-semibold text-color-light text-uppercase outline-none">Itinéraire
                                    <i class="custom-long-arrow-right" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        <span class="custom-arrow background-color-light"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Google Maps - Go to the bottom of the page to change settings and map location. -->
    <!-- Google Maps - Go to the bottom of the page to change settings and map location. -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <iframe src="https://www.google.com/maps/embed?pb=!1m26!1m12!1m3!1d2519.7929136669136!2d4.339276966125694!3d50.83499962953026!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m11!3e2!4m5!1s0x47c3c4645398645b%3A0x7eb8382d8563115!2sCHU+Saint-Pierre+-+Site+Porte+de+Hal!3m2!1d50.834224!2d4.347246!4m3!3m2!1d50.836250299999996!2d4.3384424!5e0!3m2!1sfr!2sbe!4v1544188031894"
                        width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
        </div>
    </div>

</main>

<footer id="footer" class="background-color-quaternary m-0 pb-5">
    <div class="container pt-5 pb-5">
        <div class="row mb-5 pb-5">
            <div class="col-lg-6">
                <div class="mb-4">
                    <h4 class="text-color-light font-weight-light mb-2"><b>13<sup>ième</sup> édition de notre Cours
                            d’Onychologie</b><br/>22 et 23 Avril 2022</h4>
                    <p class="custom-font-size-3 text-color-light font-weight-normal text-uppercase mb-0">CHU SAINT
                        PIERRE - AUDITOIRE BASTENIE (FORUM)</p>
                </div>
                <a href="inscription.php"
                   class="btn btn-primary custom-border-radius custom-btn-style-1 text-3 font-weight-semibold text-color-light text-uppercase outline-none">Inscription
                    <i class="custom-long-arrow-right ml-3" aria-hidden="true"></i></a>
            </div>
            <div class="col-lg-6">
                <div class="contact-details">
                    <h4 class="text-color-light font-weight-light mb-4 pb-1">Contact</h4>
                    <div class="mb-3">
                        <strong class="font-weight-light text-color-light">Adresse :</strong>
                        <span class="font-weight-light">Rue Haute 322, 1000 Bruxelles</span>
                    </div>
                    <div class="mb-3">
                        <strong class="font-weight-light text-color-light">Tél. :</strong>
                        <a href="tel:1234567890" class="text-decoration-none font-weight-light">+32 499 39 55 80</a>
                    </div>
                    <div>
                        <strong class="font-weight-light text-color-light">Email :</strong><br/>
                        <a href="mailto:event@onychologycourse.eu" class="text-decoration-none font-weight-light">event@onychologycourse.eu</a>

                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col">
                <div class="footer-border text-center pt-5">
                    <p class="font-weight-normal mb-0">© Copyright 2017. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer>


<!-- Vendor -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/jquery.appear/jquery.appear.min.js"></script>
<script src="vendor/jquery.easing/jquery.easing.min.js"></script>
<script src="vendor/jquery-cookie/jquery-cookie.min.js"></script>
<script src="vendor/popper/umd/popper.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/common/common.min.js"></script>
<script src="vendor/jquery.validation/jquery.validation.min.js"></script>
<script src="vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.min.js"></script>
<script src="vendor/jquery.gmap/jquery.gmap.min.js"></script>
<script src="vendor/jquery.lazyload/jquery.lazyload.min.js"></script>
<script src="vendor/isotope/jquery.isotope.min.js"></script>
<script src="vendor/owl.carousel/owl.carousel.min.js"></script>
<script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="vendor/vide/vide.min.js"></script>

<!-- Theme Base, Components and Settings -->
<script src="js/theme.js"></script>

<!-- Current Page Vendor and Views -->
<script src="vendor/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
<script src="vendor/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>

<!-- Current Page Vendor and Views -->
<script src="js/views/view.contact.js"></script>

<!-- Demo -->
<script src="js/demos/demo-event.js"></script>

<!-- Theme Custom -->
<script src="js/custom.js"></script>

<!-- Theme Initialization Files -->
<script src="js/theme.init.js"></script>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAPKSWcVOrQv7YOe60BfLxTywJCJevGXRo"></script>
<script>
    $(function () {
        var $checkboxes = $('#devel-generate-content-form td input[type="checkbox"]');

        $checkboxes.change(function () {
            var countCheckedCheckboxes = $checkboxes.filter(':checked').length;
            $('#count-checked-checkboxes').text(countCheckedCheckboxes);

            $('#edit-count-checked-checkboxes').val(countCheckedCheckboxes);
        });

        $('.s1').change(function () {
            $('.s1').not(this).prop('checked', false);
        });

        $('#inscrV12,#inscrV13').change(function () {
            if ($(this).is(":checked")) {
                $(".m1").not(this).prop({'checked': false});
                $(".totalprice").html(parseInt($(this).attr("data-price")));
                $('input[name="module_total"]').val(parseInt($(this).attr("data-price")));
            } else {
                $(this).prop({'checked': false});
                $(".totalprice").html(0);
                $('input[name="module_total"]').val(0);
            }
        });

        $(".price").on("change", function () {
            if ($('#inscrV12,#inscrV13').is(":checked")) {
                $('#inscrV12,#inscrV13').prop({'checked': false});
            }
            var price = 0;
            $(".price").each(function () {
                if ($(this).is(":checked")) {
                    price = price + parseInt($(this).attr("data-price"));
                }
                $(".totalprice").html(price);
                $('input[name="module_total"]').val(price);
            });
        });
    });

    /*
        Map Settings

            Find the Latitude and Longitude of your address:
                - http://universimmedia.pagesperso-orange.fr/geo/loc.htm
                - http://www.findlatitudeandlongitude.com/find-address-from-latitude-and-longitude/

                */

    // Map Markers
    var mapMarkers = [{
        address: "Rue Haute 322, 1000 Bruxelles",
        icon: {
            image: "img/map-pin.png",
            iconsize: [36, 48],
            iconanchor: [36, 48]
        }
    }];

    // Map Initial Location
    var initLatitude = 50.8344886;
    var initLongitude = 4.3459418;

    // Map Extended Settings
    var mapSettings = {
        controls: {
            panControl: true,
            zoomControl: true,
            mapTypeControl: true,
            scaleControl: true,
            streetViewControl: true,
            overviewMapControl: true
        },
        scrollwheel: false,
        markers: mapMarkers,
        latitude: initLatitude,
        longitude: initLongitude,
        zoom: 14
    };

    var map = $('#googlemaps').gMap(mapSettings),
        mapRef = $('#googlemaps').data('gMap.reference');

    // Map text-center At
    var mapCenterAt = function (options, e) {
        e.preventDefault();
        $('#googlemaps').gMap("centerAt", options);
    }

    // Styles from https://snazzymaps.com/
    var styles = [{
        "featureType": "administrative.land_parcel",
        "elementType": "all",
        "stylers": [{
            "visibility": "off"
        }]
    }, {
        "featureType": "landscape.man_made",
        "elementType": "all",
        "stylers": [{
            "visibility": "off"
        }]
    }, {
        "featureType": "poi",
        "elementType": "labels",
        "stylers": [{
            "visibility": "off"
        }]
    }, {
        "featureType": "road",
        "elementType": "labels",
        "stylers": [{
            "visibility": "simplified"
        }, {
            "lightness": 20
        }]
    }, {
        "featureType": "road.highway",
        "elementType": "geometry",
        "stylers": [{
            "hue": "#f49935"
        }]
    }, {
        "featureType": "road.highway",
        "elementType": "labels",
        "stylers": [{
            "visibility": "simplified"
        }]
    }, {
        "featureType": "road.arterial",
        "elementType": "geometry",
        "stylers": [{
            "hue": "#fad959"
        }]
    }, {
        "featureType": "road.arterial",
        "elementType": "labels",
        "stylers": [{
            "visibility": "off"
        }]
    }, {
        "featureType": "road.local",
        "elementType": "geometry",
        "stylers": [{
            "visibility": "simplified"
        }]
    }, {
        "featureType": "road.local",
        "elementType": "labels",
        "stylers": [{
            "visibility": "simplified"
        }]
    }, {
        "featureType": "transit",
        "elementType": "all",
        "stylers": [{
            "visibility": "off"
        }]
    }, {
        "featureType": "water",
        "elementType": "all",
        "stylers": [{
            "hue": "#a1cdfc"
        }, {
            "saturation": 30
        }, {
            "lightness": 49
        }]
    }];

    var styledMap = new google.maps.StyledMapType(styles, {
        name: 'Styled Map'
    });

    mapRef.mapTypes.set('map_style', styledMap);
    mapRef.setMapTypeId('map_style');

    if ($('html[dir="rtl"]').get(0)) {
        mapRef.panBy(60, 50);
    } else {
        mapRef.panBy(-68, 50);
    }

</script>


<!-- <script src="js/inscription.js"></script> -->


<!-- Google Analytics: Change UA-XXXXX-X to be your site's ID. Go to http://www.google.com/analytics/ for more information.
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-12345678-1', 'auto');
        ga('send', 'pageview');
    </script>
-->


</body>

</html>