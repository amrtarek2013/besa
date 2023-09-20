<style>
    .btn {
        color: blueviolet;
    }

    td {
        padding: 10px;
        border: 1px solid #33ca9424;
    }
</style>

<section class="register-banner">

    <div class="container" style="width:100%">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title text-left title-dash"><?= __('Counselor Invoices List') ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="container-formBox">
                    <h4 class="title"><?= __('Counselor Invoices List') ?></h4>
                    <div class="">

                        <?= $this->element('admin_index_top_bottom_actions', ['permissionList' => $permissionList, 'parameters' => $parameters, 'current_controller' => $current_controller]) ?>

                        <?php

                        $fields = [
                            'basicModel' => 'counselorInvoices',
                            'id' => [],
                            'total_points' => [],
                            'total' => [],
                            'payment_method' => ['format' => 'get_from_array', 'options' => ['items_list' => $paymentMethods]],
                            'transaction_file' => ['format' => 'link'],

                            'created' => [],
                            'is_paid' => ['format' => 'bool'],
                            'payment_time' => [],
                        ];

                        $multi_select_actions = array(
                            // 'delete' => array('action' => $this->Url->build(array('action' => 'delete_multi', 'Admin' => true)), 'confirm' => true)
                        );


                        $actions = [
                            'view' => $this->Html->link(__('View'), ['action' => 'view', '%id%'], array('class' => 'btn btn-primary btn-flat', 'icon' => 'fas fa-binoculars')),
                            // 'edit' => $this->Html->link(__('Edit'), array('action' => 'edit', '%id%'), array('class' => 'btn btn-info btn-sm', 'icon' => 'fas fa-pencil-alt')),

                            // 'delete' => $this->Html->link(

                            //     __('Delete'),
                            //     ['action' => 'delete', '%id%'],
                            //     [
                            //         'confirm' => 'Are you sure you wish to delete this?',
                            //         'class' => 'btn btn-danger btn-sm', 'icon' => 'fas fa-trash'
                            //     ]
                            // )
                        ];


                        echo $this->List->adminIndex($fields, $counselorInvoices, $actions, false, $multi_select_actions, $parameters);
                        ?>
                        <?= $this->element('admin_index_top_bottom_actions', ['permissionList' => $permissionList, 'parameters' => $parameters, 'current_controller' => $current_controller]) ?>


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>