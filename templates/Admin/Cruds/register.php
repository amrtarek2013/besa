<div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new membership</p>

      <?= $this->Flash->render() ?>
      <?= $this->Form->create() ?>
        <!-- <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Full name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div> -->
        <div class="input-group mb-3">
        <?= $this->Form->control('name', ['placeholder'=>'Name','class'=>'form-control','label'=>false,'required' => true]) ?>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
        <?= $this->Form->control('password', ['placeholder'=>'Password','class'=>'form-control','label'=>false,'required' => true]) ?>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        
        <div class="row">
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
        <?= $this->Form->end() ?>

      

    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->