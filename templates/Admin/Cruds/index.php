<?php
echo $this->Html->script([
  'jquery.dataTables',
  'dataTables.bootstrap4'
]);
?>
<div class="content-wrapper">

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">

            <h3 class="card-title"><?= __('Tables') ?></h3>

            <div class="card-tools">
              <div class="input-group input-group-sm" style="width: 150px;">
                <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                <div class="input-group-append">
                  <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive table-bordered">
            <table id="tables" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Actions</th>


                </tr>
              </thead>
              <tbody>
                <?php foreach ($tables as $k => $admin) : ?>
                  <tr>

                    <td><?= \Cake\Utility\Inflector::humanize($admin) ?></td>

                    <td class="actions">
                      <li style='list-style:none'><i class="far fa-edit"></i> <?php echo $this->Html->link(__('Create', true), array('action' => 'create', $admin), array('class' => 'btn btn-info btn-flat', 'icon' => 'fas fa-arrow-right')); ?></li>
                    </td>
                  </tr>
                <?php endforeach; ?>

                </tfoot>
            </table>


          </div>
        </div>
      </div>
    </div>
  </section>

</div>
<script>
  $('#tables').DataTable({
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": false,
    "info": false,
    "autoWidth": true,
  });
</script>