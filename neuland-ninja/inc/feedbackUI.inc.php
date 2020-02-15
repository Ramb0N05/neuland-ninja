<div id="feedbackUI" style="display: none;">
    <span id="feedbackText" class="bold sectionCaption">Feedback</span>
    
    <form action="index.php?feedback=1" target="_self" method="post" autocomplete="on" enctype="multipart/form-data" accept-charset="UTF-8" name="NinjaFeedbackMessage" id="NinjaFeedbackMessage">
        <label for="pseudoT">Pseudonym</label><br>
        <input type="text" value="" name="pseudoT" id="pseudoT" class="almostFullWidthCT"><br>

        <label for="feedbackMessageTA">Nachricht</label><br>
        <textarea cols="15" rows="5" maxlength="1024" placeholder="Schreibe deine Verbesserungsvorschl&auml;ge hier..." name="feedbackMessageTA" id="feedbackMessageTA" class="almostFullWidthCT" required></textarea>
    </form>
</div>