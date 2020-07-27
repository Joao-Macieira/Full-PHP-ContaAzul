<h1>Permissões</h1>

<div class = "tabarea">
    <div class = "tabitem activetab">
        Grupos de Permissões
    </div>
    <div class = "tabitem">
        Permissões
    </div>
</div>
<div class="tabcontent">
    <div class = "tabbody">
    <a href="<?php echo BASE_URL; ?>permissions/add_group"><div class='button'>Adicionar Grupo</div></a>
        <table border = '0' width = "100%">
            <tr>
                <th>Grupo</th>
                <th>
                    Ações
                </th>
            </tr>

            <?php foreach($permission_groups_list as $p):?>
                <tr>
                    <td><?php echo $p['name']; ?></td>
                    <td width = '160'>
                        <div class='button button_small'><a href="<?php echo BASE_URL; ?>permissions/edit_group/<?php echo $p['id']; ?>">Editar</a></div>
                        <div class='button button_excluir'><a href="<?php echo BASE_URL; ?>permissions/delete_group/<?php echo $p['id']; ?>" onclick="return confirm('Deseja realmnte excluir este grupo ?');" >Excluir</a></div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class = "tabbody">

    <a href="<?php echo BASE_URL; ?>permissions/add"><div class='button'>Adicionar Permissão</div></a>
        <table border = '0' width = "100%">
            <tr>
                <th>Permissão</th>
                <th>
                    Ações
                </th>
            </tr>

            <?php foreach($permission_list as $p):?>
                <tr>
                    <td><?php echo $p['name']; ?></td>
                    <td width = '50'><div class='button button_excluir'><a href="<?php echo BASE_URL; ?>permissions/delete/<?php echo $p['id']; ?>" onclick="return confirm('Deseja realmnte excluir esta permissão ?');" >Excluir</a></div></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>