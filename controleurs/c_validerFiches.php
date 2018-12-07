<?php
/**
 * Validation d'une fiche de frais
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

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

// Action par defaut "selectionnerVisiteur" : récupération de la liste
// des visiteurs et du visiteur selectionné si il y en a
$idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
$idVisiteurASelectionner = $idVisiteur;
$lesVisiteurs = $pdo->getLesVisiteurs();
require 'vues/v_listeVisiteurs.php';

// Récupération du mois selectionné si il y en a
$fiche = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
if (isset($fiche)) {
    $moisASelectionner = $fiche;
}

switch ($action) {
    // Selection de la fiche
    case 'selectionnerMois':
        // Affiche la liste des mois
        $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
        include 'vues/v_listeMoisComptables.php';
        break;

    // Affichage des frais forfait et hors forfait corrigeable
    case 'afficherFiche':
        afficherFrais($pdo, $idVisiteur, $fiche);
        break;

    // Mise à jour des frais forfaits
    case 'corrigerFraisForfait':
        $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);

        // Edition des frais forfaits
        if (lesQteFraisValides($lesFrais)) {
            $pdo->majFraisForfait($idVisiteur, $fiche, $lesFrais);
        } else {
            ajouterErreur('Les valeurs des frais doivent être numériques');
            include 'vues/v_erreurs.php';
        }

        afficherFrais($pdo, $idVisiteur, $fiche);
        break;

    // Mise à jour des frais hors forfaits
    case 'corrigerFraisHorsForfait':
        $fraisHorsForfait = filter_input(INPUT_POST, 'fraisHorsForfait', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        // Edition du frais hors forfait
        $pdo->majFraisHorsForfait($idVisiteur, $fiche, $fraisHorsForfait);
        afficherFrais($pdo, $idVisiteur, $fiche);
        break;
}

/**
 * Affiche le contenu de la fiche : les frais forfaits, les frais hors forfait, 
 * le nombre de justificatifs et la liste des fiches de l'utilisateurs.
 *
 * @param [type] $pdo
 * @param Int $idVisiteur
 * @param String $fiche
 * @return void
 */
function afficherFrais($pdo, $idVisiteur, $fiche) {
    // Récupérations des données nécessaires
    $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $fiche);
    $nombreJustificatifs = $pdo->getNbjustificatifs($idVisiteur, $fiche);
    $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $fiche);

    // Texte adapté aux utilisateurs comptables
    $texteSubmit = "Corriger";
    $texteReset = "Réinitialiser";
    $titre = "Valider la fiche de frais";
    $actionFormulaire = "index.php?uc=validerFiches&action=corrigerFraisForfait";

    // Affichage des vues
    include 'vues/v_listeMoisComptables.php';
    include 'vues/v_listeFraisForfait.php';
    echo "<hr/>";
    include 'vues/v_listeFraisHorsForfaitEditable.php';
}
