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

/* Si le formulaire a été soumis*/
if (isset(
    $_POST['firstname'],
    $_POST['lastname'],
    $_POST['usermail'],
    $_POST['phone'],
    $_POST['postcode'],
    $_POST['message']
)) {
    // on appelle la fonction d'insertion dans la DB (addGuestbook())
    $insert = addGuestbook(
        db: $connectDB,
        firstname: $_POST['firstname'],
        lastname: $_POST['lastname'],
        usermail: $_POST['usermail'],
        phone: $_POST['phone'],
        postcode: $_POST['postcode'],
        message: $_POST['message']
    );
    // si l'insertion a réussi
    if ($insert === true) {
        // Succès : on stocke le message en session et on redirige 
        $_SESSION['feedbackMessage'] = ['type' => 'success', 'text' => 'Votre message a bien été enregistré !'];
    } else {
        // Échec de validation backend
        $feedbackMessage = ['type' => 'error', 'text' => 'Erreur : vérifiez vos données et réessayez.'];
    }
}
// on appelle la fonction de récupération de la DB (getAllGuestbook())
$messages   = getAllGuestbook($connectDB);
// $nbMessages = count($messages);
$nbMessages = getNbTotalGuestbook($connectDB);
$pageActu   = isset($_GET[PAGINATION_GET]) ? (int) $_GET[PAGINATION_GET] : 1;
if ($pageActu < 1) $pageActu = 1;
 
$paginationHtml = pagination($nbMessages, '?', PAGINATION_GET, $pageActu, PAGINATION_NB);
$offset         = ($pageActu - 1) * PAGINATION_NB;
$messages       = getGuestbookPagination($connectDB, $offset, PAGINATION_NB);


include URL_BASE . "/view/guestbookView.php";

// fermeture de la connexion (bonne pratique)
$connectDB = null;
