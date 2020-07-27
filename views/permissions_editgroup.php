<h1>Editar Grupo</h1>

<form method="post">

    <label for="name">Grupo</label><br>
    <input type="text" name="name" value="<?php echo $group_info['name']; ?>"><br><br>

    <label><h3>Permissões disponíveis</h3></label>
    <?php foreach($permission_list as $p): ?>
        <div class='p_item'>
            <input type="checkbox" name="permissions[]" value="<?php echo $p['id']; ?>" id = 'p_<?php echo $p['id']; ?>' <?php echo (in_array($p['id'], $group_info['params']))?'checked = checked':''; ?>>
            <label for="p_<?php echo $p['id']; ?>"><?php echo $p['name']; ?></label><br>
        </div>
    <?php endforeach; ?>
    <br><br>

    <input type="submit" value="Editar">

</form>