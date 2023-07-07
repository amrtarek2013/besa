<section class="content Config colConfig">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <?php
                $session = $this->getRequest()->getSession();
                echo $this->List->filter_form($snippets, $filters, [], [], $parameters, $session) ?>
            </div>
            <div class="card card-primary">
                <?php

                $fields = [
                    'basicModel' => 'snippets',
                    'id' => [],
                    'title' => [],
                    'category' => ['title' => 'Category', 'format' => 'get_from_array', 'options' => ['items_list' => $categories]],
                ];

                $multi_select_actions = array(
                    // 'delete' => array('action' => $this->Url->build(array('action' => 'delete_multi' ,'Admin' => true)), 'confirm' => true)
                );



                $actions = [
                    // 'view'=>$this->Html->link(__('View'), ['action' => 'view', '%id%'], array('class' => 'btn btn-primary btn-flat','icon'=>'fas fa-binoculars')),

                    'edit' => $this->Html->link('Edit', array('action' => 'manage', '%name%'), array('class' => 'btn btn-info btn-flat', 'icon' => 'fas fa-pencil-alt')),
                    // 'delete'=>$this->Html->link('Delete',['action' => 'delete', '%id%'],
                    //     ['confirm' => 'Are you sure you wish to delete this bookedService?',
                    //     'class'=>'btn btn-danger btn-flat','icon'=>'fas fa-trash'])
                ];



                echo $this->List->adminIndex($fields, $snippets, $actions, false, $multi_select_actions, $parameters);
                ?>
                <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
            </div>
        </div>
    </div>
</section>