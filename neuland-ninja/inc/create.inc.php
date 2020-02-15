<?php
$ninjaData = checkNinjaForm();

if ($ninjaData) {
    $link = createNinjaMessage($mysqli, $ninjaData);

    if ($link) { ?>
        <div class="halign-center">
            <span class="infoText halfSizeCT">
                <label for="ninjaLinkT">Deine Ninja-Nachricht wurde erfolgreich erstellt...</label>
                <input type="text" value="<?php echo $link; ?>" name="ninjaLinkT" id="ninjaLinkT" readonly><br><br>
                <input type="button" value="Link kopieren" name="copyLinkBtn" id="copyLinkBtn">
            </span>
        </div>
    <?php } else { ?> 
        <div class="halign-center">
            <span class="errorText halfSizeCT">Es ist ein Fehler beim erstellen deiner Nachricht aufgetreten!<br>
            Versuche es erneut oder kontaktiere den Administrator.</span>
        </div>
    <?php }
} else { ?>
    <div class="halign-center">
        <span class="errorText halfSizeCT">Es ist ein Fehler bei der &Üuml;bermittlung deiner Nachricht aufgetreten!<br>
        Versuche es erneut oder kontaktiere den Administrator.</span>
    </div>
<?php } ?>
