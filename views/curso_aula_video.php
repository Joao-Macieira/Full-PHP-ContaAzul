<div class="cursoinfo">
    <img src="<?php BASE_URL?>/assets/images/cursos/<?php echo $curso->getImagem(); ?>" height="60">
    <h3><?php echo $curso->getNome();?></h3>
    <?php echo $curso->getDescricao(); ?><br>
    <?php echo $aulas_assistidas.' / '.$total_aulas.'('.round((($aulas_assistidas/$total_aulas)*100),2).'%)'; ?>
</div>

<div class="curso_left">
    <?php foreach($modulos as $modulo):?>
        <div class="modulo">
            <?php echo $modulo['nome']; ?>
        </div>
        <?php foreach($modulo['aulas'] as $aula): ?>
            <a href="<?php echo BASE_URL; ?>cursos/aula/<?php echo $aula['id'] ?>">
                <div class="aula">
                    <?php echo $aula['nome']; ?>
                    <?php if($aula['assistido'] === true): ?>
                        <img style="float: right;margin-right:10px;margin-top:5px;" src="<?php echo BASE_URL; ?>assets/images/v.png" border = '0' height="20">
                    <?php endif; ?>
                </div>
            </a>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>

<div class="curso_rigth">
    <h1>Vídeo - <?php echo $aula_info['nome'];?></h1>

    <iframe id="video" src="//player.vimeo.com/video/<?php echo $aula_info['url']; ?>" width="100%" frameborder="0"></iframe>
    <br>
    <?php echo $aula_info['descricao']; ?>
    <?php if($aula_info['assistido'] == '1'): ?>
        Esta aula já foi assistida!
    <?php else: ?>
        <button onclick="marcarAssistido(this)" data-id="<?php echo $aula_info['id']; ?>">Marcar como assistido</button>
    <?php endif; ?>
    <hr>
    <h3>Dúvidas? Envie sua pergunta</h3>

    <form method="post" class="form_duvida">
        <textarea name="duvida"></textarea><br><br>
        <input type="submit" value="Enviar Dúvida">
    </form>
</div>