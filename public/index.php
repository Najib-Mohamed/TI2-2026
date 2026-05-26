<?php
# public/index.php


/*
 * Front Controller de la gestion du livre d'or
 */

/*
 * Chargement des dépendances
 */
// chargement de configuration
require_once "../config.php";
// chargement du modèle de la table guestbook
require_once URL_BASE . "/model/guestbookModel.php";

/*
 * Connexion à la base de données en utilisant PDO
 * Avec un try catch pour gérer les erreurs de connexion
 * Utilisez les constantes de config.php
 * Activez le mode d'erreur de PDO à Exception et
 * le mode fetch à tableau associatif
 */

// connection à notre base de donnée 
try {
    $connectDB = new PDO(
        dsn: MARIA_DSN,
        username: DB_LOGIN,
        password: DB_PWD,
        // options, on active les erreurs pour ne pas avoir de pages blanches en cas de désaxtivation (optionnel depuis PHP 8.0)
        options: [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]
    );

    // option, on peut les ajouter après la connexion (donc en dehors de options:), sauf pour la connexion permanente, ici il s'agit du format de récupération php tableaux associatifs
    $connectDB->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // arrêt et affichage de l'erreur (ev dev)
    die($e->getMessage());
}

/*
 * Si le formulaire a été soumis
 */

// on appelle la fonction d'insertion dans la DB (addGuestbook())

if (isset($_POST['firstname'], $_POST['lastname'], $_POST['usermail'], $_POST['phone'], $_POST['postcode'], $_POST['message'])) {
    // envoi de nos var nécessaires à l'insertion 
    $addGuestbook = addGuestbook($connectDB, $_POST['firstname'], $_POST['lastname'], $_POST['usermail'], $_POST['phone'], $_POST['postcode'], $_POST['message']);
}

// si l'insertion a réussi

$allComment = getAllGuestbook($connectDB);

// on redirige vers la page actuelle (ou on affiche un message de succès)

// sinon, on affiche un message d'erreur

/*
 * On récupère les messages du livre d'or
 */



// on appelle la fonction de récupération de la DB (getAllGuestbook())

/*********************
 * Ou Bonus Pagination
 *********************/

// on vérifie sur quelle page on est (et que c'est un string qui contient que des numériques sans "." ni "-" => ctype_digit) en utilisant la variable $_GET et les constantes de config.php

# on compte le nombre total de messages (SQL)

# on récupère la pagination

# pour obtenir le $offset pour les messages (calcul)

# on veut récupérer les messages de la page courante

/**************************
 * Fin du Bonus Pagination
 **************************/

// Appel de la vue

include URL_BASE . "/view/guestbookView.php";

// fermeture de la connexion (bonne pratique)
