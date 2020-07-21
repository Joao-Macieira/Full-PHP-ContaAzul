setInterval(updateArea, 100);
function updateArea() {
	var alturaTela = $(window).height();
	var posy = $('.curso_left').offset().top;
	var altura = alturaTela - posy;
    $('.curso_left, .curso_rigth').css('height', altura+'px');

	var ratio = 1920/1080;
	var video_largura = $('#video').width();

	var video_altura = video_largura / ratio;

	$('#video').css('height', video_altura+'px');

}

function marcarAssistido(obj) {

	var id = $(obj).attr("data-id");

	$(obj).remove();
	$.ajax({
		url:'/ajax/marcar_assistido/'+id
	});

}	