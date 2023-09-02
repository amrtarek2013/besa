<link rel="preload" href="<?= ADMIN_ASSETS ?>/custom_helper/jquery-2.2.4.min.js" as="script">
<link rel="preload" href="<?= ADMIN_ASSETS ?>/custom_helper/style.css?v=2" as="style">


<div class="content-wrapper">

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?=__('All Accounting')?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?=ADMIN_LINK?>"><?=__('Home')?></a></li>
                    <li class="breadcrumb-item active"><?=__('All Accounting')?></li>
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
                        echo $this->List->filter_form(null, $filters, [], ["filter_title"=>"Show Accounting data"], $parameters, $session);
                    ?>
                </div>
            <?php if(!empty($files)){ ?>
                <div class="card">
                    <div class="card-body">
                        <h5><b>Summary</b></h5>
                        <table class="table table table-striped projects">
                            <tr>
                                <th>Classification</th>
                                <th>Annotation</th>
                                <th>Review</th>
                            </tr>
                            <tr>
                                <td>Files: <?=empty($classified_files_number)?0:$classified_files_number?></td>
                                <td>Files: <?=empty($annotated_files_number)?0:$annotated_files_number?></td>
                                <td>Files: <?=empty($reviewed_files_number)?0:$reviewed_files_number?></td>
                            </tr>
                            <tr>
                                <td>Cost: <?=empty($classification_cost)?0:$classification_cost?></td>
                                <td>Cost: <?=empty($annotation_cost)?0:$annotation_cost?></td>
                                <td>Cost: <?=empty($review_cost)?0:$review_cost?></td>
                            </tr>
                        </table>
                        <p class="float-sm-right"><b>Total Cost:</b> <?=empty($total_cost)?0:$total_cost?></p>
                    </div>
                    <!-- <div class="card-header">
                        <h3 class="card-title"><?=__('Details')?></h3>
                    </div> -->

                    <div class="" style="    margin: 25px 20px -15px 20px;">
                        <!-- <h5><b>Details</b></h5> -->
                    </div>
                    <?php
                        $fields = [
                            'basicModel' => 'fileLogs',
                            'id' => [],
                            'file_name' => ['title' => 'File Name'],
                            'status' => ['format'=>'get_from_array','options' => ['items_list' => $status_tasks]],
                            // 'status' => [],
                            'created' => ['title' => __('Submission Date/Time')],
                            // 'active' => ['format' => 'bool']
                        ];

                        $multi_select_actions = array(
                            'delete' => array('action' => $this->Url->build(array('action' => 'delete_multi', 'Admin' => true)), 'confirm' => true)
                        );

                        $actions = [
                            // 'permissions' => $this->Html->link(__('Download'), array('action' => 'download', '%id%'), array('class' => 'btn btn-success btn-sm', 'icon' => 'fas fa-pencil-alt')),
                        ];
                        //echo $this->List->adminIndex($fields, $files, $actions, false, $multi_select_actions, $parameters);
                    ?>
                </div>
            <?php } ?>


            </div>
        </div>
    </div>
</section>

</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#filterform').show('fast');void(0);
    });
</script>










