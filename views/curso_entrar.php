<div class="cursoinfo">
    <img src="<?php BASE_URL?>/assets/images/cursos/<?php echo $curso->getImagem(); ?>" height="60">

    <h3><?php echo $curso->getNome();?></h3>
    <p><?php echo $curso->getDescricao(); ?></p>
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
                </div>
            </a>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>

<div class="curso_rigth">

</div>