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

                            echo $this->AdminForm->control('counselor_id', ['type' => 'select', 'options' => $counselors, 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('user_id', ['type' => 'select', 'options' => [], 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('point_id', ['type' => 'select', 'empty' => 'Select Pouints', 'options' => $rewardPoints, 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('points', ['type' => 'number', 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('number_points_dollar', ['type' => 'number', 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('total', ['type' => 'number', 'class' => 'INPUT required']);

                            echo $this->AdminForm->control('is_paid', ['type' => 'checkbox', 'class' => 'INPUT required']);
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
<script>
    var usersList = <?= json_encode($users) ?>;
    var rewardStudentPoints = <?= json_encode($rewardStudentPoints) ?>;
    $(document).ready(function() {

        $('#counselor-id').on('change', function() {
            let val = $(this).val();
            if (val != '' && val != undefined) {
                let selectUsers = usersList[val];

                $("#user-id").append('<option value="">Select Student</option>');
                $.each(selectUsers, function(i, userItem) {
                    $("#user-id").append('<option value="' + userItem.id + '">' + userItem.first_name + ' ' + userItem.last_name + ' </option>');
                });
            }
        });



        $('#point-id').on('change', function() {
            let val = $(this).val();
            if (val != '' && val != undefined) {
                let selectPoints = rewardStudentPoints[val];
                $('#points').val(selectPoints);
                $('#points').trigger('change');
            }

        });

        $('#points, #number-points-dollar').on('change focus keyup keypress keydown', function() {
            if ($('#points').val() != '' && $('#points').val() !== undefined && $('#number-points-dollar').val() != '' && $('#number-points-dollar').val() !== undefined) {

                $('#total').val($('#points').val() / $('#number-points-dollar').val());
            }

        });
    });
</script>