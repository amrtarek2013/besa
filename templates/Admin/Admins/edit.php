
<section class="content Config colConfig">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><?= __('Edit Admin') ?></h3>
                <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $admin->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $admin->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Admins'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
               <?= $this->Form->create($admin,['type'=>'file']) ?>
               <div class="card-body">
            <div class="FormExtended">
                  <div class="form-group">

                    <?php echo $this->Form->control('name',['class'=>'form-control']); ?>
                  </div>
                  <div class="form-group">
                    <?php echo $this->Form->control('password',['class'=>'form-control']); ?>
                   
                  </div>

                    <?php echo $this->Form->control('avatar',
                        ['type'=>'file']
                    ); ?>


                </div>
               </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            <?= $this->Form->end() ?>
            </div>
            <!-- /.card -->



          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>

