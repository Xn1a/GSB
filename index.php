<?php ob_start();

/**
 * Index du projet GSB
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

require_once 'includes/fct.inc.php';
require_once 'includes/class.pdogsb.inc.php';
session_start();

$pdo = PdoGsb::getPdoGsb();
$estConnecte = estConnecte();

// Affiche les liens vers les pages en fonction de l'utilisateur
// Si visiteur
$page1 = array(
    "titre" => "Renseigner la fiche de frais",
    "lien" => "index.php?uc=gererFrais&action=saisirFrais",
    "icon" => "glyphicon-pencil",
);
$page2 = array(
    "titre" => "Afficher mes fiches de frais",
    "lien" => "index.php?uc=etatFrais&action=selectionnerMois",
    "icon" => "glyphicon-list-alt",
);

// Si comptable
if ($_SESSION['fonction'] == "Comptable") {
    $page1 = array(
        "titre" => "Valider les fiches de frais",
        "lien" => "index.php?uc=validerFiches&action=selectionnerVisiteur",
        "icon" => "glyphicon-ok",
    );
    $page2 = array(
        "titre" => "Suivre le paiement des fiches de frais",
        "lien" => "index.php?uc=suivreFiches&action=",
        "icon" => "glyphicon-euro",
    );
}

require 'vues/v_entete.php';

$uc = filter_input(INPUT_GET, 'uc', FILTER_SANITIZE_STRING);
if ($uc && !$estConnecte) {
    $uc = 'connexion';
} elseif (empty($uc)) {
    $uc = 'accueil';
}

// Routes
switch ($uc) {
    case 'connexion':
        include 'controleurs/c_connexion.php';
        break;
    case 'accueil':
        include 'controleurs/c_accueil.php';
        break;
    case 'gererFrais':
        include 'controleurs/c_gererFrais.php';
        break;
    case 'etatFrais':
        include 'controleurs/c_etatFrais.php';
        break;
    case 'validerFiches':
        include 'controleurs/c_validerFiches.php';
        break;
    case 'suivreFiches':
        include 'controleurs/c_suivreFiches.php';
        break;
    case 'deconnexion':
        include 'controleurs/c_deconnexion.php';
        break;
}
require 'vues/v_pied.php';

ob_end_flush();