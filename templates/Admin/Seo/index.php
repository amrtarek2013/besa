<section class="content listSection container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card-header">
                <h3 class="card-title">List</h3>
            </div>
            <?php if($filters){ ?>
            <div class="card">
               <?php
               $session = $this->getRequest()->getSession();
               echo $this->List->filter_form($seo,$filters,[],[],$parameters,$session)?> 
            </div>
            <?php } ?>
            <a href="<?=$this->Url->build(array('action' => 'add' ,'Admin' => true))?>" class="btn btn-info btn-flat" icon="fas fa-pencil-alt"><i class="fas fa-plus"></i>  Add New</a>

            <div class="card card-primary">
            
            <?php 
            
            $fields = [
'basicModel'=>'seo',
'criteria'=>[],
'title'=>[],
// 'keywords'=>[],
// 'description'=>[]
];

            $multi_select_actions = array(
                'delete' => array('action' => $this->Url->build(array('action' => 'delete_multi' ,'Admin' => true)), 'confirm' => true)
            );

            

                $actions = [
                // 'view'=>$this->Html->link(__('View'), ['action' => 'view', '%id%'],array('class' => 'btn btn-primary btn-flat','icon'=>'fas fa-binoculars')),
                'edit'=>$this->Html->link('Edit', array('action' => 'edit', '%id%'), array('class' => 'btn btn-info btn-flat','icon'=>'fas fa-pencil-alt')),
                'delete'=>$this->Html->link('Delete',['action' => 'delete', '%id%'],
                    ['confirm' => 'Are you sure you wish to delete this?',
                    'class'=>'btn btn-danger btn-flat','icon'=>'fas fa-trash']
                ),
                ];



        echo $this->List->adminIndex($fields,$seo,$actions,false,$multi_select_actions,$parameters);
            ?>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
        
            </div>
        </div>
    </div>
</section>

