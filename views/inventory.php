<h1>Estoque</h1>
<?php if($add_permission): ?>
    <a href="<?php echo BASE_URL; ?>inventory/add"><div class='button'>Adicionar Produto</div></a>
<?php endif; ?>

<input type="text" id="search" data-type="search_inventory">

<table border="0" width='100%'>
    <tr>
        <th>Nome</th>
        <th>Preço</th>
        <th>Quantidade</th>
        <th>Quantidade Mínima</th>
        <th>Ações</th>
    </tr>
    <?php foreach($inventory_list as $product): ?>
        <tr>
            <td><?php echo $product['name']; ?></td>
            <td>R$ <?php echo number_format($product['price'], 2,',','.'); ?></td>
            <td width = '100' style="text-align: center;"><?php if($product['min_quant'] > $product['quant']){echo '<span style="color:red">'.$product['quant'].'</span>';} else { echo '<span style="color:green">'.$product['quant'].'</span>'; }?></td>
            <td width = '160' style="text-align: center;"><?php echo $product['min_quant']; ?></td>
            <td width = '160'>
                <div class='button button_small'><a href="<?php echo BASE_URL; ?>inventory/edit/<?php echo $product['id']; ?>">Editar</a></div>
                <div class='button button_excluir'><a href="<?php echo BASE_URL; ?>inventory/delete/<?php echo $product['id']; ?>" onclick="return confirm('Deseja realmnte excluir este produto ?');" >Excluir</a></div>
            </td>
        </tr>
    <?php endforeach; ?>
</table>