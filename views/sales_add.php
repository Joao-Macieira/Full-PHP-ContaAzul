<h1>Adicionar Venda</h1>

<form method="post">
    <label for="client_name">Nome do Cliente</label><br>
    <input type="hidden" name="client_id">
    <input type="text" name="client_name" id="client_name" data-type = "search_clients">
    <button class="client_add_button">+</button>
    <div style="clear: both;"></div>
    <br><br>
    <label for="status">Status</label>
    <select name="status" id="status">
        <option value="1">Aguardando Pagamento</option>
        <option value="2">Pago</option>
        <option value="3">Cancelado</option>
    </select><br><br>

    <label for="total_price">Preço da Venda</label>
    <input type="text" name="total_price" disabled = 'disabled'><br><br>

    <hr>

    <h4>Produtos</h4>

    <fieldset>
        <legend>Adicionar Produto</legend>

        <input type="text" id="add_prod" data-type="search_products">
    </fieldset>

    <table border="0" width = "100%" id="products_table">
        <tr>
            <th>Nome do produto</th>
            <th>Quantidade</th>
            <th>Preço Unitário</th>
            <th>Sub-Total</th>
            <th>Excluir</th>
        </tr>
    </table>

    <hr>
    <input type="submit" value="Adicionar Venda">
</form>