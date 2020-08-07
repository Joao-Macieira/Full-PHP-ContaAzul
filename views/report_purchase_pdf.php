<style>
    th{
        text-align: left;
    }
</style>

<h1>Relatório de Compra</h1>

<fieldset>
    Ordenado por data
</fieldset>
<br>

<table border="0" width = '100%'>
    <tr>
        <th>Nome do Usuário</th>
        <th>Valor</th>
        <th>Data</th>
    </tr>

    <?php foreach($purchases_list as $purchase_item): ?>
        <tr>
            <td><?php echo $purchase_item['email']; ?></td>
            <td>R$ <?php echo number_format($purchase_item['total_price'], 2, ',', '.'); ?></td>
            <td><?php echo date('d/m/Y', strtotime($purchase_item['date_purchase'])); ?></td>
        </tr>
    <?php endforeach; ?>

</table>