<?php

$pdo = new PDO('mysql:host=localhost;dbname=gsb_frais', 'userGsb', 'secret');
$pdo->query('SET CHARACTER SET utf8');

// On récupère les mots de passe de tous les utilisateurs avec leur ID
$requetePrepare = $pdo->prepare(
    "SELECT id, mdp FROM utilisateur"
);
$requetePrepare->execute();
$lesUtilisateurs = $requetePrepare->fetchAll();

// Pour chaque utilisateur
foreach ($lesUtilisateurs as $unUtilisateur) {
    // On hash le mot de passe
    $hashMdp = password_hash($unUtilisateur['mdp'], PASSWORD_DEFAULT, ['cost' => 12]);
    // On remplace la version non hachée du mot de passe par la version hachée
    $requetePrepare = $pdo->prepare(
        "UPDATE utilisateur SET mdp = :hashMdp WHERE id = :id"
    );
    $requetePrepare->bindParam(':hashMdp', $hashMdp, PDO::PARAM_STR);
    $requetePrepare->bindParam(':id', $unUtilisateur['id'], PDO::PARAM_STR);
    $requetePrepare->execute();
}
