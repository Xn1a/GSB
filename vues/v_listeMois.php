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
<div class="form-group">
    <label for="lstMois" accesskey="n">Mois : </label>
    <select id="lstMois" name="lstMois" class="form-control">
    <?php 
    if(count($lesMois) == 0) { ?>
        <option selected>Pas de fiche de frais pour ce visiteur ce mois</option>
    <?php }
    foreach ($lesMois as $unMois) {
        $mois = $unMois['mois'];
        $numAnnee = $unMois['numAnnee'];
        $numMois = $unMois['numMois'];
        if ($mois == $moisASelectionner) {
            ?>
            <option selected value="<?php echo $mois ?>">
            <?php echo $numMois . '/' . $numAnnee ?> </option>
            <?php
        } 
        else { ?>
            <option value="<?php echo $mois ?>">
            <?php echo $numMois . '/' . $numAnnee ?> 
            </option>
            <?php }
        } ?>    
    </select>
</div>