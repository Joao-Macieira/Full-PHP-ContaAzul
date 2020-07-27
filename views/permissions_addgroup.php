<h1>Adicionar Grupo</h1>

<form method="post">

    <label for="name">Novo Grupo</label><br>
    <input type="text" name="name"><br><br>

    <label><h3>Permissões disponíveis</h3></label>
    <?php foreach($permission_list as $p): ?>
        <div class='p_item'>
            <input type="checkbox" name="permissions[]" value="<?php echo $p['id']; ?>" id = 'p_<?php echo $p['id']; ?>'>
            <label for="p_<?php echo $p['id']; ?>"><?php echo $p['name']; ?></label><br>
        </div>
    <?php endforeach; ?>
    <br><br>

    <input type="submit" value="Adicionar">

</form>