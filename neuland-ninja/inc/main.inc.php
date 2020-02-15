<!DOCTYPE html>
<html>
    <?php require_once('./inc/head.inc.php'); ?>

    <body>
        <div id="wrapper">
            <?php require_once('./inc/pageHeader.inc.php'); ?>
            <main><br>
                <?php
                switch ($page) {
                    case 'create':
                        require_once('./inc/create.inc.php');
                        break;

                    case 'new':
                        require_once('./inc/new.inc.php');
                        break;

                    case 'read':
                        if (!empty($_GET['sure']) && $_GET['sure'] == 1) {
                            $ninjaData = getNinjaMessage($mysqli, $_GET['read']);

                            if ($ninjaData) require_once('./inc/read.inc.php');
                            else echo '<div class="halign-center">
                                    <span class="errorText halfSizeCT"><span class="bold">Als ich diese Nachricht rauchte musste ich sehr intensiv husten!</span><br>
                                    Leider ist nichts mehr von der Nachricht &uuml;brig, nur noch ein wenig Asche.</span><br><br>
                                    <input type="button" value="Lass es uns noch einmal versuchen ..." name="readNoBtn" id="readNoBtn"></div>';
                        } else echo '<div class="halign-center">
                                    <span class="infoText halfSizeCT"><span class="bold">Wenn du diese Nachricht liest wird sie von mir als Zigarettenpapier benutzt und aufgeraucht!</span><br>
                                    Bist du dir sicher das du diese Nachricht lesen m&ouml;chtest und diese sich dann selbst zerst&ouml;rt?</span><br><br>
                                    <input type="button" value="Ja, auf jeden Fall" name="readYesBtn" id="readYesBtn">
                                    <input type="button" value="Nein, ich bin mir unsicher" name="readNoBtn" id="readNoBtn"></div>';
                        break;

                    case 'imprint':
                        require_once('./inc/refs.inc.php');
                        break;
                    
                    default:
                        require_once('./inc/error.inc.php');
                        break;
                }
                ?>
            </main>
        </div>
        <?php 
        require_once('./inc/feedbackUI.inc.php');
        require_once('./inc/footer.inc.php');
        ?>
    </body>
</html>
