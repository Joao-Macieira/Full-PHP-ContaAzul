<h1>Editar Vendas</h1>

<strong>Nome do Cliente:</strong><br>
<?php echo $sales_info['info']['client_name']; ?><br><br>

<strong>Data da Venda:</strong><br>
<?php echo date('d/m/Y', strtotime($sales_info['info']['date_sale'])); ?><br><br>

<strong>Valor Total da Venda:</strong><br>
<?php echo number_format($sales_info['info']['total_price'], 2, ',', '.'); ?><br><br>

<strong>Status da Venda</strong><br>

<?php if($permission_edit): ?>
    <form method="post">
        <select name="status">
            <?php foreach($statuses as $statusKey => $statusValue): ?>
                <option value="<?php echo $statusKey ?>" <?php echo ($statusKey == $sales_info['info']['status'])?'selected = selected':''; ?>><?php echo $statusValue ?></option>
            <?php endforeach; ?>
        </select><br><br>
        <input type="submit" value="Salvar">
    </form>
<?php else: ?>
    <?php echo $statuses[$sales_info['info']['status']]; ?>
<?php endif; ?>
<br><br>
<hr>

<table border="0" width='100%'>
    <tr>
        <th>Produto</th>
        <th>Quantidade</th>
        <th>Preço Unitário</th>
        <th>Preço Total</th>
    </tr>
    <?php foreach($sales_info['products'] as $productitem): ?>
        <tr>
            <td><?php echo $productitem['name']; ?></td>
            <td><?php echo $productitem['quant']; ?></td>
            <td>R$ <?php echo number_format($productitem['sale_price'], 2, ',', '.'); ?></td>
            <td>R$ <?php echo number_format($productitem['sale_price'] *  $productitem['quant'], 2, ',', '.'); ?></td>
        </tr>
    <?php endforeach; ?>
</table>