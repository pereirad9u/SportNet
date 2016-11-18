$('.add_filtre').on('click', function (e) {
    e.preventDefault();
    switch ($(this).attr('id')) {
        case "date":
            $("#input_date").show();
            $('#date').hide();
            $('#suppr_date').show();
            break;
        case "lieu":
            $("#input_lieu").show();
            $('#suppr_lieu').show();
            $('#lieu').hide();
            $("input[name='lieu']").attr('value','');
            break;
        case "discipline":
            $("#input_discipline").show();
            $('#suppr_discipline').show();
            $('#discipline').hide();
            $("input[name='discipline']").attr('value','');
            break;
    }
    $(this).parent().hide();

});

$('#suppr_discipline').on('click', function (e) {
    e.preventDefault();
    $('#input_discipline').hide();
    $('#suppr_discipline').hide();
    $('#discipline').parent().show();
    $('#discipline').show();
    $("input[name='discipline']").attr('value','');


});

$('#suppr_lieu').on('click', function (e) {
    e.preventDefault();
    $('#input_lieu').hide();
    $('#suppr_lieu').hide();
    $('#lieu').parent().show();
    $('#lieu').show();
    $("input[name='lieu']").attr('value','');


});

$('#suppr_date').on('click', function (e) {
    e.preventDefault();
    $('#input_date').hide();
    $('#suppr_date').hide();
    $('#date').parent().show();
    $('#date').show();
    $("input[name='date']").attr('value','');

});