<?php
/**
 * Vue Liste des frais au forfait
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
<div class="row">
    <h2>
        <?php echo $titre; ?>
    </h2>
    <h3>Eléments forfaitisés</h3>
    <div class="col-md-4">
        <form method="post" action="<?php echo $actionFormulaire ?>" role="form">
            <fieldset>
                <?php
                foreach ($lesFraisForfait as $unFrais) {
                    $idFrais = $unFrais['idfrais'];
                    $libelle = htmlspecialchars($unFrais['libelle'], ENT_QUOTES);
                    $quantite = $unFrais['quantite']; 
                ?>
                <div class="form-group">
                    <label for="idFrais"><?php echo $libelle ?></label>
                    <input type="text" id="idFrais"
                        name="lesFrais[<?php echo $idFrais ?>]" size="10"
                        maxlength="5" value="<?php echo $quantite ?>"
                        class="form-control">
                </div>
                <?php
                } 
                ?>
                <input type="hidden" name="lstMois" value="<?php echo $leMois ?>">
                <input type="hidden" name="lstVisiteurs"
                    value="<?php echo $idVisiteur ?>">
                <button class="btn btn-success"
                    type="submit"><?php echo $texteSubmit ?></button>
                <button class="btn btn-danger"
                    type="reset"><?php echo $texteReset ?></button>
            </fieldset>
        </form>
    </div>
</div>