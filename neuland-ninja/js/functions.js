(function(funcName, baseObj) {
    // The public function name defaults to window.docReady
    // but you can pass in your own object and own function name and those will be used
    // if you want to put them in a different namespace
    funcName = funcName || "docReady";
    baseObj = baseObj || window;
    var readyList = [];
    var readyFired = false;
    var readyEventHandlersInstalled = false;

    // call this when the document is ready
    // this function protects itself against being called more than once
    function ready() {
        if (!readyFired) {
            // this must be set to true before we start calling callbacks
            readyFired = true;
            for (var i = 0; i < readyList.length; i++) {
                // if a callback here happens to add new ready handlers,
                // the docReady() function will see that it already fired
                // and will schedule the callback to run right after
                // this event loop finishes so all handlers will still execute
                // in order and no new ones will be added to the readyList
                // while we are processing the list
                readyList[i].fn.call(window, readyList[i].ctx);
            }
            // allow any closures held by these functions to free
            readyList = [];
        }
    }

    function readyStateChange() {
        if ( document.readyState === "complete" ) {
            ready();
        }
    }

    // This is the one public interface
    // docReady(fn, context);
    // the context argument is optional - if present, it will be passed
    // as an argument to the callback
    baseObj[funcName] = function(callback, context) {
        if (typeof callback !== "function") {
            throw new TypeError("callback for docReady(fn) must be a function");
        }
        // if ready has already fired, then just schedule the callback
        // to fire asynchronously, but right away
        if (readyFired) {
            setTimeout(function() {callback(context);}, 1);
            return;
        } else {
            // add the function and context to the list
            readyList.push({fn: callback, ctx: context});
        }
        // if document already ready to go, schedule the ready function to run
        if (document.readyState === "complete") {
            setTimeout(ready, 1);
        } else if (!readyEventHandlersInstalled) {
            // otherwise if we don't have event handlers installed, install them
            if (document.addEventListener) {
                // first choice is DOMContentLoaded event
                document.addEventListener("DOMContentLoaded", ready, false);
                // backup is window load event
                window.addEventListener("load", ready, false);
            } else {
                // must be IE
                document.attachEvent("onreadystatechange", readyStateChange);
                window.attachEvent("onload", ready);
            }
            readyEventHandlersInstalled = true;
        }
    }
})("docReady", window);

function isEmpty(str) {
    return (!str || 0 === str.length);
}

function copyTextInput(textInputElement) {
    textInputElement.select();
    document.execCommand('copy');
}

function htmlDecode(str) {
    var parser = new DOMParser;
    var dec = parser.parseFromString('<!DOCTYPE html><body>'+str, 'text/html').body.textContent;

    return dec;
}

function charCountOut() {
    var charsLeftElement = document.querySelector('#charsLeftVal');
    var maxChars = ninjaMsgInput.getAttribute('maxlength');

    charsLeftElement.innerHTML = maxChars - ninjaMsgInput.value.length;
}

function encryptNinjaMessage() {
    var encJSON = sjcl.encrypt( passInput.value, ninjaMsgInput.value );
    var enc = JSON.parse(encJSON).ct;

    if ( enc.length > ninjaMsgInput.getAttribute('maxlength') ) alert('Die Verschlüsselte Nachricht ist zu lang! Bitte kürze deine Originalnachricht.');
    else {
        ninjaMsgInput.value = enc;
        charCountOut();

        isEncrypted.value = "true";
        fullEncMsg.value = encJSON;
        
        ninjaMsgInput.readOnly = true;
        passInput.disabled = true;
        passCheckInput.disabled = true;
        encryptBtn.disabled = true;
        decryptBtn.disabled = false;
    }
}

function decryptNinjaMessage() {
    var encJSON = fullEncMsg.value;
    var decr = sjcl.decrypt( passInput.value, encJSON );

    ninjaMsgInput.value = decr;
    charCountOut();

    isEncrypted.value = "false";
    fullEncMsg.value = "";

    ninjaMsgInput.readOnly = false;
    passInput.disabled = false;
    passCheckInput.disabled = false;
    encryptBtn.disabled = false;
    decryptBtn.disabled = true;
}

function decryptViewNinjaMessage() {
    try {
        var encBase64Json = payloadH.value;
        var decr = sjcl.decrypt( passwordTryInput.value, htmlDecode(atob(encBase64Json)) );
    
        messageViewTA.value = htmlDecode(decr);
    } catch (err) {
        alert('Wagst du es etwa ein falsches Passwort zu verwenden? So geht das aber nicht!');
    }
}

function checkPass() {
    if (!isEmpty(passInput.value.trim()) && !isEmpty(passCheckInput.value.trim()) && passInput.value === passCheckInput.value &&
        !isEmpty(ninjaMsgInput.value.trim())) encryptBtn.disabled = false;
    else encryptBtn.disabled = true;
}

function checkTryPass() {
    if (!isEmpty(passwordTryInput.value.trim())) decryptTryBtn.disabled = false;
    else decryptTryBtn.disabled = true;
}

function checkSdMode() {
    if (selfDestructModeSel.value == 'afterRead') showTimeLeftCB.disabled = true;
    else showTimeLeftCB.disabled = false;
}
