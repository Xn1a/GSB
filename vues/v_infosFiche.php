<div class="panel panel-primary">
    <div class="panel-heading">Fiche de frais du mois 
        <?php echo $numMois . '-' . $numAnnee ?> du visiteur <?php echo $nomPrenom ?> : </div>
    <div class="panel-body">
        <strong><u>Etat :</u></strong> <?php echo $libEtat ?>
        depuis le <?php echo $dateModif ?> <br> 

        <?php if (isset($montantValide)) {?>
            <strong><u>Montant validé :</u></strong> <?php echo $montantValide ?>
        <?php } ?>
    </div>
</div>