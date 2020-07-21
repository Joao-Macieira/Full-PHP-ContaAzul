<h1>Editar Aluno</h1>

<form method="post">
    Nome do Aluno: <br>
    <input type="text" name="nome" value="<?php echo $aluno['nome']; ?>"><br><br>

    Email do Aluno: <br>
    <input type="email" name="email" value="<?php echo $aluno['email']; ?>"><br><br>

    Nova Senha: <br>
    <input type="password" name="senha"><br><br>

    Curso Matriculados: (Segure CTRL para selecionar outros cursos)<br>

        <?php foreach ($cursos as $curso): ?>
            <input type="checkbox" name="cursos[]" value="<?php echo $curso['id']; ?>" 
                <?php 
                    if(in_array($curso['id'], $inscrito)) {
                        echo 'checked="checked"';
                    }
                ?>> <?php echo $curso['nome']; ?> <br>
        <?php endforeach; ?>

    <input type="submit" value="Editar informações">
</form>