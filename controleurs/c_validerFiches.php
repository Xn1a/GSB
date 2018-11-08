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

// Récupération de la liste des visiteurs
$lesVisiteurs = $pdo->getLesVisiteurs();

$idVisiteur = null;
$fiche = null;

if ($action == "selectionnerMois") {
    // On récupère l'id de l'utilisateur selectionné
    $idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
    // On le reselection dans la liste
    $idVisiteurASelectionner = $idVisiteur;
}
if ($action == "corrigerFrais") {
    $idVisiteur = filter_input(INPUT_POST, 'idVisiteur', FILTER_SANITIZE_STRING);
    $idVisiteurASelectionner = $idVisiteur;
    $fiche = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
    $moisASelectionner = $fiche;
}
require 'vues/v_listeVisiteurs.php';

if ($action == "selectionnerMois") {
    $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
    include 'vues/v_listeMoisComptables.php';
}
// Fiche selectionnée : on affiche les formulaires
if ($action == "corrigerFrais") {
    // Réaffiche le mois selectionné
    $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
    include 'vues/v_listeMoisComptables.php';

    // Affiche les formulaires
    // TODO : include les formulaire d'affichage et correction de la fiche
}
