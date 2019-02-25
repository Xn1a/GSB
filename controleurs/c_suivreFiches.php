<?php
/**
 * Suivi du paiement des fiches de frais par les comptables
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    Pauline Gaonac'h <pauline.gaod@gmail.com>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */

/**
 * Affiche la fiche : infos et frais
 *
 * @param [type] $pdo : objet représentant la base de données
 * @param Int $idVisiteurSel : id du visiteur de la fiche à afficher
 * @param String $moisSel : mois de la fiche à afficher
 * @return void
 */
function afficherFiche($pdo, $idVisiteurSel, $moisSel)
{
    // Récupération des frais
    $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteurSel, $moisSel);
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteurSel, $moisSel);

    // Récupération des informations sur la fiche
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteurSel, $moisSel);
    $numAnnee = substr($moisSel, 0, 4);
    $numMois = substr($moisSel, 4, 2);
    $libEtat = $lesInfosFicheFrais['libEtat'];
    $montantValide = $lesInfosFicheFrais['montantValide'];
    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
    $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
    $etat = $lesInfosFicheFrais['idEtat'];

    // Récupération des informations sur le visiteur
    $infosUtilisateur = $pdo->getInfosUtilisateurParId($idVisiteurSel);
    $nomPrenom = $infosUtilisateur['prenom'] . ' ' . $infosUtilisateur['nom'];

    include 'vues/v_etatFrais.php';
}

/**
 * Affiche la liste des fiches dans une liste déroulante : mois, année, nom, prenom
 *
 * @param [type] $pdo : objet représentant la base de donnée
 * @param Int $idVisiteurSel
 * @param String $moisSel : sous la forme aaaamm
 * @return void
 */
function afficherListeFiches($pdo, $idVisiteurSel = null, $moisSel = null)
{
    $lesFiches = $pdo->getLesFichesValidees();
    include 'vues/v_listeFiches.php';
}

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

switch ($action) {
    case 'selectionnerFiche':
        afficherListeFiches($pdo);
        break;

    case 'consulterFiche':
        $fiche = filter_input(INPUT_POST, 'lstFiches', FILTER_DEFAULT, FILTER_SANITIZE_STRING);
        if ($fiche != 'Pas de fiches validées disponibles actuellement') {
            $fiche = explode('-', $fiche);
            $moisSel = $fiche[1];
            $idVisiteurSel = $fiche[0];
            afficherListeFiches($pdo, $idVisiteurSel, $moisSel);
            afficherFiche($pdo, $idVisiteurSel, $moisSel);
        } else {
            afficherListeFiches($pdo);
        }
        break;

    case 'mettreEnPaiement':
        $moisSel = filter_input(INPUT_POST, 'mois', FILTER_DEFAULT, FILTER_SANITIZE_STRING);
        $idVisiteurSel = filter_input(INPUT_POST, 'idVisiteur', FILTER_DEFAULT, FILTER_SANITIZE_STRING);

        // On met la fiche en paiement
        $pdo->majEtatFicheFrais($idVisiteurSel, $moisSel, 'MP');

        afficherListeFiches($pdo, $idVisiteurSel, $moisSel);

        // Affiche le message de confirmation
        ajouterInfo('La fiche a bien été mise en paiement');
        include 'vues/v_infos.php';

        afficherFiche($pdo, $idVisiteurSel, $moisSel);
        break;

    case 'mettreARemboursee':
        $moisSel = filter_input(INPUT_POST, 'mois', FILTER_DEFAULT, FILTER_SANITIZE_STRING);
        $idVisiteurSel = filter_input(INPUT_POST, 'idVisiteur', FILTER_DEFAULT, FILTER_SANITIZE_STRING);
        // On met la fiche a l'état remboursé
        $pdo->majEtatFicheFrais($idVisiteurSel, $moisSel, 'RB');

        afficherListeFiches($pdo, $idVisiteurSel, $moisSel);

        // Affiche le message de confirmation
        ajouterInfo("La fiche a bien été mise à l'état remboursée");
        include 'vues/v_infos.php';

        afficherFiche($pdo, $idVisiteurSel, $moisSel);
        break;

    default:
        afficherListeFiches($pdo);
        break;
}
