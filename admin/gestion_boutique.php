<?php require('../inc/init.inc.php'); ?>
<?php if (!internauteEstConnecteEtEstAdmin()) {
    header("location: ../connexion.php");
    exit();
}
// Suppression de produit
if (isset($_GET['action']) && $_GET['action'] == "suppression") {
    // tratement
    $resultat = executeRequete("SELECT * FROM produit where id_produit=$_GET[id_produit]");
    $produit_a_supprimer = $resultat->fetch_assoc();
    $resultat_commande = executeRequete("SELECT COUNT(*) AS nb_commande FROM details_commande WHERE id_produit=$_GET[id_produit]");
    $donnees_commande = $resultat_commande->fetch_assoc();
    $nb_commandes = $donnees_commande['nb_commande'];
    if ($nb_commandes > 0) {
        $contenu .= '<div class="erreur">La suppression du produit : ' . $_GET['id_produit'] . ' est impossible => commande en cours ...</div>';
        $_GET['action'] = 'affichage';
    } else {
        $chemin_photo_a_supprimer = "../" . $produit_a_supprimer['photo'];
        if (isset($produit_a_supprimer['photo']) && file_exists($chemin_photo_a_supprimer))
            unlink($chemin_photo_a_supprimer);
        executeRequete("DELETE FROM produit WHERE id_produit=$_GET[id_produit]");
        $contenu .= '<div class="validation">Produit n° ' . $_GET['id_produit'] . ' supprimé!</div>';
        $_GET['action'] = 'affichage';
    }
}
// Création de produit
if (!empty($_POST)) {
    $photo_bdd = "";
    if (isset($_GET['action']) && $_GET['action'] == 'modification') {
        $photo_bdd = $_POST['photo_actuelle'];
    }
    if (!empty($_FILES['photo']['name'])) {
        $nom_photo = $_POST['reference'] . '_' . $_FILES['photo']['name'];
        $photo_bdd = "public/img/$nom_photo";
        $photo_dossier = "../public/img/$nom_photo";
        copy($_FILES['photo']['tmp_name'], $photo_dossier);
    }
    foreach ($_POST as $indice => $valeur) {
        $_POST[$indice] = htmlentities(addslashes($valeur));
    }
    $resultat_commande = executeRequete("SELECT COUNT(*) AS nb_commande FROM details_commande WHERE id_produit=$_POST[id_produit]");
    $donnees_commande = $resultat_commande->fetch_assoc();
    $nb_commandes = $donnees_commande['nb_commande'];
    if ($nb_commandes > 0) {
        $contenu .= '<div class="erreur">La suppression du produit : ' . $_GET['id_produit'] . ' est impossible => commande en cours ...</div>';
        $_GET['action'] = 'affichage';
    } else {
        executeRequete("REPLACE INTO produit (id_produit, reference, categorie, titre, description, couleur, taille,public, photo, prix, stock) VALUES('$_POST[id_produit]', '$_POST[reference]', '$_POST[categorie]','$_POST[titre]', '$_POST[description]', '$_POST[couleur]', '$_POST[taille]', '$_POST[public]', '$photo_bdd', '$_POST[prix]', '$_POST[stock]')");
        $contenu .= '<div class="validation">Le produit a bien été enregitré</div>';
        $_GET['action'] = 'affichage';
    }
}
// Liens Produits
$contenu .= '<a href="?action=affichage">Affichage des produits</a>';
$contenu .= '<a href="?action=ajout">Ajout d\'un produit</a>';
?>
<!-- Affichage des produits -->
<?php
if (isset($_GET['action']) && $_GET['action'] == "affichage") {
    $resultat = executeRequete("SELECT * FROM produit");
    $contenu .= '<h2>Affichage des produits</h2>';
    $contenu .= 'Nombre de produits disponibles : ' . $resultat->num_rows;
    $contenu .= '<table border="1"><tr>';
    while ($colonne = $resultat->fetch_field()) {
        $contenu .= '<th>' . $colonne->name . '</th>';
    }
    $contenu .= '<th>Modification</th>';
    $contenu .= '<th>Suppression</th>';
    $contenu .= '</tr>';
    while ($ligne = $resultat->fetch_assoc()) {
        $contenu .= '<tr>';
        foreach ($ligne as $indice => $informations) {
            if ($indice == "photo") {
                $contenu .= '<td><img src="' . RACINE_SITE . $informations . '" height="70"></td>';
            } else {
                $contenu .= '<td>' . $informations . '</td>';
            }
        }
        $contenu .= '<td><a href="?action=modification&id_produit=' . $ligne['id_produit'] . '"><img src="../inc/assets/icons/edit.png"></a></td>';
        $contenu .= '<td><a href="?action=suppression&id_produit=' . $ligne['id_produit'] . '" OnClick="return(confirm(\'En êtes vous certains\'));"><img src="../inc/assets/icons/delete.png"></a></td>';
        $contenu .= '</tr>';
    }
    $contenu .= '</table>';
}
?>
<?php require('../inc/haut.inc.php'); ?>
<?php echo $contenu; ?>
<?php
if (isset($_GET['action']) && ($_GET['action'] == "ajout" || $_GET['action'] == "modification")) {
    if (isset($_GET['id_produit'])) {
        $resultat = executeRequete("SELECT * FROM produit where id_produit=$_GET[id_produit]");
        $produit_actuel = $resultat->fetch_assoc();
    }
    echo '
<h1>Formulaire Produits</h1>
<form method="post" action="" enctype="multipart/form-data">
    <input type="hidden" name="id_produit" value="';
    if (isset($produit_actuel['id_produit'])) echo $produit_actuel['id_produit'];
    echo '">
    <label for="titre">Référence</label>
    <input type="text" id="reference" name="reference" placeholder="La référence du produit" 
    value="';
    if (isset($produit_actuel['reference'])) echo $produit_actuel['reference'];
    echo '
    ">
    <label for="categorie">Catégorie</label>
    <input type="text" id="categorie" name="categorie" placeholder="La catégorie du produit" 
    value="';
    if (isset($produit_actuel['categorie'])) echo $produit_actuel['categorie'];
    echo '
    ">
    <label for="titre">Titre</label>
    <input type="text" id="titre" name="titre" placeholder="Le titre du produit" 
    value="';
    if (isset($produit_actuel['titre'])) echo $produit_actuel['titre'];
    echo '
    ">
    <label for="description">Description</label>
    <textarea id="description" name="description">';
    if (isset($produit_actuel['description'])) echo $produit_actuel['description'];
    echo '
    </textarea>
    <label for="couleur">Couleur</label>
    <input type="text" id="couleur" name="couleur" placeholder="La couleur du produit" 
    value="';
    if (isset($produit_actuel['couleur'])) echo $produit_actuel['couleur'];
    echo '
    ">
    <label for="taille">Taille
        <select name="taille">
        ';
    $options = ["S", "M", "L", "XL"];
    foreach ($options as $taille) {
        echo '<option value="' . $taille . '"';
        if (isset($produit_actuel) && $produit_actuel['taille'] == $taille) {
            echo ' selected';
        }
        echo '>' . $taille . '</option>';
    }
    echo '
        </select>
    </label>
    <label for="public">public</label>
    <div><input type="radio" name="public" value="m"';
    if (isset($produit_actuel) && $produit_actuel['public'] == 'm') echo ' checked ';
    elseif (!isset($produit_actuel) && !isset($_POST['public'])) echo 'checked';
    echo '>Homme
        <input type="radio" name="public" value="f"';
    if (isset($produit_actuel) && $produit_actuel['public'] == 'f') echo ' checked ';
    echo '>Femme</div>
    <label for="photo">Photo</label>
    <input type="file" id="photo" name="photo" onchange="previewImage()">';
    if (isset($produit_actuel)) {
        echo '<i>Vous pouvez uploader une nouvelle photo si vous souhaitez la changer</i>';
        echo '<img id="preview" src="' . RACINE_SITE . $produit_actuel['photo'] . '" width="70">';
        echo '<input type="hidden" name="photo_actuelle" value="' . $produit_actuel['photo'] . '">';
    }
    echo '
    <label for="prix">prix</label>
    <input type="text" id="prix" name="prix" placeholder="le prix du produit"  value="';
    if (isset($produit_actuel['prix'])) echo $produit_actuel['prix'];
    echo '">
    <label for="stock">stock</label>
    <input type="text" id="stock" name="stock" placeholder="le stock du produit"  value="';
    if (isset($produit_actuel['stock'])) echo $produit_actuel['stock'];
    echo '">
    
    <button>' . ucfirst($_GET['action']) . ' du produit</button>
</form>';
}
?>


<?php require('../inc/bas.inc.php'); ?>