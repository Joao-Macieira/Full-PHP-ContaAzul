<h1>Editar Aula</h1>

<form method="post">

    Título da aula: <br>
    <input type="text" name="nome" value="<?php echo $aula['nome']; ?>"><br><br>

    Descrição da aula: <br>
    <textarea name="descricao"><?php echo $aula['descricao']; ?></textarea><br><br>

    URL do vídeo: <br>
    <input type="text" name="url" value="<?php echo $aula['url']; ?>"><br><br>

    <input type="submit" value="Salvar">
</form>