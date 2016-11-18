/**
 * Created by debian on 18/11/16.
 */



var id ='';

$('.updateInscription').click(function(){


    // requete Ajax en utilisant la variable id
    if(this.id.match('^closeInscription')){
         id = this.id.substring(17);

        this.id='openInscription_'+id;
        $(this).text('Ouvrir Inscription')
        $.post('/ajax/closeInscription',{id : id},null,'json')
            .done(function (data) {

            })
            .fail(function(data){

            })

    }else{
         id = this.id.substring(16);
        this.id='closeInscription_'+id;
        $(this).text('Fermer Inscription')

        $.post('/ajax/openInscription',{id : id},null,'json')
            .done(function (data) {

            })
            .fail(function(data){

            })
    }



});