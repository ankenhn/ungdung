<fieldset>
    <div class="fluid">
        <div class="widget">
            <div class="whead"><h6><?php echo $toolbar_title ?></h6><div class="clear"></div></div>
            <table width="100%" class="tDefault">
                <thead>
                <tr>
                    <td><?php echo lang('Permission');?></th>
                        <?php foreach($matrix_roles as $matrix_role ) : ?>
                        <?php $matrix_role = (array)$matrix_role; ?>
                        <?php if (has_permission('Site.'.$matrix_role['role_name'].'.Manage')) : ?>
                    <td  class="text-center"><?php echo $matrix_role['role_name']; ?></th>
                        <?php endif; ?>
                        <?php $cols[] = array('role_id' => $matrix_role['role_id'], 'role_name' => $matrix_role['role_name']); ?>
                        <?php endforeach; ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach($matrix_permissions as $matrix_perm ) : ?>
                    <?php $matrix_perm = (array)$matrix_perm; ?>

                    <?php if (has_permission($matrix_perm['name']) || $current_user->role_id == 1): //Admin?>
                        <tr title="<?php echo $matrix_perm['name']; ?>">
                            <td><strong><?php echo $matrix_perm['name']; ?></strong></td>
                            <?php
                            for($i=0;$i<count($cols);$i++) :
                                if (has_permission('Site.'.$cols[$i]['role_name'].'.Manage')) :
                                    $checkbox_value = $cols[$i]['role_id'].','.$matrix_perm['permission_id'];
                                    $checked = in_array($checkbox_value, $matrix_role_permissions) ? ' checked="checked"' : '';
                                    ?>
                                    <td class="text-center" title="<?php echo $cols[$i]['role_name']; ?>">
                                        <input type="checkbox" value="<?php echo $checkbox_value; ?>"<?php echo $checked; ?> title="<?php echo lang('Role');?>: <?php echo $cols[$i]['role_name']; ?>, <?php echo lang('Permission');?>: <?php echo $matrix_perm['name']; ?>" />
                                    </td>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </tr>
                    <?php endif; ?>

                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

</fieldset>