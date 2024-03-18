
<section class="content">
      <div class="row">
        <div class="col-12">
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">Admins</h3>

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
              <div class="card-body table-responsive table-bordered" style="height: 300px;">
                <table class="table table-head-fixed">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Image</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <?php
                      foreach($admins as $admin){?>
                        <td><?= $admin['id'] ?></td>
                        <td><?= $admin['name'] ?></td>
                        <td><?= $admin['image'] ?></td>
                        <td>
                            <li><i class="far fa-eye"></i> <?php echo $this->Html->link(__('View', true), array('action' => 'view', $admin['id']), array('class' => 'btn btn-info btn-flat','icon'=>'fas fa-arrow-right')); ?></li>
                            <li><i class="fas fa-edit"></i> <?php echo $this->Html->link(__('Edit', true), array('action' => 'view', $admin['id']), array('class' => 'Edit')); ?></li>
                            <li><i class="fas fa-trash"></i> <?php echo $this->Html->link(__('Delete', true), array('action' => 'view', $admin['id']), array('class' => 'Delete')); ?></li>

                        </td>


                      <?php }
                      ?>

                    </tr>

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                </ul>
              </div>
            </div>
          <!-- /.card -->

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>

    <script>



</script>
