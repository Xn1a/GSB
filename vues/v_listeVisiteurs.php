<?php
/**
 * Vue : Liste des visiteurs
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
    <div class="col-md-4">
        <form action="index.php?uc=validerFiches&action=selectionnerVisiteur"
            method="post" role="form">
            <div class="form-group">
                <label for="lstVisiteurs" accesskey="n">Chercher un nom :</label>
                <input type="search" name="recherche"
                    value="<?php echo htmlspecialchars($recherche, ENT_QUOTES); ?>"
                    placeholder="Rechercher un nom..." class="form-control" />
            </div>
            <input type="submit" value="Rechercher" name="rechercher" 
                            class="btn btn-info" role="button" />
        </form>
    </div>
    <div class="col-md-5">
        <form action="index.php?uc=validerFiches&action=selectionnerMois"
            method="post" role="form">
            <div class="form-group">
                <label for="lstVisiteurs" accesskey="n">Choisir un visiteur : </label>
                <select id="lstVisiteurs" name="lstVisiteurs" class="form-control">
                    <?php
                    foreach ($lesVisiteurs as $unVisiteur) { 
                        $nom = htmlspecialchars($unVisiteur['nom'], ENT_QUOTES);
                        $prenom = htmlspecialchars($unVisiteur['prenom'], ENT_QUOTES);
                        
                        if ($unVisiteur['id'] == $idVisiteurASelectionner) { ?>
                            <option selected value="<?php echo $unVisiteur['id'] ?>">
                                <?php echo $nom . ' ' . $prenom ?>
                            </option>
                    <?php 
                        } else { 
                    ?>
                            <option value="<?php echo $unVisiteur['id'] ?>">
                                <?php echo $nom . ' ' . $prenom ?>
                            </option>
                    <?php 
                        } 
                    } 
                    ?>
                </select>
            </div>
            <input id="ok" type="submit" value="Choisir" class="btn btn-success"
                role="button">
        </form>
    </div>
</div>