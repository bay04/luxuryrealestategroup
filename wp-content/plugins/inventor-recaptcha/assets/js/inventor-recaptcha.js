var recaptchaCallback = function() {
    var recaptchas = document.getElementsByClassName("g-recaptcha");

    for(var i=0; i<recaptchas.length; i++) {
        var recaptcha = recaptchas[i];
        var sitekey = recaptcha.dataset.sitekey;

        grecaptcha.render(recaptcha, {
            'sitekey' : sitekey
        });
    }
};