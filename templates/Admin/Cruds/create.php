<div class="content-wrapper">

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title"><?= __('Create Crud') ?></h3>

            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <?= $this->Form->create($cruds) ?>
            <div class="card-body">
              <div class="col-md-8">
                <?php echo $this->AdminForm->control('prefix', ['placeholder' => 'Prefix (separated by comma [,] like admin,manager )', 'label' => false]); ?>
              </div>
              <div class="col-md-4">
                <?php echo $this->AdminForm->control('add_to_public', array('type' => 'checkbox', 'checked' => true)); ?>
              </div>
              <?php echo $this->AdminForm->control('relations', array('label' => false, 'type' => 'textarea', 'placeholder' => 'Relations here {}')); ?>

              <div class="col-md-2">
                <?php echo $this->AdminForm->control('create_controller', array('type' => 'checkbox', 'checked' => true)); ?>
              </div>
              <div class="col-md-2">
                <?php echo $this->AdminForm->control('create_model', array('type' => 'checkbox', 'checked' => true)); ?>
              </div>
              <div class="col-md-2">
                <?php echo $this->AdminForm->control('create_views', array('type' => 'checkbox', 'checked' => true)); ?>
              </div>

              <?php foreach ($new_columns as $permalink => $column) : ?>

                <div class="row col-md-12">
                  <div class="col-md-3">
                    <?php echo $this->AdminForm->control($permalink . '.field', ['type' => 'hidden', 'value' => $permalink]); ?>
                    <?php echo $column ?>
                  </div>
                  <div class="col-md-3">

                    <?php echo $this->AdminForm->control($permalink . '.type', ['empty' => 'Select field type', 'options' => $fields]); ?>
                  </div>


                  <div class="col-md-3">

                    <?php echo $this->AdminForm->control($permalink . '.validations', array('type' => 'textarea', 'placeholder' => 'Validations roles here {}')); ?>


                  </div>
                  <div class="col-md-3">

                    <?php
                    echo $this->AdminForm->control($permalink . '.showIn', ['class' => 'select2', 'options' => $actions, 'multiple' => 'multiple', 'placeholder' => 'Select Actions to add the field (views files [index-add-edit ...])']); ?>


                  </div>

                </div>
              <?php endforeach; ?>



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

</div>
<?= $this->Html->script('select2.full.min'); ?>
<?= $this->Html->css('select2.min'); ?>

<script>
  $('.select2').select2({
    placeholder: 'Select the actions'
  });
</script>