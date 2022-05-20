/**
 * fonction appelé lorsqu on change de langue dans la liste 
 */
document.getElementById('lang').addEventListener('change', 
function (){
    //step 1 :instantation 
    let xhr = new XMLHttpRequest;
    // step 2: ouverture requete AJAX 
    xhr.open('get','ajax-result.php?lang='+this.value,true);
    //step3: j envoi ma requete ajax
    xhr.send();
    // step4:attend  le retour serveur 
    xhr.addEventListener('readystatechange',
    function(){
        if((xhr.status===0 || xhr.status===200)
        && xhr.readyState===4){
            document.getElementById('pays').innerHTML=xhr.responseText;
        }
    }
    );
}
);