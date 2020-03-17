<?php

session_start();

if (isset($_SESSION['login'])) {
} else {
    header('Location: index.php');
}

require_once('./components/argoapi.php');

$codice = $_SESSION['codice'];
$utente = $_SESSION['utente'];
$token = $_SESSION['authToken'];

try {
    $argo = new argoUser($codice, $utente, $token, 1);
} catch (Exception $e) {
    echo 'Errore di connessione ad ArgoAPI: ', $e->getMessage(), "\n";
    //header('Location: index.php');
}

$headerArgo = $argo->schede();

?>

<html>

<head>
    <meta charset="utf-8">
    <title>Registro Elettronico</title>
    <meta name="description" content="Interfaccia registro elettronico Argo ScuolaNext">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</head>

<body>

    <style>
        header,
        main,
        footer {
            padding-left: 300px;
        }

        @media only screen and (max-width : 992px) {

            header,
            main,
            footer {
                padding-left: 0;
            }
        }
    </style>

    <nav>
        <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <div class="nav-wrapper container">
            <ul class="right hide-on-med-and-down">
                <li><a href="#"><i class="material-icons">info_outline</i></a></li>
                <li><a href="#"><i class="material-icons">code</i></a></li>
                <li><a href="logout.php" class="waves-effect waves-light btn"><i class="material-icons right">person</i> Esci</a></li>
            </ul>
        </div>
    </nav>

    <ul id="slide-out" class="sidenav sidenav-fixed">
        <li>
            <div class="user-view">
                <div class="background"><img src="https://cdn.portaleargo.it/wsx/images/sfondoindex.jpg"></div>
                <a href="datiAnagrafici.php"><span class="white-text name"><?= $headerArgo[0]['alunno']['desCognome'] ?> <?= $headerArgo[0]['alunno']['desNome'] ?></span></a>
                <a href="datiAnagrafici.php"><span class="white-text email"><?= $headerArgo[0]['desDenominazione'] ?><?= $headerArgo[0]['desCorso'] ?> <?= $headerArgo[0]['desSede'] ?></span></a>
            </div>
        </li>
        <li><a class="waves-effect" href="home.php">Riepilogo</a></li>
        <li>
            <div class="divider"></div>
        </li> 
        <li><a class="subheader">Alunno</a></li>
        <li><a class="waves-effect" href="datiAnagrafici.php">Dati Anagrafici</a></li>
        <li><a class="waves-effect" href="votiRegistro.php">Valutazioni</a></li>
        <li><a class="waves-effect" href="assenze.php">Assenze</a></li>
        <li><a class="waves-effect" href="noteDisciplinari.php">Note Disciplinari</a></li>
        <li>
            <div class="divider"></div>
        </li>
        <li><a class="subheader">Classe</a></li>
        <li><a class="waves-effect" href="compitiAssegnati.php">Compiti Assegnati</a></li>
        <li><a class="waves-effect" href="argomentiLezione.php">Argomenti Lezione</a></li>
        <li><a class="waves-effect" href="promemoria.php">Promemoria</a></li>
        <li><a class="waves-effect" href="orarioScolastico.php">Orario Scolastico</a></li>
        <li><a class="waves-effect" href="docentiClasse.php">Docenti Classe</a></li>
        <li>
            <div class="divider"></div>
        </li>
        <li><a class="subheader">Documenti</a></li>
        <li><a class="waves-effect" href="bacheca.php">Bacheca</a></li>
        <li>
            <div class="divider"></div>
        </li>
        <li><a class="subheader">IIS Euganeo</a></li>
        <li><a class="waves-effect" href="news.php">News</a></li>
        <li><a class="waves-effect" href="circolari.php">Circolari</a></li>


    </ul>