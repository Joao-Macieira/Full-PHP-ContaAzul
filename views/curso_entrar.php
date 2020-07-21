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

</div>