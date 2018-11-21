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

$fonctionUtilisateur = $_SESSION['fonction'];
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
    case 'selectionnerMois':
        // Affiche la liste des mois
        $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
        include 'vues/v_listeMoisComptables.php';
        break;

    case 'corrigerFrais':
        $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
        include 'vues/v_listeMoisComptables.php';

        // Affiche les formulaires
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $fiche);

        // Pour comptable
        $texteSubmit = "Corriger";
        $texteReset = "Réinitialiser";
        $titre = "Valider la fiche de frais";
        $actionFormulaire = "index.php?uc=validerFiches&action=validerMajFraisForfait";
        include 'vues/v_listeFraisForfait.php';
        echo "<hr/>";

        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $fiche);
        $nombreJustificatifs = $pdo->getNbjustificatifs($idVisiteur, $fiche);
        include 'vues/v_listeFraisHorsForfaitEditable.php';
        break;

    case 'validerMajFraisForfait':
        $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);

        $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
        include 'vues/v_listeMoisComptables.php';

        if (lesQteFraisValides($lesFrais)) {
            $pdo->majFraisForfait($idVisiteur, $fiche, $lesFrais);
        } else {
            ajouterErreur('Les valeurs des frais doivent être numériques');
            include 'vues/v_erreurs.php';
        }

        // Affichage des formulaires
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $fiche);

        // Pour comptable
        $texteSubmit = "Corriger";
        $texteReset = "Réinitialiser";
        $titre = "Valider la fiche de frais";
        $actionFormulaire = "index.php?uc=validerFiches&action=validerMajFraisForfait";
        include 'vues/v_listeFraisForfait.php';
        echo "<hr/>";
        break;

    case 'corrigerFraisHorsForfait':
        // Récupération des post
        $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        $fraisHorsForfait = filter_input(INPUT_POST, 'fraisHorsForfait', FILTER_DEFAULT, FILTER_FORCE_ARRAY);

        // Edition du frais hors forfait
        $pdo->majFraisHorsForfait($idVisiteur, $fiche, $fraisHorsForfait);

        // Récupérations des données nécessaires
        $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $fiche);
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $fiche);
        $nombreJustificatifs = $pdo->getNbjustificatifs($idVisiteur, $fiche);

        // Texte adapté aux utilisateurs comptables
        $texteSubmit = "Corriger";
        $texteReset = "Réinitialiser";
        $titre = "Valider la fiche de frais";
        $actionFormulaire = "index.php?uc=validerFiches&action=validerMajFraisForfait";

        // Affichage des vues
        include 'vues/v_listeMoisComptables.php';
        include 'vues/v_listeFraisForfait.php';
        include 'vues/v_listeFraisHorsForfaitEditable.php';

        break;
}
