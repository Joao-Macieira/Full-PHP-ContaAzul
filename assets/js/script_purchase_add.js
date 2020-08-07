function updateSubtotal(obj) {
    var quant = $(obj).val();
    if(quant<=0) {
        $(obj).val(1);
        quant = 1;
    }
    var price = $(obj).attr('data-price');
    var subtotal = price*quant;

    $(obj).closest('tr').find('.subtotal').html('R$ '+subtotal);
    
    updateTotal();
}

function delProd(obj) {
    $(obj).closest('tr').remove();

    updateTotal();
}

function updateTotal() {
    var total = 0;

    for(var q=0;q<$('.p_quant').length;q++) {
        var quant = $('.p_quant').eq(q);

        var price = quant.attr('data-price');
        var subtotal = price*parseInt(quant.val());

        total += subtotal;
    }

    $('input[name=total_price]').val(total);

}

function addProd(obj) {
    $('#add_prod').val('');

    var id = $(obj).attr('data-id');
    var name = $(obj).attr('data-name');
    var price = $(obj).attr('data-price');

    $('.searchresults').hide();

    if($('input[name="quant['+id+']"]').length == 0){
        var tr = 
        '<tr>'+
            '<td>'+name+'</td>'+
            '<td>'+
                '<input type="number" name="quant['+id+']" class="p_quant" Value="1" onchange="updateSubtotal(this)" data-price="'+price+'"/>'+
            '</td>'+
            '<td>R$ '+price+'</td>'+
            '<td class = "subtotal">'+price+'</td>'+
            '<td><a href="javascript:;" onclick="delProd(this)">Excluir</a></td>'+
        '</tr>';

        $('#products_table').append(tr);
    }

    updateTotal();

}

$(function(){

        $('input[name=total_price]').mask('000.000.000.000.000.000,00', {reverse:true, placeholder:"0,00"});


        $('#add_prod').on('keyup', function(){

        var datatype = $(this).attr('data-type');
        var q = $(this).val();

        if(datatype != '') {
            $.ajax({
                url:BASE_URL+'ajax/'+datatype,
                type:'GET',
                data:{q:q},
                dataType:'json',
                success:function(json){
                    if($('.searchresults').length == 0) {
                        $('#add_prod').after('<div class = "searchresults"></div>');
                    }

                    $('.searchresults').css('left', $('#add_prod').offset().left+'px');
                    $('.searchresults').css('top', $('#add_prod').offset().top+$('#add_prod').height()+5+'px')
                    $('.searchresults').show();

                    var html = '';

                    for(var i in json) {
                        html += '<div class = "si"><a href = "javascript:;" onclick="addProd(this)" data-id="'+json[i].id+'" data-price = "'+json[i].price+'" data-name = "'+json[i].name+'">'+json[i].name+' - R$'+json[i].price+'</a></div>';
                    }

                    $('.searchresults').html(html);


                    $('.searchresults').show();
                }   
            });
        }
    });
});