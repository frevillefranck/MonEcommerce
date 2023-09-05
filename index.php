<?php
require('./inc/init.inc.php');
// Notre accueil  
require('./inc/haut.inc.php');
?>
<h2>Notre page d'accueil</h2>
<p>Coincée entre le haut et le bas !</p>
<?php
require('./inc/bas.inc.php');
// var_dump(RACINE_SITE);
echo '<br>';
// echo session_status();
// Notre accueil
echo '<h2>Notre futur page d\'accueil pour notre boutique</h2>';
?>
<img src="<?php echo RACINE_SITE; ?>inc/img/noir.jpg" alt="test image">