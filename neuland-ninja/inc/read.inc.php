<input type="hidden" value="<?php echo htmlentities($ninjaData['payload']); ?>" name="payloadH" id="payloadH">
<div id="ninjaMessageViewCT">
    <?php if ($ninjaData['hasErrors'] == 1) { ?>
        <span class="warnText">Bei der &Uuml;bermittlung der Nachicht funktionierte die Verschl&uuml;sselung deines Partners nicht Fehlerfrei!<br>Es kann allerdings sein das die Nachricht dennoch lesbar ist.</span>
    <?php } ?>

    <span id="viewMessageText" class="bold sectionCaption">Erhaltene Ninja-Nachricht lesen</span>
    <textarea cols="10" rows="10" name="messageViewTA" id="messageViewTA" autofocus readonly></textarea><br>

    <?php if ($ninjaData['showTimeLeft'] == 1 && $ninjaData['sdMode'] != 'afterRead') {
        $timeLeft = get_date_diff(date('Y-m-d H:i:s'), date('Y-m-d H:i:s', $ninjaData['sdTimestamp'])); ?>
        <span class="infoText">Verbleibende Zeit bis zur Selbstzerst&ouml;rung: <?php echo($timeLeft); ?></span>
    <?php } else { ?>
        <span class="infoText">Hmmm, erstmal eine rauchen ...</span>
    <?php } ?>

    <?php if ($ninjaData['isEncrypted'] == 1) { ?>
        <div id="cryptoCT">
            <span class="infoText"><span class="bold">Die Nachricht wurde verschl&uuml;sselt</span>, gib ein Passwort ein um einen Entschl&uuml;sselungsversuch zu starten.<?php if ($ninjaData['sdMode'] == 'afterRead') { ?><br>
            ACHTUNG: Du kannst die Nachricht nur in dieser Sitzung entschl&uuml;sseln, sobald du die Seite neu l&auml;dst ist dies nicht mehr m&ouml;glich, da die Nachricht dann bereits vernichtet wurde.<?php } ?></span>

            <table border="0" rules="none" id="cryptoCtTbl" class="halign-left">
                <tr>
                    <td><label for="passwordTryT">Passwort: </label><input type="password" value="" name="passwordTryT" id="passwordTryT"></td>
                    <td class="halign-right"><input type="button" value="Entschl&uuml;sselung versuchen" name="decryptTryBtn" id="decryptTryBtn" disabled></td>
                </tr>
            </table>
        </div>
    <?php } ?>
</div>
