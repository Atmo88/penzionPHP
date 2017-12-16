// pockame si az se nacte cela stranka
$(document).ready(function () {
    $('#chatform').submit(function (udalost) {

        console.log(udalost);

        // zrusime udalost odeslani formulare, aby nedoslo k odeslani klasickou cestou

        udalost.preventDefault();

        // vezmeme zpravu co je tam napsana a odesleme samy na server pomoci ajaxu
        var zprava = $('#chatform textarea'/*nebo [name=prispevek]*/).val();

        $.ajax({
            "method": "POST",
            "url": "chat_pridat_zpravu.php",
            "data": {
                "prispevek": zprava
            }
        }).done(function(){
            // promazeme napsanou zpravu
            $('[name=prispevek]').val("");
        })
    })
});

// kontrola novych zprav

function Kontrolor(posledniID) {
    this.posledniID = posledniID;
    alert("Jdu to hidat od id: " + this.posledniID);

    // nastartujeme kontrolovani
    this.zkontrolujNoveZpravy();
}

Kontrolor.prototype.zkontrolujNoveZpravy = function () {
    var self = this;
    $.ajax({
        "url": "chat_nove_zpravy.php",
        "data": {
            "id": this.posledniID
        }
    }).done(function (vysledek) {
        console.log(vysledek);

        // abychom kontrolovali zpravy periodicky, nechame si zavolat tuto funkci znovu za 1 vterinu
        setTimeout(function () {
            self.zkontrolujNoveZpravy();
        }, 1000);
        
        // vezmeme zpravy z vysledku a prihodime je do vypisu
        
        for (var index in vysledek){
            var zprava = vysledek[index];
            $('#zpravy').prepend(
                    "<div>"
                    + zprava.cas + " "
                    + zprava.nick + " "
                    + zprava.zprava + "</div>"
                );
                // soupnout se s poslednim ideckem dal
                self.posledniID = zprava.id;
        }
    })
}