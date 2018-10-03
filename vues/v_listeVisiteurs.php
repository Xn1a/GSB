<?php

/**
 * Vue Liste des visiteurs
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
        <form action="" 
              method="post" role="form">
            <div class="form-group">
                <label for="lstVisiteurs" accesskey="n">Choisir le visiteur : </label>
                <select id="lstVisiteurs" name="lstVisiteurs" class="form-control">
                    <?php foreach ($lesVisiteurs as $unVisiteur) { ?>
                        <option value="<?php echo $unVisiteur['login'] ?>">
                        <?php echo $unVisiteur['nom'] . ' ' . $unVisiteur['prenom'] ?>
                        </option>
                    <?php } ?>    
                </select>
            </div>
        </form>
    </div>
</div>