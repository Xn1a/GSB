<?php
/**
 * Vue Liste des fiches : mois, année, nom, prenom
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    Pauline Gaonac'h <pauline.gaod@gmail.com>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */
?>
<div class="form-group">
    <form action="index.php?uc=suivreFiches&action=consulterFiche" method="post"
        role="form">
        <label for="lstFiches" accesskey="n">Fiches validées : </label>
        <select id="lstFiches" name="lstFiches" class="form-control">
            <?php 
            if(count($lesFiches) == 0) { ?>
                <option selected>Pas de fiches validées disponibles actuellement</option>
            <?php 
            }
            foreach ($lesFiches as $uneFiche) {
                $mois = $uneFiche['mois'];
                $numAnnee = $uneFiche['numAnnee'];
                $numMois = $uneFiche['numMois'];
                $idVisiteur = $uneFiche['idVisiteur'];
                $prenom = $uneFiche['prenom'];
                $nom = $uneFiche['nom'];

                if (($idVisiteur == $idVisiteurSel) && (($mois == $moisSel)) { ?>
                    <option selected value="<?php echo $idVisiteur.'-'.$mois  ?>">
                        <?php echo $numMois . '/' . $numAnnee . ' ' . $prenom . ' ' . $nom ?>
                    </option>
            <?php
                } else {
            ?>
                <option value="<?php echo $idVisiteur.'-'.$mois ?>">
                    <?php echo $numMois . '/' . $numAnnee . ' ' . $prenom . ' ' . $nom ?>
                </option>
            <?php
                }
            }   
            ?>
        </select>
        <button class="btn btn-info" type="submit">Consulter</button>
    </form>
</div>