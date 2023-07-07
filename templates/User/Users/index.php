<section class="content listSection container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card-header">
                <h3 class="card-title">List</h3>
            </div>
            <?php if ($filters) { ?>
                <div class="card">
                    <?php
                    $session = $this->getRequest()->getSession();
                    echo $this->List->filter_form($users, $filters, [], [], $parameters, $session) ?>
                </div>
            <?php } ?>
            <a href="<?= $this->Url->build(array('action' => 'add', 'Admin' => true)) ?>" class="btn btn-info btn-flat" icon="fas fa-pencil-alt"><i class="fa fa-plus"></i> Add New</a>

            <div class="card card-primary">

                <?php

                $fields = [
                    'basicModel' => 'users',
                    'first_name' => [],
                    'last_name' => [],
                    'email' => [],
                    'username' => [],
                    'display_order' => [],
                    'active' => ['format' => 'bool']
                ];

                $multi_select_actions = array(
                    'delete' => array('action' => $this->Url->build(array('action' => 'delete_multi', 'Admin' => true)), 'confirm' => true)
                );

                

                $actions = [
                    // 'view' => $this->Html->link(__('Manage work days'), ['action' => 'workTimes', '%id%'], array('class' => 'btn btn-primary btn-flat', 'icon' => 'fas fa-binoculars')),

                    'edit' => $this->Html->link('Edit', array('action' => 'edit', '%id%'), array('class' => 'btn btn-info btn-flat', 'icon' => 'fas fa-pencil-alt')),
                    'delete' => $this->Html->link(
                        'Delete',
                        ['action' => 'delete', '%id%'],
                        [
                            'confirm' => 'Are you sure you wish to delete this?',
                            'class' => 'btn btn-danger btn-flat', 'icon' => 'fas fa-trash'
                        ]
                    ),
                ];



                echo $this->List->adminIndex($fields, $users, $actions, true, $multi_select_actions, $parameters);
                $url_query = [];
                if (isset($parameters['?'])) {
                    $url_query = $parameters['?'];
                }

                ?>

                <h3 class="more_option">
                    <a onclick="
document.getElementById('sms_sender').style.display = 'none';
document.getElementById('email_sender').style.display = 'none';
document.getElementById('exporter').style.display = 'block';
document.getElementById('unsubscriber').style.display = 'none';
" href="javascript:void(0)">
                        Export to csv</a><a></a>
                </h3>
                <div style="display: block;" id="exporter" class="more_option_box">
                    <form action="<?php echo Cake\Routing\Router::url(array('controller' => "users", 'action' => 'export', '?' => $url_query)) ?>" method="get">
                        Delimited:
                        <select name="delimited">
                            <option value="comma">Comma ( , )</option>
                            <option value="tab">Tab</option>
                            <option value="semi">Semicolon(;)</option>
                        </select>
                        <?php

                        // dd($url_query);
                        foreach ($url_query as $key => $value) :

                        ?>

                            <input type="hidden" value="<?php echo $value ?>" name="<?php echo $key ?>">

                        <?php endforeach; ?>
                        <input value="Dump CSV File" type="submit">
                    </form>
                </div>

                <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>

            </div>
        </div>
    </div>
</section>
