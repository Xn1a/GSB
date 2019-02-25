<?php
/**
 * Validation d'une fiche de frais
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    Pauline Gaonac'h <pauline.gaod@gmail.com
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */

/**
 * Affiche le contenu de la fiche : les frais forfaits, les frais hors forfait,
 * le nombre de justificatifs, la liste des fiches de l'utilisateurs et les
 * informations sur la fiche (etat, visiteur, mois)
 *
 * @param [type] $pdo : l'objet représentant la base de données
 * @param Int $idVisiteur : l'id du visiteur de la fiche à afficher
 * @param String $leMois : le mois de la fiche à afficher
 * @return void
 */
function afficherFiche($pdo, $idVisiteur, $leMois)
{
    $moisASelectionner = $leMois;

    // Récupérations des données nécessaires
    $lesMois = $pdo->getLesMoisDisponiblesAEtats($idVisiteur, ['CL', 'CR']);
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
    $nombreJustificatifs = $pdo->getNbjustificatifs($idVisiteur, $leMois);
    $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);

    // Texte adapté aux utilisateurs comptables
    $texteSubmit = "Corriger";
    $texteReset = "Réinitialiser";
    $titre = "Valider la fiche de frais";
    $actionFormulaire = "index.php?uc=validerFiches&action=corrigerFraisForfait";

    // Affichage des vues
    include 'vues/v_listeMoisComptables.php';
    $idEtat = afficherInfosFiche($pdo, $idVisiteur, $leMois);
    include 'vues/v_listeFraisForfait.php';
    include 'vues/v_listeFraisHorsForfaitEditable.php';
}

/**
 * Affiche les informations concernant la fiche (etat, visiteur, mois)
 *
 * @param [type] $pdo : l'objet représentant la base de données
 * @param Int $idVisiteur : l'id du visiteur de la fiche à afficher
 * @param String $leMois : le mois de la fiche à afficher
 * @return $idEtat : l'id de l'état de la fiche
 */
function afficherInfosFiche($pdo, $idVisiteur, $leMois)
{
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $leMois);
    $numAnnee = substr($leMois, 0, 4);
    $numMois = substr($leMois, 4, 2);
    $idEtat = $lesInfosFicheFrais['idEtat'];
    $libEtat = $lesInfosFicheFrais['libEtat'];
    $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);

    $infosUtilisateur = $pdo->getInfosUtilisateurParId($idVisiteur);
    $nomPrenom = $infosUtilisateur['prenom'] . ' ' . $infosUtilisateur['nom'];

    include 'vues/v_infosFiche.php';
    return $idEtat;
}

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

// Action par defaut "selectionnerVisiteur" : récupération de la liste
// des visiteurs et du visiteur selectionné si il y en a
$idVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
$idVisiteurASelectionner = $idVisiteur;
$lesVisiteurs = $pdo->getLesVisiteurs();

// Récupération du mois selectionné si il y en a
$leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
if (isset($leMois)) {
    $moisASelectionner = $leMois;
}

// Affichage des visiteurs en fonction de la recherche si utilisée
$recherche = trim(filter_input(INPUT_POST, 'recherche', FILTER_SANITIZE_STRING));
$btnRechercher = filter_input(INPUT_POST, 'rechercher', FILTER_SANITIZE_STRING);

if ((isset($btnRechercher)) && (!empty($recherche))) {
    $termesRecherche = explode(' ', $recherche);
    foreach ($termesRecherche as $terme) {
        $i = 0;
        foreach ($lesVisiteurs as $unVisiteur) {
            if ((stripos($unVisiteur['nom'], $terme) === false)
                && (stripos($unVisiteur['prenom'], $terme) === false)) {
                unset($lesVisiteurs[$i]);
            }
            $i++;
        }
    }
}

require 'vues/v_listeVisiteurs.php';

if ((!isset($btnRechercher)) && (empty($btnRechercher))) {
    switch ($action) {

        case 'selectionnerMois':
            // Affiche la liste des fiches
            $lesMois = $pdo->getLesMoisDisponiblesAEtats($idVisiteur, ['CL', 'CR']);
            include 'vues/v_listeMoisComptables.php';
            break;

        case 'afficherFiche':
            if ($leMois != 'Pas de fiche de frais pour ce visiteur ce mois') {
                afficherFiche($pdo, $idVisiteur, $leMois);
            }
            break;

        case 'corrigerFraisForfait':
            $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);

            // Edition des frais forfaits
            if (lesQteFraisValides($lesFrais)) {
                $pdo->majFraisForfait($idVisiteur, $leMois, $lesFrais);
            } else {
                ajouterErreur('Les valeurs des frais doivent être numériques');
                include 'vues/v_erreurs.php';
            }

            ajouterInfo('Les frais ont bien été corrigés.');
            include 'vues/v_infos.php';
            afficherFiche($pdo, $idVisiteur, $leMois);
            break;

        case 'corrigerFraisHorsForfait':
            $fraisHorsForfait = filter_input(INPUT_POST, 'fraisHorsForfait', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
            $btnRefuser = filter_input(INPUT_POST, 'refuser', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
            $btnReporter = filter_input(INPUT_POST, 'reporter', FILTER_DEFAULT, FILTER_FORCE_ARRAY);

            // Report du frais
            if (isset($btnReporter)) {
                $pdo->reporterFraisHorsForfait($idVisiteur, $fraisHorsForfait);
                ajouterInfo('Le frais a bien été reporté au mois prochain.');
            } else if (isset($btnRefuser)) { // Refus du frais
                $pdo->refuserFraisHorsForfait($idVisiteur, $leMois, $fraisHorsForfait);
                ajouterInfo('Le frais a bien été refusé.');
            } else { // Correction du frais
                $pdo->majFraisHorsForfait($idVisiteur, $leMois, $fraisHorsForfait);
                ajouterInfo('Le frais a bien été corrigé.');
            }

            // Affichage de la vue
            include 'vues/v_infos.php';
            afficherFiche($pdo, $idVisiteur, $leMois);
            break;

        case 'validerFiche':
            // Addition des frais validés
            $lesMontantsFraisHorsForfaitValides
            = $pdo->getLesMontantsFraisHorsForfaitValides($idVisiteur, $leMois);
            $lesMontantFraisForfait
            = $pdo->getLesMontantsFraisForfait($idVisiteur, $leMois);

            // Ajout du montant total validé dans la base de données
            $montantTotalValide = array_sum($lesMontantsFraisHorsForfaitValides)
             + array_sum($lesMontantFraisForfait);
            $pdo->majMontantValideFicheFrais($idVisiteur, $leMois, $montantTotalValide);

            // Changement de l'état de la fiche
            $pdo->majEtatFicheFrais($idVisiteur, $leMois, 'VA');
            break;
    }
}
