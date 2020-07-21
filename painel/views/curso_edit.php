<h1>Editar curso</h1>
<form method="post" enctype="multipart/form-data">
    Nome do Curso: <br>
    <input type="text" name="nome" value="<?php echo $curso['nome']; ?>"><br><br>

    Descrição: <br>
    <textarea name="descricao"><?php echo $curso['descricao']; ?></textarea><br><br>

    Imagem: <br>
    <input type="file" name="imagem"><br><br>
    <img src="<?php echo BASE_URL; ?>../assets/images/cursos/<?php echo $curso['imagem']; ?>" height="80">

    <br><br>
    <input type="submit" value="Salvar">
</form>

<hr>

<h2>Aulas</h2>

<fieldset>
    <legend><strong>Adicionar módulo novo</strong></legend>
    <form method="post">
        Nome do módulo: <br>
        <input type="text" name="modulo"><br><br>
        <input type="submit" value="Adicionar módulo">
    </form>
</fieldset>
<br>

<fieldset>
    <legend><strong>Adicionar Aula Nova</strong></legend>
    <form method="post">
        Título da aula: <br>
        <input type="text" name="aula"><br><br>

        Módulo da aula: <br>
        <select name="moduloaula">
            <?php foreach ($modulos as $modulo): ?>
                <option value="<?php echo $modulo['id']; ?>"><?php echo $modulo['nome']; ?></option>  
            <?php endforeach; ?>
        </select><br><br>

        Tipo da Aula: <br>
        <select name="tipo">
            <option value="video">Vídeo</option>
            <option value="poll">Questionário</option>
        </select><br><br>

        <input type="submit" value="Adicionar aula">
    </form>
</fieldset>
<br>

    <?php foreach ($modulos as $modulo): ?>
        
        <h4><?php echo $modulo['nome']; ?> - 
        <a href="<?php echo BASE_URL; ?>home/edit_modulo/<?php echo $modulo['id']; ?>"><img src="<?php echo BASE_URL; ?>../assets/images/document.png" height="25"></a>
        -<a href="<?php echo BASE_URL; ?>home/del_modulo/<?php echo $modulo['id']; ?>" onclick="return confirm('Deseja realmente excluir esse módulo ?');"><img src="<?php echo BASE_URL; ?>../assets/images/trash.png" height="25"></a></h4>
        
        <?php foreach ($modulo['aulas'] as $aula): ?>
            <h5><?php echo $aula['nome']; ?> - <a href="<?php echo BASE_URL; ?>home/edit_aula/<?php echo $aula['id']; ?>">[Editar Aula]</a> - <a href="<?php echo BASE_URL; ?>home/del_aula/<?php echo $aula['id']; ?>" onclick="return confirm('Deseja realmente excluir esta aula ?');">[Excluir aula]</a></h5>
        <?php endforeach; ?>

    <?php endforeach;?>
