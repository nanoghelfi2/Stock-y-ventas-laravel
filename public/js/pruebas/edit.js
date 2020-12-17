$(function(){
    $('#select-marca').keyup(onSelectProjectChange); //Cuando el select de ID selec-project cambie, se ejecute la funcion onSelectProjectChange
});

function onSelectProjectChange(){
    var project_id = $(this).val();

    //AJAX
    const newLocal = '/wonderlist/pruebas/'+project_id+'/tipos';
    $.get(newLocal, function(data){
        var html_select = '<option value=""> Seleccione un tipo </option>' // Esto se imprime en nuestro wonderlist.blade.php
        for (let i = 0; i < data.length; i++)
            html_select += '<option value="'+data[i].id+'">'+data[i].tipo+'</option>'
        $('#select-tipo').html(html_select); 
    });
}



