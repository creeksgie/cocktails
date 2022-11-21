
$('.btn').on('click', function() {
    var btn = $(this);
    var svg = btn.find("img");
    var indice = (this.id);
    if (svg.attr("src").match("coeurvide.svg")) {
        svg.attr("src", "../svg/coeurplein.svg");
    } else {
        svg.attr("src", "../svg/coeurvide.svg");
    }
    $.ajax({
        url: 'like.php',
        data: {
            indice: indice,
        }
    }); 
    if (document.getElementById("like") !=null && document.getElementById("like").id == "like") {     //Si on ce trouve sur la page affichant les recettes likées
        location.reload();                                                                            //On recharge la page
    }
});