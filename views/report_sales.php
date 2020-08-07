<h1>Relatório de Vendas</h1>

<form method="get" onsubmit="return openPopupSales(this)">
    <div class="report-grid-4">
        Nome do Cliente: <br>
        <input type="text" name="client_name">
    </div>
    <div class="report-grid-4">
        Período: <br>
        <input type="date" name="period1"><br>
        Até <br>
        <input type="date" name="period2">
    </div>
    <div class="report-grid-4">
        Status da Venda: <br>
        <select name="status">
            <option value="">Todos os status</option>
            <?php foreach($statuses as $statuskey => $statusvalue): ?>
                <option value="<?php echo $statuskey; ?>"><?php echo $statusvalue; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="report-grid-4">
        Ordenação: <br>
        <select name="order">
            <option value="date_desc">Mais Recente</option>
            <option value="date_asc">Mais Antigo</option>
            <option value="status">Status da Venda</option>
        </select>
    </div>

    <div style="clear:both;"></div>
    <div style="text-align: center;">
        <input type="submit" value="Gerar Relatório">
    </div>
</form>