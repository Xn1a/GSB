<?php
/**
 * Vue Liste des frais hors forfait
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
<hr>
<div class="row">
    <div class="panel panel-info">
        <div class="panel-heading">Descriptif des éléments hors forfait</div>
        <table class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th class="date">Date</th>
                    <th class="libelle">Libellé</th>  
                    <th class="montant">Montant</th>  
                    <th class="action">&nbsp;</th> 
                </tr>
            </thead>  
            <tbody>
            <?php
            foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
                $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
                $date = $unFraisHorsForfait['date'];
                $montant = $unFraisHorsForfait['montant'];
                $id = $unFraisHorsForfait['id']; ?>           
                <tr>
                    <form method="post" 
                    action="index.php?uc=validerFiches&action=corrigerFraisHorsForfait" 
                    role="form">
                        <td><input class="form-control" type="text" name="fraisHorsForfait[date]" value="<?php echo $date ?>"></td>
                        <td><input class="form-control" type="text" name="fraisHorsForfait[libelle]" value="<?php echo $libelle ?>"></td>
                        <td><input class="form-control" type="text" name="fraisHorsForfait[montant]" value="<?php echo $montant ?>"></td>
                        <td>
                            <button class="btn btn-success" type="submit">Corriger</button>
                            <button class="btn btn-danger" type="reset">Réinitialiser</button>
                        </td>
                        <input type="hidden" name="fraisHorsForfait[id]" value="<?php echo $id; ?>">
                        <input type="hidden" name="lstVisiteurs" value="<?php echo $idVisiteur; ?>">
                        <input type="hidden" name="lstMois" value="<?php echo $fiche; ?>">
                    </form>
                </tr>
                <?php
            }
            ?>
            </tbody>  
        </table>
    </div>
    <b>Nombre de justificatifs : </b>
    <input type="text" name="" id="" value="<?php echo $nombreJustificatifs; ?>">
    <button class="btn btn-success" type="submit">Valider</button>
    <button class="btn btn-danger" type="reset">Réinitialiser</button>
</div>