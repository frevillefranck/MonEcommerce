<?php require('./inc/init.inc.php'); ?>
<?php
$title = " | Connexion";

// <!-- Traitement -->
if (isset($_GET['action']) && $_GET['action'] == "deconnexion") {
    session_destroy();
}
if (internauteEstConnecte()) {
    header("location: profil.php");
}
if ($_POST) {
    $resultat = executeRequete("SELECT * FROM utilisateur WHERE pseudo='$_POST[pseudo]'");
    if ($resultat->num_rows != 0) {
        $membre = $resultat->fetch_assoc();


        if (password_verify($_POST['mdp'], $membre['mot_de_passe'])) {
            $contenu .= '<div class="validation">Mot de passe correct</div>';
            foreach ($membre as $indice => $element) {
                if ($indice != 'mot_de_passe') {
                    $_SESSION['membre'][$indice] = $element;
                }
            }
            header("location: profil.php");
        } else {
            $contenu .= '<div class="erreur">Mot de passe invalide</div>';
        }
    } else {
        $contenu .= '<div class="erreur">Erreur de pseudo</div>';
    }
}
?>
<?php require('./inc/haut.inc.php'); ?>
<?php echo $contenu ?>
<form method="post" action="">
    <label for="pseudo">Pseudo</label>
    <input type="text" name="pseudo" id="pseudo" placeholder="Votre pseudo" title="Caractères acceptés : lettre de a à z et chiffres de 1 à 9." required><br>

    <label for="mdp">Mot de passe</label>
    <input type="password" name="mdp" id="mdp" placeholder="Votre mot de passe" required><br>

    <button class="connexion">Se connecter</button>
</form>




<?php require('./inc/bas.inc.php'); ?>