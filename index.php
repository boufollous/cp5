<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>

<body class="container">
    <?php
    // Calcule l'écart en jours entre le 4 janvier 2021 et aujourd'hui
    $start = '2021-01-04';
    $date1 = strtotime('now');
    $date2 = strtotime($start);
    $gap = floor(($date1 - $date2) / 60 / 60 / 24);
    ?>

    <div class="jumbotron mt-3">
        <h1 class="display-4">Espace abonnés</h1>
        <p class="lead">Cet espace est réservé aux abonné.e.s du CDA de Compiègne. Il est en place depuis <?php echo $gap; ?> jours. Il compte aujourd'hui xxx abonné.e.s.</p>
        <hr class="my-3">
        <p>Cliquer sur le bouton ci-dessous pour vous identifier :</p>
        <button class="btn btn-warning" id="btnRegister" data-toggle="modal" data-target="#register">S'inscrire</button>
        <button class="btn btn-success" id="btnLogin" data-toggle="modal" data-target="#login">Se connecter</button>
        <a href="ajax.php" class="btn btn-primary">Pays par langue</a>
        <a href="tests" class="btn btn-secondary">Tests</a>
    </div>

    <?php
    // Affiche un message si compte créé avec succès
    if (isset($_GET['m']) && !empty($_GET['m'])) {
        if ($_GET['m'] === 'ccok') {
            $html = '<div class="alert alert-success alert-dismissible fade show my-3" role="alert">
                    <strong>Félicitations !</strong> Votre compte a été créé avec succès.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>';
        } else if ($_GET['m'] === 'cnnok') {
            $html = '<div class="alert alert-primary alert-dismissible fade show my-3" role="alert">
                    <strong>Félicitations !</strong> Vous venez de vous connecter avec succès.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>';
        }

        echo $html;
    }
    ?>

    <section id="team" class="d-flex flex-wrap">
        <div class="card m-3" style="width:15rem">
            <img src="pics/boys.jpg" alt="" class="card-img-top">
            <div class="card-body">
                <h5 class="card-title">Lak</h5>
                <p><strong>Age : </strong>55 ans</p>
                <p><strong>Taille : </strong>1.70m</p>
            </div>
        </div>
        <?php
        // Imports
        include_once('inc/team.inc.php');
        include_once('inc/functions.inc.php');

        // Parcourt le tableau TEAM
        $pattern =
            '<div class="card m-3" style="width:15rem">
            <img src="pics/%s.jpg" alt="" class="card-img-top">
            <div class="card-body">
            <h5 class="card-title">%s</h5>
            <p><strong>Age : </strong>%d ans</p>
            <p><strong>Taille : </strong>%gm</p>
            </div>
            </div>';
        $html = '';
        foreach ($team as $member) {
            $html .= sprintf($pattern, ($member['female'] ? 'girls' : 'boys'), $member['fname'], age($member['dob'], date('Y-m-d')), $member['size']);
        }
        echo $html;
        ?>
    </section>

    <!-- MODAL CONNEXION -->
    <div class="modal fade" id="login" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Connexion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="login.php" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="mail">Identifiant</label>
                            <input type="email" class="form-control" id="mail" name="mail" required>
                        </div>
                        <div class="form-group">
                            <label for="pass">Mot de passe</label>
                            <input type="password" class="form-control" id="pass" name="pass" pattern="[A-Za-z0-9_$]{8,}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <input type="submit" value="Se connecter" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL INSCRIPTION -->
    <div class="modal fade" id="register" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Inscription</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="register.php" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="pseudo">Pseudo</label>
                            <input type="text" id="pseudo" name="pseudo" pattern="[A-Za-z0-9\u00c0-\u00ff]{5,20}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="mail">Courriel</label>
                            <input type="email" class="form-control" id="mail" name="mail" required>
                        </div>
                        <div class="form-group">
                            <label for="pass1">Mot de passe</label>
                            <input type="password" class="form-control" id="pass1" name="pass" pattern="[A-Za-z0-9_$]{8,}" required>
                        </div>
                        <div class="form-group">
                            <label for="pass2">Vérification</label>
                            <input type="password" class="form-control" id="pass2" pattern="[A-Za-z0-9_$]{8,}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <input type="submit" value="S'inscrire" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="js/index.js"></script>
</body>

</html>