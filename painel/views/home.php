<h1>Cursos</h1>

<a href="<?php echo BASE_URL; ?>home/adicionar">Adicionar Curso</a>
<br><br>
<table border="0" width = '100%'>
    <tr>
        <th>Imagem</th>
        <th>Nome</th>
        <th>Qt. de alunos</th>
        <th>Ações</th>
    </tr>
    <?php foreach($cursos as $curso): ?>
        <tr>
            <td width = "10%"><img src="/../assets/images/cursos/<?php echo $curso['imagem']; ?>" height="70"></td>
            <td width = "45%"><?php echo $curso['nome']; ?></td>
            <td width = "15%" align="center"><?php echo $curso['qtalunos']; ?></td>
            <td>
                <a href="<?php echo BASE_URL; ?>home/editar/<?php echo $curso['id']; ?>">  Editar Curso  </a> - 
                <a href="<?php echo BASE_URL; ?>home/excluir/<?php echo $curso['id']; ?>" onclick="return confirm('Deseja realmente excluir este curso ?');">  Excluir Curso  </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>