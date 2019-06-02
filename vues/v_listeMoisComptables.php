<?php

/**
 * Vue : Liste des mois pour les comptables
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    Pauline GAONAC'H <pauline.gaod@gmail.com>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */
?>

<div>
    <form action="index.php?uc=validerFiches&action=afficherFiche" method="post"
        role="form">
        <?php require 'v_listeMois.php';?>
        <input type="hidden" name="lstVisiteurs" value="<?php echo $idVisiteur ?>">
        <input id="ok" type="submit" value="Consulter" class="btn btn-success"
            role="button">
    </form>
</div>