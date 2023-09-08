<?php require('./inc/init.inc.php'); ?>
<?php
if ($_POST) {
    // debug($_POST);
    $verif_caractere = preg_match('#^[a-zA-Z0-9._-]+$#', $_POST['pseudo']);
    if (!$verif_caractere || strlen($_POST['pseudo']) < 1 || strlen($_POST['pseudo']) > 20) {
        $contenu .= "<div class='erreur'>Le pseudo n'est pas valide. <br> Caractères acceptés : lettre de a à z et chiffres de 1 à 9.</div>";
    } else {
        $utilisateur = executeRequete("SELECT * FROM utilisateur WHERE pseudo ='$_POST[pseudo]'");
        if ($utilisateur->num_rows > 0) {
            $contenu .= "<div class='erreur'>Pseudo indisponible. Veuillez en choisir un autre svp.</div>";
        } else {
            // $_POST['mdp'] = md5($_POST['mdp']);
            $_POST['mdp'] = password_hash($_POST['mdp'], PASSWORD_BCRYPT);
            foreach ($_POST as $indice => $valeur) {
                $_POST[$indice] = htmlentities(addslashes($valeur));
            }
            executeRequete("INSERT INTO utilisateur (pseudo, mot_de_passe, nom, prenom, email, civilite, ville, code_postal, adresse) VALUES ('$_POST[pseudo]', '$_POST[mdp]', '$_POST[nom]', '$_POST[prenom]', '$_POST[email]', '$_POST[civilite]', '$_POST[ville]', '$_POST[code_postal]', '$_POST[adresse]')");
            $contenu .= "<div class='validation'>Vous êtes inscrit à notre site web. <a href=\"connexion.php\"><u>Cliquez ici pour vous connecter</u></a></div>";
        }
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

    <label for="nom">Nom</label>
    <input type="text" id="nom" name="nom" placeholder="Votre nom"><br>

    <label for="prenom">Prénom</label>
    <input type="text" id="prenom" name="prenom" placeholder="Votre prénom"><br>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" placeholder="Exemple@gmail.com"><br>

    <label for="civilite">Civilité</label>
    <div class="civilite">
        <input name="civilite" value="m" checked="" type="radio">Homme
        <input name="civilite" value="f" type="radio">Femme
    </div><br>

    <label for="ville">Ville</label>
    <input type="text" id="ville" name="ville" placeholder="Votre ville" pattern="[a-zA-Z0-9-_.]{5,15}" title="caractères acceptés : a-zA-Z0-9-_."><br>

    <label for="cp">Code Postal</label>
    <input type="text" id="code_postal" name="code_postal" placeholder="Code postal" pattern="[0-9]{5}" title="5 chiffres requis : 0-9"><br>

    <label for="adresse">Adresse</label>
    <textarea id="adresse" name="adresse" placeholder="Votre adresse" pattern="[a-zA-Z0-9-_.]{5,15}" title="caractères acceptés :  a-zA-Z0-9-_."></textarea><br>

    <!-- <input type="submit" name="inscription" value="S'inscrire"> -->
    <button class="inscription">S'incrire</button>
</form>
<?php require('./inc/bas.inc.php'); ?>