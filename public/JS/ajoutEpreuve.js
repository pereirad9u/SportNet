/**
 * Created by debian on 15/11/16.
 */
var nb = 1;
$(".ajoutEpreuve").on("click", function () {
    nb++;
    $(".ajoutEpreuve").parent().before("<div class=\"card-panel\"> <h5> Epreuve " + nb + "</h5> <div class=\"row\"> <div class=\"input-field span-5\"> <p>Nom de l'épreuve</p> <input id=\"nom\" name=\"nom"+nb+"\" aria-required=\"true\" type=\"text\" placeholder=\"Nom épreuve\" required class=\"validate\"> <label for=\"nom\" data-error=\"Champ obligatoire\"></label> </div> <div class=\"input-field span-5 offset-2\"> <p>Date de l'épreuve</p> <input id=\"date\" name=\"date"+nb+"\" type=\"date\" placeholder=\"06/12/2016\" required class=\"validate datepicker\"> <label for=\"date\" data-error=\"Champ obligatoire\"></label> </div> </div> <div class=\"row\"> <div class=\"span-12\"> <p>Description</p> <textarea class=\"materialize-textarea\" name=\"description"+nb+"\" required></textarea> </div> </div> <div class=\"row\"> <div class=\"input-field span-5\"> <p>Nom de la discipline</p> <input id=\"discipline\" name=\"discipline"+nb+"\" aria-required=\"true\" type=\"text\" placeholder=\"discipline\" required class=\"validate\"> <label for=\"discipline\" data-error=\"Champ obligatoire\"></label> </div> </div> <div class=\"row\"> <div class=\"input-field span-5\"> <p>Nombre de participant maximum :</p> <input id=\"nbParticipant\" name=\"nbParticipant"+nb+"\" type=\"number\" placeholder=\"5555\" required class=\"validate\"> <label for=\"nbParticipant\" data-error=\"Champ obligatoire\"></label> </div> <div class=\"input-field span-5 offset-2\"> <p>Prix :</p> <input id=\"prix\" name=\"prix"+nb+"\" type=\"number\" placeholder=\"10\" required class=\"validate\"> <label for=\"prix\" data-error=\"Champ obligatoire\"></label> </div> </div> <div class=\"row\"> <div class=\"span-12\"> <p>ajouter une photo :</p> <div class=\"file-field input-field\"> <div class=\"btn teal\"> <span>A pic !</span> <input type=\"file\" name=\"image"+nb+"\" accept=\"image/*\"> </div> <div class=\"file-path-wrapper\"> <input required=\"\" class=\"file-path validate\" type=\"text\" name=\"path_img"+nb+"\"> </div> </div> </div> </div> </div>");
})

$(".ajoutEpreuve").on("click", function() {
    $("#prix").each(function(){
        $(this).val(parseFloat($(this).val()));
    })
})