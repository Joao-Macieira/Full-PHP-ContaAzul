<h1>Alunos</h1>

<a href="<?php echo BASE_URL; ?>alunos/adicionar">Adicionar Aluno</a>
<br><br>
<table border="0" width = '100%'>
    <tr>
        <th>Nome</th>
        <th>Qt. de Cursos</th>
        <th>Ações</th>
    </tr>
    <?php foreach($alunos as $aluno): ?>
        <tr>
            <td width = "45%"><?php echo $aluno['nome']; ?></td>
            <td width = "25%" align="center"><?php echo $aluno['qtcursos']; ?></td>
            <td>
                <a href="<?php echo BASE_URL; ?>alunos/editar/<?php echo $aluno['id']; ?>">  Editar Aluno  </a> - 
                <a href="<?php echo BASE_URL; ?>alunos/excluir/<?php echo $aluno['id']; ?>" onclick="return confirm('Deseja realmente excluir este curso ?');">  Excluir Aluno  </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>