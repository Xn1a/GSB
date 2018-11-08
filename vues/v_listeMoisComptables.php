<?php

/**
 * Vue Liste des mois
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

<div class="col-md-4">
    <form action="index.php?uc=validerFiches&action=corrigerFrais"
        method="post" role="form">
        <?php require 'v_listeMois.php';?>
        <input type="hidden" name="idVisiteur" value="<?php echo $idVisiteur ?>">
        <input id="ok" type="submit" value="Consulter" class="btn btn-success"
            role="button">
    </form>
</div>


