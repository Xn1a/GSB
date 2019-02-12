<?php
/**
 * Vue Liste des frais hors forfait editables 
 * pour permettre au comptables de corriger les frais
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    Pauline Gaonac'h <xn1a@protonmail.com>
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
                $id = $unFraisHorsForfait['id'];
                $estRefuse = $unFraisHorsForfait['estRefuse'];
                ?>
                <tr 
                <?php if (stripos($libelle, 'REFUSE :') !== false) {
                    echo "style='background-color:red;'";
                } ?>
                >
                    <form method="post"
                    action="index.php?uc=validerFiches&action=corrigerFraisHorsForfait"
                    role="form">
                        <td><input class="form-control" type="text" name="fraisHorsForfait[date]" value="<?php echo $date ?>"></td>
                        <td><input class="form-control" type="text" name="fraisHorsForfait[libelle]" value="<?php echo substr($libelle, 0, 26) ?>"></td>
                        <td><input class="form-control" type="text" name="fraisHorsForfait[montant]" value="<?php echo $montant ?>"></td>
                        <td><input class="form-control" type="hidden" name="fraisHorsForfait[estRefuse]" value="<?php echo $estRefuse ?>"></td>
                        <td>
                            <button class="btn btn-success" type="submit">Corriger</button>
                            <button class="btn btn-info" type="submit" name="reporter">Reporter</button>
                            <button class="btn btn-danger" type="reset">Réinitialiser</button>
                            <button class="btn btn-danger" type="submit" name="refuser"
                            <?php if ($estRefuse) {
                                echo "disabled";
                            } ?>
                            >Refuser</button>
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
    <form method="post"
          action="index.php?uc=validerFiches&action=validerFiche"
          role="form">
          <input type="hidden" name="lstVisiteurs" value="<?php echo $idVisiteur; ?>">
          <input type="hidden" name="lstMois" value="<?php echo $fiche; ?>">
          <?php if($idEtat == 'CR') { ?>
            <button class="btn btn-warning" type="submit" disabled>Saisie en cours...</button>
          <?php } 
          else { ?>
            <button class="btn btn-success" type="submit">Valider</button>
          <?php } ?>
          
    </form>
</div>