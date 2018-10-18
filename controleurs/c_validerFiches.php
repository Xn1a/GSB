<?php

/**
 * Validation d'une fiche de frais
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

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

$lesVisiteurs = $pdo->getLesVisiteurs();
$idVisiteur = null;

if ($action == "selectionnerMois") {
    $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
}
require 'vues/v_listeVisiteurs.php';

if ($action == "selectionnerMois") {
    $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
    include 'vues/v_listeMoisComptables.php';
}
