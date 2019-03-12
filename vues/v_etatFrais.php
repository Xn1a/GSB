<?php
/**
 * Vue État de Frais
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
<?php require 'vues/v_infosFiche.php' ?>
<div class="panel panel-info">
    <div class="panel-heading">Eléments forfaitisés</div>
    <table class="table table-bordered table-responsive">
        <tr>
            <?php
            foreach ($lesFraisForfait as $unFraisForfait) {
                $libelle = $unFraisForfait['libelle']; ?>
            <th>
                <?php echo htmlspecialchars($libelle, ENT_QUOTES) ?>
            </th>
            <?php
            }
            ?>
        </tr>
        <tr>
            <?php
            foreach ($lesFraisForfait as $unFraisForfait) {
                $quantite = $unFraisForfait['quantite']; ?>
            <td class="qteForfait">
                <?php echo $quantite ?>
            </td>
            <?php
            }
            ?>
        </tr>
    </table>
</div>
<div class="panel panel-info">
    <div class="panel-heading">Descriptif des éléments hors forfait -
        <?php echo $nbJustificatifs ?> justificatifs reçus</div>
    <table class="table table-bordered table-responsive">
        <tr>
            <th class="date">Date</th>
            <th class="libelle">Libellé</th>
            <th class='montant'>Montant</th>
        </tr>
        <?php
        foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
            $date = $unFraisHorsForfait['date'];
            $libelle = htmlspecialchars($unFraisHorsForfait['libelle'], ENT_QUOTES);
            $montant = $unFraisHorsForfait['montant'];
            $estRefuse = $unFraisHorsForfait['estRefuse']; ?>
        <tr <?php if ($estRefuse) { ?> style='background-color:red;' <?php } ?>>
            <td>
                <?php echo $date ?>
            </td>
            <td>
                <?php echo $libelle ?>
            </td>
            <td>
                <?php echo $montant ?>
            </td>
        </tr>
        <?php
        }
        ?>
    </table>
</div>
<?php 
if (($_SESSION['fonction'] == 'Comptable') && ($etat == 'VA')) { ?>
<form method="post" action="index.php?uc=suivreFiches&action=mettreEnPaiement"
    role="form">
    <input type="hidden" name="mois" value="<?php echo $moisSel ?>">
    <input type="hidden" name="idVisiteur" value="<?php echo $idVisiteurSel ?>">
    <button class="btn btn-info" type="submit"
        <?php 
        // Si on est pas encore au moins au 20 du mois suivant
        // le mois de la fiche on désactive le bouton
        if ((getdate()['mday'] < 20) && (getdate()['mon'] == $numMois+1) 
                && (getdate()['year'] == $numAnnee)) {
            echo 'disabled';
        } 
        ?>
        >Mettre en paiement
    </button>
</form>
<?php 
} 
?>

<?php 
if (($_SESSION['fonction'] == 'Comptable') && ($etat == 'MP')) { ?>
<form method="post" action="index.php?uc=suivreFiches&action=mettreARemboursee"
    role="form">
    <input type="hidden" name="mois" value="<?php echo $moisSel ?>">
    <input type="hidden" name="idVisiteur" value="<?php echo $idVisiteurSel ?>">
    <button class="btn btn-success" type="submit">Remboursée</button>
</form>
<?php 
} 
?>