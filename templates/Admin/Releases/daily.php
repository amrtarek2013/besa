<script src="<?=ADMIN_ASSETS?>/custom_helper/jquery-2.2.4.min.js"></script>
<link rel="stylesheet" href="<?=ADMIN_ASSETS?>/custom_helper/style.css?v=2">


<div class="content-wrapper">

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?=__('Daily Releases')?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?=ADMIN_LINK?>"><?=__('Home')?></a></li>
                    <li class="breadcrumb-item active"><?=__('Daily Releases')?></li>
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
                        echo $this->List->filter_form($releases, $filters, [], [], $parameters, $session);
                    ?>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?=__('Daily Releases')?></h3>
                        
                    </div>

                    <?php
                        $fields = [
                            'basicModel' => 'Releases',
                            'id' => [],
                            'zip_file' => ['title' => 'File Name'],
                            'created' => [/*'title' => 'File Name'*/],
                            // 'active' => ['format' => 'bool']
                        ];

                        $multi_select_actions = array(
                            'delete' => array('action' => $this->Url->build(array('action' => 'delete_multi', 'Admin' => true)), 'confirm' => true)
                        );

                        $actions = [
                            'downloadFiles' => $this->Html->link(__('Download Files'), array('action' => 'download', '%id%'), array('class' => 'btn btn-success btn-sm', 'icon' => 'fas fa-pencil-alt')),
                            'downloadAnnotations' => $this->Html->link(__('Download Annotations'), array('action' => 'downloadAnnotations', '%id%','daily'), array('class' => 'btn btn-dark btn-sm', 'icon' => 'fas fa-pencil-alt')),
                        ];
                        echo $this->List->adminIndex($fields, $releases, $actions, false, $multi_select_actions, $parameters);
                    ?>
                </div>


            </div>
        </div>
    </div>
</section>

</div>
<script type="text/javascript">
    $("#Roles_1").find(".btn-danger").remove();
</script>










