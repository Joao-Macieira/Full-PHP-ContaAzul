<h1>Compras</h1>
<?php if($add_permission): ?>
    <a href="<?php echo BASE_URL; ?>purchase/add"><div class='button'>Adicionar Compra</div></a>
<?php endif; ?>

<table border="0" width = '100%'>
    <tr>
        <th>Nome do Usuário</th>
        <th>Data</th>
        <th>Valor</th>
        <th>Ações</th>
    </tr>

    <?php foreach($purchase_list as $purchase_item): ?>
        <tr>
            <td><?php echo $purchase_item['email']; ?></td>
            <td><?php echo date('d/m/Y', strtotime($purchase_item['date_purchase'])); ?></td>
            <td>R$ <?php echo number_format($purchase_item['total_price'], 2, ',', '.'); ?></td>
            <td width = '80'>
                <div class='button button_small'><a href="<?php echo BASE_URL; ?>purchase/edit/<?php echo $purchase_item['id']; ?>">Editar</a></div>
            </td>
        </tr>
    <?php endforeach; ?>

</table>