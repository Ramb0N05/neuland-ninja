<div id="ninjaMessageCT">
    <span id="newMessageText" class="bold sectionCaption">Neue Ninja-Nachricht verfassen</span><br>
    <form action="index.php?create=1" target="_self" method="post" autocomplete="off" enctype="multipart/form-data" accept-charset="UTF-8" name="NewNinjaMessage" id="NewNinjaMessage" class="halign-center">
        <div id="messageInputCT" class="halign-right">
            <textarea cols="10" rows="10" maxlength="1024" placeholder="Schreibe deine Nachricht hier..." name="messageTA" id="messageTA" required autofocus></textarea>
            <span id="charCount" class="extraInfoText"><span id="charsLeftVal">1024</span>/1024 Zeichen verbleibend</span>
        </div>

        <table border="0" rules="none" cellspacing="15" id="messageOptionsTbl" class="halign-left">
            <tr>
                <td width="398">
                    <label for="selfDestructModeSel" class="bold">Selbstzerst&ouml;rungsmodus</label><br>
                    <select name="selfDestructModeSel" id="selfDestructModeSel" class="optionsTblChild" required>
                        <?php
                        $sql = "SELECT `name`,`displayName`,`isDefault` FROM `sdModes` ORDER BY position ASC";
                        $result = $mysqli->query($sql);

                        if ($result && $result->num_rows > 0) {
                            while($data = $result->fetch_assoc()) {
                                echo '<option value="'.$data['name'].'" '.($data['isDefault'] == 1 ? 'selected' : '').'>'.$data['displayName'].'</option>';
                            }
                        } else echo '<option value="">!! Es ist ein Fehler aufgetreten !!</option>'
                        ?>
                    </select>
                </td>

                <td width="398">
                    <br>
                    <label for="showTimeLeftCB" id="showTimeLeftCBL">
                        <input type="checkbox" value="showTimeLeft" name="showTimeLeftCB" id="showTimeLeftCB" checked disabled>
                        Dem Leser die verbleibende Zeit bis zur Selbstzerst&ouml;rung anzeigen?
                    </label>
                </td>
            </tr>

            <tr>
                <td>
                    <label for="passwordT" class="bold">Passwort <span class="extraInfoText">(optional)</span></label><br>
                    <input type="password" value="" name="passwordT" id="passwordT" class="optionsTblChild">
                </td>

                <td>
                    <label for="passwordCheckT" class="bold">Best&auml;tigung  <span class="extraInfoText">(optional)</span></label><br>
                    <input type="password" value="" name="passwordCheckT" id="passwordCheckT" class="optionsTblChild">
                </td>
            </tr>

            <tr class="valign-top">
                <td>
                    <span class="extraInfoText">Das Passwort wird nicht nur abgefragt um die Nachricht anzuzeigen,&nbsp;
                    sondern sie wird bereits auf deinem Ger&auml;t mit dem Passwort verschl&uuml;sselt und erst dann &uuml;bermittelt.&nbsp;
                    Zur Verschl&uuml;sselung wird die <a href="http://bitwiseshiftleft.github.io/sjcl/" target="_blank" class="externalLink">Stanford Javascript Crypto Library</a> verwendet.</span>
                </td>

                <td class="halign-right">
                    <input type="button" value="Verschl&uuml;sseln" name="encryptBtn" id="encryptBtn" disabled><br>
                    <input type="button" value="Entschl&uuml;sseln" name="decryptBtn" id="decryptBtn" disabled>
                </td>
            </tr>
        </table>
        <br>
        <input type="hidden" value="false" name="isEncrypted" id="isEncrypted">
        <input type="hidden" value="" name="fullEncryptedMessage" id="fullEncryptedMessage">

        <input type="submit" value="Ninja-Nachricht erstellen" name="submitBtn" id="submitBtn">
    </form>
</div>
