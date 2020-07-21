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
    <h1>Questionário</h1>
    <?php
        if($_SESSION["poll".$aula_info['id_aula']] > 2) {
            echo "Você atingiu o limite de tentativas";

        } else {
            echo "Tentativa: ".$_SESSION["poll".$aula_info['id_aula']]." de 2";
        
    ?>

    <h3><?php echo $aula_info['pergunta']; ?></h3>
    <form method="post">
        <input type="radio" name="opcao" value="1" id="opcao1">
        <label for="opcao1"><?php echo $aula_info['opcao1']; ?></label><br><br>

        <input type="radio" name="opcao" value="2" id="opcao2">
        <label for="opcao2"><?php echo $aula_info['opcao2']; ?></label><br><br>

        <input type="radio" name="opcao" value="3" id="opcao3">
        <label for="opcao3"><?php echo $aula_info['opcao3']; ?></label><br><br>

        <input type="radio" name="opcao" value="4" id="opcao4">
        <label for="opcao4"><?php echo $aula_info['opcao4']; ?></label><br><br>

        <input type="radio" name="opcao" value="5" id="opcao5">
        <label for="opcao5"><?php echo $aula_info['opcao5']; ?></label><br><br>

        <input type="submit" value="Enviar Respostas">
    </form><br><br>
    <?php
        if(isset($resposta)){
            if($resposta === true) {
                echo "Resposta Correta";
            } else {
                echo "Resposta Incorreta";
            }
        } 
    ?>
<?php } ?>
</div>