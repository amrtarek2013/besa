<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('Counselor Rewards') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><?= __('Counselor Rewards') ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . ' Counselor Reward') ?></h3>
                        </div>

                        <?php
                        $action = $this->request->getParam('action');
                        ?>
                        <?= $this->AdminForm->create($counselorReward, ['type' => 'file', 'id' => $action . 'Form']); ?>
                        <div class="card-body">
                            <?php

                            echo $this->AdminForm->control('from_student', ['type' => 'number', 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('to_student', ['type' => 'number', 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('points', ['type' => 'number', 'class' => 'INPUT required']);

                            echo $this->AdminForm->control('active', ['type' => 'checkbox', 'class' => 'INPUT required']);
                            ?>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><?= __('Save') ?></button>
                            <?php
                            if (!$counselorReward->isNew()) {

                                echo $this->element('save_as_new', array($counselorReward));
                            }
                            ?>
                        </div>
                        <?= $this->AdminForm->end() ?>
                    </div>
                    <!-- /.card -->

                </div>
            </div>
        </div>
    </section>
</div>