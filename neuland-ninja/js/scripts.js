var ninjaMsgInput = null;
var encryptBtn = null;
var decryptBtn = null;
var passInput = null;
var passCheckInput = null;
var fullEncMsg = null;
var isEncrypted = null;
var readYesBtn = null;
var readNoBtn = null;
var passwordTryInput = null;
var decryptTryBtn = null;
var payloadH = null;
var messageViewTA = null;
var copyLinkBtn = null;
var ninjaLinkT = null;
var selfDestructModeSel = null;
var showTimeLeftCB = null;
var showTimeLeftCBL = null;

var currentLocation = window.location;

docReady(function() {
    ninjaMsgInput = document.querySelector('#messageTA');
    encryptBtn = document.querySelector('#encryptBtn');
    decryptBtn = document.querySelector('#decryptBtn');
    passInput = document.querySelector('#passwordT');
    passCheckInput = document.querySelector('#passwordCheckT');
    fullEncMsg = document.querySelector('#fullEncryptedMessage');
    isEncrypted = document.querySelector('#isEncrypted');
    readYesBtn = document.querySelector('#readYesBtn');
    readNoBtn = document.querySelector('#readNoBtn');
    passwordTryInput = document.querySelector('#passwordTryT');
    decryptTryBtn = document.querySelector('#decryptTryBtn');
    payloadH = document.querySelector('#payloadH');
    messageViewTA = document.querySelector('#messageViewTA');
    copyLinkBtn = document.querySelector('#copyLinkBtn');
    ninjaLinkT = document.querySelector('#ninjaLinkT');
    selfDestructModeSel = document.querySelector('#selfDestructModeSel');
    showTimeLeftCB = document.querySelector('#showTimeLeftCB');
    showTimeLeftCBL = document.querySelector('#showTimeLeftCBL');

    if (payloadH !== null && messageViewTA !== null) {
        if (passwordTryInput == null && decryptTryBtn == null) messageViewTA.value = htmlDecode(atob(payloadH.value));
        else messageViewTA.value = JSON.parse(htmlDecode(atob(payloadH.value))).ct;
    }

    if (ninjaMsgInput !== null) {
        if (ninjaMsgInput.addEventListener) {
            ninjaMsgInput.addEventListener('input', charCountOut, false);
            ninjaMsgInput.addEventListener('input', checkPass, false);
        } else if (ninjaMsgInput.attachEvent) {
            ninjaMsgInput.attachEvent( 'onpropertychange', charCountOut);
            ninjaMsgInput.attachEvent( 'onpropertychange', checkPass);
        }
    }

    if (encryptBtn !== null) {
        if (encryptBtn.addEventListener) encryptBtn.addEventListener('click', encryptNinjaMessage, false);
        else if (encryptBtn.attachEvent) encryptBtn.attachEvent('onclick', encryptNinjaMessage);
    }

    if (decryptBtn !== null) {
        if (decryptBtn.addEventListener) decryptBtn.addEventListener('click', decryptNinjaMessage, false);
        else if (decryptBtn.attachEvent) decryptBtn.attachEvent('onclick', decryptNinjaMessage);
    }

    if (passInput !== null) {
        if (passInput.addEventListener) passInput.addEventListener('input', checkPass, false);
        else if (passInput.attachEvent) passInput.attachEvent('onpropertychange', checkPass);
    }

    if (passCheckInput !== null) {
        if (passCheckInput.addEventListener) passCheckInput.addEventListener('input', checkPass, false);
        else if (passCheckInput.attachEvent) passCheckInput.attachEvent('onpropertychange', checkPass);
    }

    if (readYesBtn !== null) {
        if (readYesBtn.addEventListener) readYesBtn.addEventListener('click', function() { window.open(currentLocation.href+'&sure=1', '_self') }, false);
        else if (readYesBtn.attachEvent) readYesBtn.attachEvent('onclick', function() { window.open(currentLocation.href+'&sure=1', '_self') });
    }

    if (readNoBtn !== null) {
        if (readNoBtn.addEventListener) readNoBtn.addEventListener('click', function() { window.open(currentLocation.protocol+'//'+currentLocation.hostname, '_self') }, false);
        else if (readNoBtn.attachEvent) readNoBtn.attachEvent('onclick', function() { window.open(currentLocation.protocol+'//'+currentLocation.hostname, '_self') });
    }

    if (passwordTryInput !== null) {
        if (passwordTryInput.addEventListener) passwordTryInput.addEventListener('input', checkTryPass, false);
        else if (passwordTryInput.attachEvent) passwordTryInput.attachEvent('onpropertychange', checkTryPass);
    }

    if (decryptTryBtn !== null) {
        if (decryptTryBtn.addEventListener) decryptTryBtn.addEventListener('click', decryptViewNinjaMessage, false);
        else if (decryptTryBtn.attachEvent) decryptTryBtn.attachEvent('onpropertychange', decryptViewNinjaMessage);
    }

    if (copyLinkBtn !== null && ninjaLinkT !== null) {
        if (copyLinkBtn.addEventListener) copyLinkBtn.addEventListener('click', function() { copyTextInput(ninjaLinkT) }, false);
        else if (copyLinkBtn.attachEvent) copyLinkBtn.attachEvent('onclick', function() { copyTextInput(ninjaLinkT) });
    }

    if (selfDestructModeSel !== null && showTimeLeftCB !== null) {
        if (selfDestructModeSel.addEventListener) selfDestructModeSel.addEventListener('change', checkSdMode, false);
        else if (selfDestructModeSel.attachEvent) selfDestructModeSel.attachEvent('onchange', checkSdMode)
    }
});
