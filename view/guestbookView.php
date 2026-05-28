<?php
# view/guestbookView.php
?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TI2 | Livre d'or</title>
    <link rel="icon" type="image/png" href="img/favicon.png">
    <link rel="stylesheet" href="./css/style.css">
    <script src="js/jquery-3.7.1.min.js"></script>
</head>

<script src="js/validation.js"></script>

<body>
    <header>
        <div class="logo">
            <img class="logo-img" src="./img/favicon.png" alt="">
        </div>
        <div class="titre">
            <h1>TI2 | Livre d'or</h1>
            <p>laissez une trace de votre passage</p>
        </div>
        <nav class="nav">
            <button class="admin-btn" id="dark-btn">
                <img class="engronage" src="./img/reglage.png" alt="">
                Dark Mode
            </button>
        </nav>
    </header>
    <main>
        <!-- Formulaire d'ajout d'un message -->
        <div class="addGuestComment">
            <div class="book-img-container">
                <img src="./img/livre-ouvert.png" alt="">
            </div>

            <?php
            // on a tenté d'envoyé le formulaire et
            if (isset($insert)):
                // échec de l'insertion
                if ($insert === false):
            ?>
                    <div id="modal-container" class="modal ">
                        <div class="modal-content rouge">
                            <div class="not-insert-message ">
                                échec lors d'un l'insertion <a class="retour" href="javascript:history.go(-1);">Vérifiez votre formulaire</a>
                            </div>
                        </div>
                    </div>
                <?php
                // réussite de l'insertion
                else:
                ?>
                    <div id="modal-container" class="modal ">
                        <div class="modal-content vert">
                            <div class="insert-message">
                                Merci pour votre message, vous allez être redirigé
                                <script>
                                    setTimeout(
                                        function() {
                                            window.location.href = "./";
                                        }, 3000
                                    );
                                </script>
                            </div>
                        </div>
                    </div>

            <?php
                endif;
            endif;
            ?>

            <form action="" method="post" id="guestbookForm" novalidate>

                <div class="form-group" id="f-firstname">
                    <label for="firstname">Prénom</label>
                    <span class="hint"></span>
                    <input type="text" name="firstname" id="firstname"
                        value="<?= htmlspecialchars($_POST['firstname'] ?? '') ?>"
                        required>
                </div>

                <div class="form-group" id="f-lastname">
                    <label for="lastname">Nom</label>
                    <span class="hint"></span>
                    <input type="text" name="lastname" id="lastname"
                        value="<?= htmlspecialchars($_POST['lastname'] ?? '') ?>"
                        required>
                </div>

                <div class="form-group" id="f-email">
                    <label for="usermail">E-mail</label>
                    <span class="hint"></span>
                    <input type="email" name="usermail" id="usermail"
                        value="<?= htmlspecialchars($_POST['usermail'] ?? '') ?>"
                        required>
                </div>

                <div class="form-group" id="f-postcode">
                    <label for="postcode">Code Postal</label>
                    <span class="hint"></span>
                    <input type="text" name="postcode" id="postcode"
                        value="<?= htmlspecialchars($_POST['postcode'] ?? '') ?>"
                        required>
                </div>

                <div class="form-group" id="f-phone">
                    <label for="phone">Numero de Téléphone</label>
                    <span class="hint"></span>
                    <input type="text" name="phone" id="phone"
                        value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                        required>
                </div>

                <div class="form-group">
                    <label for="message">Message</label>

                    <div class="textarea-wrapper" id="f-message">
                        <textarea name="message" id="message" maxlength="300" rows="5"
                            required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                        <span id="charCount" class="char-count">0 / 300 caractères</span>
                    </div>
                </div>
                <div class="checkbox">
                    <input type="checkbox">
                    <label for="checkbox">J'accepte le stockage de mes données personellles</label>
                </div>

                <button id="btn-sub" class="submit-btn" type="submit">Envoyer</button>

            </form>

        </div>



        <!-- Liste des messages -->
        <div class="messages-div">

            <div class="titre-message">
                <?php if ($nbMessages === 0): ?>
                    <h2 class="nb-messages">Messages récents - Pas encore de message</h2>
                <?php elseif ($nbMessages === 1): ?>
                    <h2 class="nb-messages">Messages récent - Il y a actuellement 1 message</h2>
                <?php else: ?>
                    <h2 class="nb-messages">Messages récents - Il y a actuellement <?= $nbMessages ?> messages</h2>
                <?php endif; ?>
            </div>
            <div class="list-commentaires">
                <?php foreach ($messages as $msg): ?>

                    <div class="commentaires-utilisateur">
                        <div class="entete-message">
                            <div class="entete-message-gauche">

                                <p>
                                    <?= htmlspecialchars($msg['firstname']) ?>
                                    <?= htmlspecialchars($msg['lastname']) ?>
                                </p>
                                <p>
                                    <?= htmlspecialchars($msg['usermail']) ?>
                                </p>
                            </div>
                            <div class="entete-message-droite">
                                <p class="message-meta">
                                    <?php
                                    $date = new DateTime($msg['datemessage']);
                                    echo 'le (' . $date->format('d/m/Y') . ' à ' . $date->format('H\hi') . ')';
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="message-content">
                            <p>
                                <?= (htmlspecialchars($msg['message'])) ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>


            <!-- Pagination (BONUS) -->
            <div class="pagination">
                <?php if (!empty($paginationHtml)) echo $paginationHtml; ?>
            </div>
            <!-- Pagination (BONUS) -->
        </div>
        <?php
        // À commenter quand on a fini de tester
        // echo "<h3>Nos var_dump() pour le débugage</h3>";
        // echo '<p>$_POST</p>';
        // var_dump($_POST);
        // echo '<p>$_GET</p>';
        // var_dump($_GET);
        ?>

    </main>
</body>

</html>