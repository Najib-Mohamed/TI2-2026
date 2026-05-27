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

<body>
    <script src="js/validation.js"></script>
    <header>
        <div class="logo">
            <img class="logo-img" src="./img/favicon.png" alt="">
        </div>
        <div class="titre">
            <h1>TI2 | Livre d'or</h1>
            <p>laissez une trace de votre passage</p>
        </div>
        <nav class="nav">
            <button class="admin-btn">
                <img class="engronage" src="./img/reglage.png" alt="">
                Administration
            </button>
        </nav>
    </header>
    <main>
        <!-- Formulaire d'ajout d'un message -->
        <div class="addGuestComment">
            <div class="book-img-container">
                <img src="./img/livre-ouvert.png" alt="">
            </div>
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

                <div class="form-group">
                    <label for="phone">Numero de Téléphone</label>
                    <span class="hint"></span>
                    <input type="text" name="phone" id="phone"
                        value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                        required>
                </div>

                <div class="form-group">
                    <label for="message">Message</label>
                    
                    <div class="textarea-wrapper">
                        <textarea name="message" id="message" rows="5"
                            required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                        <span id="charCount" class="char-count">0 / 300 caractères</span>
                    </div>
                </div>
                <div class="form-group">
                    <input type="checkbox">
                    <label for="checkbox">J'accepte le stockage de mes données personellles</label>
                </div>

                <button class="submit-btn" type="submit">Envoyer</button>

            </form>
            <?php
            // on a tenté d'envoyé le formulaire et
            if (isset($insert)):
                // échec de l'insertion
                if ($insert === false):
            ?>
                    <div class="not-insert-message">
                        échec lors d'un l'insertion <a href="javascript:history.go(-1);">Vérifiez votre formulaire</a>
                    </div>
                <?php
                // réussite de l'insertion
                else:
                ?>
                    <div class="insert-message">
                        Merci pour votre message, vous allez être redirigé
                        <script>
                            setTimeout(
                                function() {
                                    window.location.href = "./";
                                }, 500
                            );
                        </script>
                    </div>
            <?php
                endif;
            endif;
            ?>
        </div>



        <!-- Liste des messages -->
        <div class="messages-div">

            <div class="titre-message">
                <?php if ($nbMessages === 0): ?>
                    <h2 class="nb-messages">Messagess récent - Pas encore de message</h2>
                <?php elseif ($nbMessages === 1): ?>
                    <h2 class="nb-messages">Messagess récent - Il y a actuellemnt 1 message</h2>
                <?php else: ?>
                    <h2 class="nb-messages">Messagess récent - Il y a actuellemnt <?= $nbMessages ?> messages</h2>
                <?php endif; ?>
            </div>

            <?php if (!empty($paginationHtml)) echo $paginationHtml; ?>
            <!-- Autres messages -->
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


        </div>
        <!-- Pagination (BONUS) -->
        <!-- Pagination (BONUS) -->
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