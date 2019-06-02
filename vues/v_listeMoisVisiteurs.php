<?php
/**
 * Vue : Liste des mois (pour les visiteurs)
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */
?>

<h2>Mes fiches de frais</h2>
<div class="row">
    <div class="col-md-4">
        <h3>Sélectionner un mois : </h3>
    </div>
    <div class="col-md-4">
        <form action="index.php?uc=etatFrais&action=voirEtatFrais" method="post"
            role="form">
            <?php require 'v_listeMois.php'; ?>
            <input id="ok" type="submit" value="Valider" class="btn btn-success"
                role="button">
            <input id="annuler" type="reset" value="Effacer" class="btn btn-danger"
                role="button">
        </form>
    </div>
</div>
</div>