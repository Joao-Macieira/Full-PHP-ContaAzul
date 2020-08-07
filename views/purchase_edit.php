<h1>Visualizar Venda</h1>

<strong>Nome do Usuário:</strong><br>
<?php echo $user_email; ?><br><br>

<strong>Data da Venda:</strong><br>
<?php echo date('d/m/Y', strtotime($purchase_info['info']['date_purchase'])); ?><br><br>

<strong>Valor Total da Venda:</strong><br>
<?php echo number_format($purchase_info['info']['total_price'], 2, ',', '.'); ?><br><br>


<hr>

<table border="0" width='100%'>
    <tr>
        <th>Produto</th>
        <th>Quantidade</th>
        <th>Preço Unitário</th>
        <th>Preço Total</th>
    </tr>
    <?php foreach($purchase_info['products'] as $productitem): ?>
        <tr>
            <td><?php echo $productitem['name']; ?></td>
            <td><?php echo $productitem['quant']; ?></td>
            <td>R$ <?php echo number_format($productitem['purchase_price'], 2, ',', '.'); ?></td>
            <td>R$ <?php echo number_format($productitem['purchase_price'] *  $productitem['quant'], 2, ',', '.'); ?></td>
        </tr>
    <?php endforeach; ?>
</table>