

<section class="content Config EditHTMLPage">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')).' admin') ?></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?= $this->AdminForm->create($admin,['type' => 'file']) ?>
                <div class="card-body">
                  <div class="form-group">

                    <?php echo $this->AdminForm->control('name',['class'=>'form-control']); ?>
                  </div>
                  <div class="form-group">
                    <?php echo $this->AdminForm->control('password',['class'=>'form-control']); ?>
                   
                  </div>

                    <?php echo $this->AdminForm->control('avatar',
                        ['type'=>'file']
                    ); ?>


                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            <?= $this->AdminForm->end() ?>
            </div>
            <!-- /.card -->



          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
