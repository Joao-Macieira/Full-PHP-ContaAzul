<h1>Clientes</h1>
<?php if($edit_permission): ?>
    <a href="<?php echo BASE_URL; ?>clients/add"><div class='button'>Adicionar Clientes</div></a>
<?php endif; ?>
<table border = '0' width = "100%">
    <tr>
        <th>Nome</th>
        <th>Telefone</th>
        <th>Cidade</th>
        <th>Avaliação</th>
        <th>Ações</th>
    </tr>

    <?php foreach ($clients_list as $c): ?>
        <tr>
            <td><?php echo $c['name']; ?></td>
            <td><?php echo $c['phone']; ?></td>
            <td><?php echo $c['address_city']; ?></td>
            <td width='100' style="text-align: center;"><?php echo $c['stars']; ?></td>
            <td width = '160' style="text-align: center;">
            <?php if($edit_permission): ?>
                <div class='button button_small'><a href="<?php echo BASE_URL; ?>clients/edit/<?php echo $c['id']; ?>">Editar</a></div>
                <div class='button button_excluir'><a href="<?php echo BASE_URL; ?>clients/delete/<?php echo $c['id']; ?>" onclick="return confirm('Deseja realmnte excluir este cliente ?');" >Excluir</a></div>
            <?php else: ?>
                <div class='button button_small'><a href="<?php echo BASE_URL; ?>clients/view/<?php echo $c['id']; ?>">Visualizar</a></div>
            <?php endif;?>
            </td>
        </tr>
    <?php endforeach; ?>
    
</table>