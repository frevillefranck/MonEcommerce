<!Doctype html>
<html>

<head>
    <title>Mon E-commerce<?php echo htmlspecialchars($title); ?></title>
    <link rel="stylesheet" href="<?php echo RACINE_SITE ?>public/css/styles.css">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="<?php echo RACINE_SITE ?>inc/js/main.js" defer></script>
</head>

<body>
    <header>
        <nav class="topnav" id="myTopnav">
            <?php
            if (internauteEstConnecteEtEstAdmin()) {
                echo '<a href="' . RACINE_SITE . 'admin/gestion_membre.php">Gestion des membres</a>';
                echo '<a href="' . RACINE_SITE . 'admin/gestion_commande.php">Gestion des commandes</a>';
                echo '<a href="' . RACINE_SITE . 'admin/gestion_boutique.php">Gestion de la boutique</a>';
            }
            if (internauteEstConnecte()) {
                echo '<a href="' . RACINE_SITE . 'profil.php">Voir votre profil</a>';
                echo '<a href="' . RACINE_SITE . 'boutique.php">Accès à la boutique</a>';
                echo '<a href="' . RACINE_SITE . 'panier.php">Voir votre panier</a>';
                echo '<a href="' . RACINE_SITE . 'connexion.php?action=deconnexion">Se déconnecter</a>';
            } else {
                echo '<a href="' . RACINE_SITE . 'inscription.php">Inscription</a>';
                echo '<a href="' . RACINE_SITE . 'connexion.php">Connexion</a>';
                echo '<a href="' . RACINE_SITE . 'boutique.php">Accès à la boutique</a>';
                echo '<a href="' . RACINE_SITE . 'panier.php">Voir votre panier</a>';
            }

            ?>
            <a href="javascript:void(0);" class="icon" onclick="toggleNav()">
                <i class="fa fa-bars"></i>
            </a>
        </nav>

    </header>
    <section>
        <div class="conteneur">