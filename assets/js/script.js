$(function(){

    $('.tabitem').on('click', function(){
        $('.activetab').removeClass('activetab');
        $(this).addClass('activetab');

        var item = $('.activetab').index();
        $('.tabbody').hide();
        $('.tabbody').eq(item).show();
    });
    $('.tabbody').eq(0).show();

    $('#search').on('focus', function(){
        $(this).animate({
            width: '270px'
        }, 'fast');
    });

    $('#search').on('blur', function(){
        if($(this).val() == '') {
            $(this).animate({
                width: '10px'
            }, 'fast');
        }
        setTimeout(function(){
            $('.searchresults').hide();
        }, 200);
        
    });

    $('#search').on('keyup', function(){

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
                        $('#search').after('<div class = "searchresults"></div>');
                    }

                    $('.searchresults').css('left', $('#search').offset().left+'px');
                    $('.searchresults').css('top', $('#search').offset().top+$('#search').height()+3+'px')
                    $('.searchresults').show();

                    var html = '';

                    for(var i in json) {
                        html += '<div class = "si"><a href = "'+json[i].link+'">'+json[i].name+'</a></div>';
                    }

                    $('.searchresults').html(html);


                    $('.searchresults').show();
                }   
            });
        }

    });


});