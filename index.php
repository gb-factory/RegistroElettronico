<?php

session_start();

if (isset($_SESSION['login'])) {
    header('Location: home.php');
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" media="screen,projection" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <title>Registro Elettronico</title>
    <link rel="shortcut icon" href="https://i.imgur.com/ZK42PKi.png" />
</head>

<body>

    <nav>
        <div class="nav-wrapper container">
            <ul class="right hide-on-med-and-down">
                <li><a href="info.html"><i class="material-icons">info_outline</i></a></li>
                <li><a href="https://github.com/gb-factory/RegistroElettronico"><i class="material-icons">code</i></a></li>
                <li><a href="index.php" class="waves-effect waves-light btn"><i class="material-icons right">person</i> Entra</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="row">

            <form class="col m6 offset-m3" action="" method="POST">

                <div class="row center" style="margin-top: 30px;">
                    <!-- <img src="https://i.imgur.com/MUWOssA.png" alt="" class="responsive-img"> -->
                    <img src="https://i.imgur.com/EvyXfgN.png" alt="" class="responsive-img" style="max-height: 200px">
                    <h4>Registro Elettronico</h4>
                    <p>Collegati ad Argo ScuolaNext con le tue credenziali</p>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">school</i>
                        <input id="last_name" type="text" class="validate" name="codice">
                        <label for="last_name">Codice Scuola</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">account_circle</i>
                        <input id="last_name" type="text" class="validate" name="utente">
                        <label for="last_name">Utente</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">vpn_key</i>
                        <input id="password" type="password" class="validate" name="password">
                        <label for="password">Password</label>
                    </div>
                </div>

                <div class="row center">
                    <button class="btn waves-effect waves-light btn-large" type="submit" name="submit">Entra
                        <i class="material-icons right">send</i>
                    </button>
                </div>

                <?php

                if (isset($_POST['submit'])) {

                    require_once('./components/argoapi.php');

                    $error = '';

                    try {
                        $argo = new argoUser($_POST['codice'], $_POST['utente'], $_POST['password'], 0);

                        $_SESSION['login'] = true;
                        $_SESSION['codice'] = $_POST['codice'];
                        $_SESSION['utente'] = $_POST['utente'];
                        $_SESSION['authToken'] = $argo->schede()[0]['authToken'];

                        header('Location: index.php');
                    } catch (Exception $e) {
                        echo '<div class="card-panel red">Errore di connessione alle API di Argo ' . $e->getMessage() . '</div>';
                    }
                } ?>

                <!-- <p>Questo non è il registro Argo ufficiale, per utilizzare il registro Argo ScuolaNext ufficiale recarsi a <a href="https://www.portaleargo.it/argoweb/famiglia/common/login_form2.jsp">questo link</a></p> -->

            </form>

        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>

</html>
