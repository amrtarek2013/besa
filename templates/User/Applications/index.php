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
                <h2 class="title text-left title-dash">Applications</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="container-formBox">
                    <h4 class="title">Applications</h4>
                    <div class="">
                        <?php

                        $fields = [
                            'basicModel' => 'applications',
                            'id' => [],
                            // 'user.email' => ['title' => 'User'],
                            'university.title' => ['title' => 'University'],
                            'service.title' => ['title' => 'Service'],

                            'status' => ['format' => 'get_from_array', 'options' => ['items_list' => $statusesBtns]],
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


                        echo $this->List->adminIndex($fields, $applications, $actions, false, $multi_select_actions, $parameters);
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>