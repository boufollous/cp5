/**
 * 
 */
document.querySelector('#register form').addEventListener(
    'submit',
    function (evt) {
        let pass1 = document.getElementById('pass1').value;
        let pass2 = document.getElementById('pass2').value;
        if (pass1 !== pass2) {
            evt.preventDefault();
            alert('Les mots de passe ne correspondent pas.');
        }
    }
);