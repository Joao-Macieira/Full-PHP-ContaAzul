<style>
    th{
        text-align: left;
    }
</style>

<h1>Relatório de Estoque</h1>

<fieldset>
    Itens com estoque abaixo do mínimo
</fieldset>
<br>
<table border="0" width='100%'>
    <tr>
        <th>Nome</th>
        <th>Preço</th>
        <th>Quantidade</th>
        <th>Quantidade Mínima</th>
        <th>Diferença</th>
    </tr>
    <?php foreach($inventory_list as $product): ?>
        <tr>
            <td><?php echo $product['name']; ?></td>
            <td>R$ <?php echo number_format($product['price'], 2,',','.'); ?></td>
            <td width = '100'><?php if($product['min_quant'] > $product['quant']){echo '<span style="color:red">'.$product['quant'].'</span>';} else { echo '<span style="color:green">'.$product['quant'].'</span>'; }?></td>
            <td width = '160'><?php echo $product['min_quant']; ?></td>
            <td>
                <?php echo $product['dif']; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>