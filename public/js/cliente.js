$(function(){
    $('.verModal').on('click', mostrarModal)

    function mostrarModal(){
        let idCliente = $(this).val();
        let URL = '/clientes/modal/'+idCliente;
        
        $.get(URL, function(data){
            let insertHTML = data;
            $('#contenedorModal').html(insertHTML);
        });
    }

})

$('#btnAgregarCl').on('click', function(){
    $(this).addClass('d-none');
    $('#btnAgregarClRemplazo').removeClass('d-none')
});