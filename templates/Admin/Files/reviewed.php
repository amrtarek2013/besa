<script src="<?=ADMIN_ASSETS?>/custom_helper/jquery-2.2.4.min.js"></script>
<link rel="stylesheet" href="<?=ADMIN_ASSETS?>/custom_helper/style.css?v=2">


<div class="content-wrapper">

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?=__('Reviewed Files')?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?=ADMIN_LINK?>"><?=__('Home')?></a></li>
                    <li class="breadcrumb-item active"><?=__('Reviewed Files')?></li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                    
                <div class="card">
                    <?php
                        $session = $this->getRequest()->getSession();
                        echo $this->List->filter_form($files, $filters, [], [], $parameters, $session);
                    ?>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?=__('Reviewed Files')?></h3>
                        <!-- <a class="add-new-btn btn btn-primary <?=$currLang=='en'?'float-right':'float-left'?>" href="<?=ADMIN_LINK?>/admins/add">
                            <?=__('Add new')?>
                        </a> -->
                    </div>

                    <?php
                        $fields = [
                            'basicModel' => 'Files',
                            'id' => [],
                            'file' => ['title' => __('File Name')],
                            'status' => ['title' => __('Last Status'),'format'=>'get_from_array','options' => ['items_list' => $status_labels]],
                            // 'created' => [],
                            // 'active' => ['format' => 'bool']
                        ];

                        $multi_select_actions = array(
                            'delete' => array('action' => $this->Url->build(array('action' => 'delete_multi', 'Admin' => true)), 'confirm' => true)
                        );

                        $actions = [
                            'logs' => $this->Html->link('Logs', array('action' => 'logs', '%id%'), array('class' => 'btn btn-info btn-sm', 'icon' => 'fas fa-pencil-alt')),
                        ];
                        echo $this->List->adminIndex($fields, $files, $actions, false, $multi_select_actions, $parameters);
                    ?>
                </div>


            </div>
        </div>
    </div>
</section>

</div>







