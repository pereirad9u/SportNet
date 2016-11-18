
$(".ajoutMembre").on("click", function () {

    $(".ajoutMembre").before("<input type=\"email\" require=\"\" name=\"email_adherents[]\" placeholder=\"Entrer l'email du membre de votre groupe à ajouter\">")
});
