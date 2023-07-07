<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('Users') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><?= __('Users') ?></li>
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
                            <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . ' User') ?></h3>
                        </div>

                        <?php
                        $action = $this->request->getParam('action');
                        ?>
                        <div class="card-body">
                            <?php
                            echo $this->AdminForm->create($user, ['type' => 'file', 'id' => $action . 'AdminForm']);
                            ?>

                            <div class="col-md-12">
                                <div class="container-formBox">
                                    <h4 class="title">Basic Information</h4>
                                    <div class="grid-container">
                                        <?= $this->AdminForm->control('first_name', ['placeholder' => 'First Name', 'class' => 'form-area', 'label' => 'First Name*', 'required' => true]) ?>
                                        <?= $this->AdminForm->control('middle_name', ['placeholder' => 'Middle Name', 'class' => 'form-area', 'label' => 'Middle Name', 'required' => false]) ?>
                                        <?= $this->AdminForm->control('last_name', ['placeholder' => 'Last Name', 'class' => 'form-area', 'label' => 'Last Name*', 'required' => true]) ?>
                                        <?= $this->AdminForm->control('email', ['placeholder' => 'Email address', 'class' => 'form-control', 'label' => 'Email address*', 'required' => true]) ?>

                                        <?= $this->AdminForm->control('mobile', ['placeholder' => 'Mobile', 'class' => 'form-area', 'label' => 'Mobile*', 'required' => true]) ?>

                                        <?= $this->AdminForm->control('password', ['type' => 'password', 'placeholder' => 'Password', 'class' => 'form-area', 'value' => '', 'autocomplete' => 'off', 'label' => 'Password*']) ?>
                                        <?= $this->AdminForm->control('passwd', ['type' => 'password', 'placeholder' => 'Confirm Password', 'class' => 'form-area', 'label' => 'Confirm Password*']) ?>

                                        <?= $this->AdminForm->control('gender', ['placeholder' => 'Gender', 'type' => 'select', 'empty' => 'Select Gender', 'options' => [0 => 'Male', 1 => 'Female'], 'class' => 'form-area', 'label' => 'Gender*', 'required' => true]) ?>

                                        <?= $this->AdminForm->control('nationality', ['placeholder' => 'Nationality', 'class' => 'form-area', 'label' => 'Nationality*', 'required' => true]) ?>

                                        <?= $this->AdminForm->control('country_id', ['placeholder' => 'Country of Residence', 'type' => 'select', 'empty' => 'Select Country of Residence', 'options' => $countriesList, 'class' => 'form-area', 'label' => 'Country of Residence*', 'required' => true]) ?>

                                        <?= $this->AdminForm->control('address', ['type' => 'text', 'placeholder' => 'Address', 'class' => 'form-area', 'label' => 'Address*', 'required' => true]) ?>

                                        <!-- <?= $this->AdminForm->enableAjaxUploads($id, 'user_' . $id, $mainAdminToken) ?> -->
                                        <?= $this->AdminForm->control('active', ['type' => 'checkbox']) ?>
                                        <?= $this->AdminForm->control('confirmed', ['type' => 'checkbox']) ?>
                                        <?= $this->AdminForm->control('display_order', []) ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="container-formBox blue-border">
                                    <h4 class="title">Education Information</h4>
                                    <div class="grid-container">
                                        <?= $this->AdminForm->control('study_level_id', ['placeholder' => 'Level of study', 'type' => 'select', 'empty' => 'Select Level of study*', 'options' => $services, 'class' => 'form-area', 'label' => 'Level of study*', 'required' => true]) ?>

                                        <?= $this->AdminForm->control('course_interest_id', ['placeholder' => 'Course of Interest', 'type' => 'select', 'empty' => 'Select Course of Interest*', 'options' => $services, 'class' => 'form-area', 'label' => 'Course of Interest*', 'required' => true]) ?>

                                        <?= $this->AdminForm->control('current_status', ['type' => 'text', 'placeholder' => 'Current status', 'class' => 'form-area', 'label' => 'Current status*', 'required' => true]) ?>

                                        <?= $this->AdminForm->control('high_school_grade', ['type' => 'text', 'placeholder' => 'High school grade', 'class' => 'form-area', 'label' => 'High school grade*', 'required' => true]) ?>

                                        <?= $this->AdminForm->control('how_hear_about_us', ['type' => 'text', 'placeholder' => 'How did you hear about us?', 'class' => 'form-area', 'label' => 'How did you hear about us?', 'required' => true]) ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><?= __('Save') ?> </button>
                        </div>
                        <?= $this->AdminForm->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function() {
        $('.select-single').select2();
        $('.select-multiple').select2();
    });
</script>
<?php

echo $this->Html->script('select2.min');
echo $this->Html->css('select2.min');
