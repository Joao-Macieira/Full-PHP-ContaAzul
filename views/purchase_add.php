<h1>Adicionar Compra</h1>

<form method="post">
    <label for="user_email">Nome do Comprador</label><br>
    <input type="hidden" name="id_user">
    <input type="text" name="user_email" id="user_email" data-type = "search_users" value ="<?php echo $user_email; ?>" disabled = 'disabled'>
    <br><br>

    <label for="total_price">Preço da Compra</label>
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
    <input type="submit" value="Comprar">
</form>