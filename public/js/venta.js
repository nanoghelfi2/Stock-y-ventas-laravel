$('.verVenta').on('click', mostrarVenta)

function mostrarVenta(){
    var id_venta = $(this).attr("id");
    var urlVenta = 'ventas/venta/'+id_venta;
    
    $.get(urlVenta, function(data){
            var modal ='';
        for (let i = 0; i < data.length; i++)
            var modal = data;
            $('#pegarData').html(modal); 
    });
}


