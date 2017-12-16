$(document).ready(function(){
    $(".menu ul").sortable({
        "update" : function () {
            var poradi = $(".menu ul").sortable('toArray', {
                "attribute" : "data-stranka-id"
            })
            console.log(poradi);
            
            $.ajax({
                "url" : "admin.php",
                "data" : {
                    "akce" : "nastavPoradi",
                    "poradi" : poradi
                }
            })
        }
    });
});