<?php
/**
 * Vue Infos sur la fiche : montant validé, nom et prénom du visiteur, mois et état
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

<div class="panel panel-primary">
    <div class="panel-heading">Fiche de frais du mois 
        <?php echo $numMois . '-' . $numAnnee ?> du visiteur <?php echo $nomPrenom ?> : </div>
    <div class="panel-body">
        <strong><u>Etat :</u></strong> <?php echo $libEtat ?>
        depuis le <?php echo $dateModif ?> <br> 

        <?php 
        if (isset($montantValide)) { ?>
            <strong><u>Montant validé :</u></strong> <?php echo $montantValide ?>
        <?php 
        } 
        ?>
    </div>
</div>