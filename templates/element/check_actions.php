<?php


if (isset($permissionList['universities.edit'])) {
    $actions['edit'] = $this->Html->link(__('Edit'), array('action' => 'edit', '%id%'), array('class' => 'btn btn-info btn-sm', 'icon' => 'fas fa-pencil-alt'));
}
if (isset($permissionList['universities.delete'])) {
    $actions['delete'] = $this->Html->link(

        __('Delete'),
        ['action' => 'delete', '%id%'],
        [
            'confirm' => 'Are you sure you wish to delete this?',
            'class' => 'btn btn-danger btn-sm', 'icon' => 'fas fa-trash'
        ]
    );
}
?>