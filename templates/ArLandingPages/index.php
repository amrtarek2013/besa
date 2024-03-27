<script src="<?= ADMIN_ASSETS ?>/custom_helper/jquery-2.2.4.min.js" ></script>
<link rel="stylesheet" href="<?= ADMIN_ASSETS ?>/custom_helper/style.css?v=2">

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('Ar Landing Page List') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= ADMIN_LINK ?>"><?= __('Home') ?></a></li>
                        <li class="breadcrumb-item active"><?= __('Ar Landing Page') ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

  <section class="content">
        <div class="container-fluid">
            <div class="row">
            <div class="col-12">

           <?php if($filters){ ?>
            <div class="card">
               <?php
               $session = $this->getRequest()->getSession();
               echo $this->List->filter_form($arLandingPages,$filters,[],[],$parameters,$session)?> 
            </div>
            <?php } ?>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= __('Ar Landing Page List') ?></h3>
                            <a class="add-new-btn btn btn-primary <?= $currLang == 'en' ? 'float-right' : 'float-left' ?>" href="<?= Cake\Routing\Router::url(['action' => 'add']) ?>">
                                <?= __('Add new') ?>
                            </a>
                            </div>  
                    
            
            <?php 
            
            $fields = [
'basicModel'=>'arLandingPages',
'title'=>[],
'permalink'=>[],
'right_logo'=>[],
'left_image'=>[],
'section_1'=>[],
'section_2'=>[],
'section_3'=>[],
'section_4'=>[],
'section_5'=>[],
'section_6'=>[],
'section_7'=>[],
'section_8'=>[],
'section_9'=>[],
'section_10'=>[],
'footer'=>[],
'created'=>[],
'modified'=>[]
];

            $multi_select_actions = array(
                'delete' => array('action' => $this->Url->build(array('action' => 'delete_multi' )), 'confirm' => true)
            );

            

                $actions = [
                // 'view'=>$this->Html->link(__('View'), ['action' => 'view', '%id%'],array('class' => 'btn btn-primary btn-flat','icon'=>'fas fa-binoculars')),
                'edit'=>$this->Html->link('Edit', array('action' => 'edit', '%id%'), array('class' => 'btn btn-primary btn-sm','icon'=>'fa fa-pencil-square-o')),
                'delete'=>$this->Html->link('Delete',['action' => 'delete', '%id%'],
                    ['confirm' => 'Are you sure you wish to delete this?',
                    'class'=>'btn btn-danger btn-sm','icon'=>'fas fa-trash']
                ),
                ];



        echo $this->List->adminIndex($fields,$arLandingPages,$actions,true,$multi_select_actions,$parameters);
            ?>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
        
            </div>
        </div>
    </div>
    </div>
</section>

</div>