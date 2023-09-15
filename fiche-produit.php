<?php require('./inc/init.inc.php');
$title = " | Fiche produit";

if (isset($_GET['id_produit'])) {
    $resultat = executeRequete("SELECT * FROM produit WHERE id_produit='$_GET[id_produit]'");
}
if ($resultat->num_rows <= 0) {
    header('location: boutique.php');
    exit();
}

$produit = $resultat->fetch_assoc();
$contenu .= "<h2>Titre : $produit[titre]</h2><hr><br>";
$contenu .= "<p>Categorie: $produit[categorie]</p>";
$contenu .= "<p>Couleur: $produit[couleur]</p>";
$contenu .= "<p>Taille: $produit[taille]</p>";
$contenu .= "<img src='$produit[photo]' ='150' height='150'>";
$contenu .= "<p><i>Description: $produit[description]</i></p><br>";
$contenu .= "<p>Prix : $produit[prix] €</p><br>";
if ($produit['stock'] > 0) {
    $contenu .= "<i>Nombre de produit(s) disponible(s) : $produit[stock].</i>";
    $contenu .= '<form method="post" action="panier.php">';
    $contenu .= "<input type='hidden' name='id_produit' value='$produit[id_produit]'>";
    $contenu .= '<div><label for="quantite">Quantité : </label>';
    $contenu .= '<select id="quantite" name="quantite">';
    for ($i = 1; $i <= $produit['stock'] && $i <= 5; $i++) {
        $contenu .= "<option>$i</option>";
    }
    $contenu .= '</select></div> ';
    $contenu .= '<input type="submit" name="ajout_panier" value="ajout au panier">';
    $contenu .= '</form>';
} else {
    $contenu .= 'Rupture de stock !';
}
$contenu .= "<a href='boutique.php?categorie" . $produit['categorie'] . "'>Retour vers la selection de " . $produit["categorie"] . "</a>";

?>
<?php require('./inc/haut.inc.php'); ?>
<?php echo $contenu ?>
<?php require('./inc/bas.inc.php'); ?>