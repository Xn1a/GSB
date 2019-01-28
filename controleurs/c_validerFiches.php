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

// Récupération du mois selectionné si il y en a
$fiche = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
if (isset($fiche)) {
    $moisASelectionner = $fiche;
}

// Affichage des visiteurs en fonction de la recherche si utilisée
$recherche = trim(filter_input(INPUT_POST, 'recherche', FILTER_SANITIZE_STRING));
$btnRechercher = filter_input(INPUT_POST, 'rechercher', FILTER_SANITIZE_STRING);
if (isset($btnRechercher) && !empty($recherche)) {
    $termesRecherche = explode(' ', $recherche);
    foreach ($termesRecherche as $terme) {
        $i = 0;
        foreach ($lesVisiteurs as $unVisiteur) {
            if (stripos($unVisiteur['nom'], $terme) === false && stripos($unVisiteur['prenom'], $terme) === false) {
                unset($lesVisiteurs[$i]);
            }
            $i++;
        }
    }
}

require 'vues/v_listeVisiteurs.php';

if (!isset($btnRechercher) && empty($btnRechercher)) {
    switch ($action) {
        // Selection de la fiche
        case 'selectionnerMois':
            // Affiche la liste des mois
            $lesMois = $pdo->getLesMoisNonCLDisponibles($idVisiteur);
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

            ajouterInfo('Les frais hors forfait on bien été corrigés.');
            include 'vues/v_infos.php';
            afficherFrais($pdo, $idVisiteur, $fiche);
            break;

        // Mise à jour des frais hors forfaits
        case 'corrigerFraisHorsForfait':
            $fraisHorsForfait = filter_input(INPUT_POST, 'fraisHorsForfait', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
            $btnRefuser = filter_input(INPUT_POST, 'refuser', FILTER_DEFAULT, FILTER_FORCE_ARRAY);

            if (isset($btnRefuser)) {
                // TODO: Change libelle frais and add au début "REFUSE :"
                $fraisHorsForfait['libelle'] = "REFUSE : " . $fraisHorsForfait['libelle'];
                ajouterInfo('Le frais forfait a bien été refusé.');
            }

            // Edition du frais hors forfait
            $pdo->majFraisHorsForfait($idVisiteur, $fiche, $fraisHorsForfait);

            if (!isset($btnRefuser)) {
                ajouterInfo('Le frais forfait a bien été corrigé.');
            }

            // Affichage de la vue
            include 'vues/v_infos.php';
            afficherFrais($pdo, $idVisiteur, $fiche);
            break;

        case 'validerFiche':
            // Changement de l'état de la fiche
            $pdo->majEtatFicheFrais($idVisiteur, $fiche, 'VA');
            break;
    }
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
function afficherFrais($pdo, $idVisiteur, $fiche)
{
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
