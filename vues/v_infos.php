<?php
/**
 * Vue Message d'information
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Pauline Gaonac'h <pauline.gaod@gmail.com>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */
?>
<div class="alert alert-success" role="alert">
    <?php
    foreach ($_REQUEST['infos'] as $message) {
        echo '<p>' . htmlspecialchars($message) . '</p>';
    }
    ?>
</div>