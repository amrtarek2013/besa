<style>
    .iti__country {
        display: block;
    }

    .iti {
        left: 10px;
        position: relative !important;
        bottom: 37px;

    }

    .form-area input[type="tel"] {
        padding-left: 95px;
    }

    .iti__country,
    .iti--separate-dial-code .iti__selected-dial-code {
        color: #878787;
        font-family: 'Poppins';
        font-style: normal;
        font-weight: 400;
        font-size: 16px;

    }

    .iti__country-list {
        margin: 15px 0px 0 -11px !important;
    }
</style>
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('Students') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><?= __('Students') ?></li>
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
                            <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . ' Student') ?></h3>
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
                                        <?= $this->AdminForm->control('first_name', ['placeholder' => 'Name', 'class' => 'form-area', 'label' => 'First Name*', 'required' => true]) ?>

                                        <?= $this->AdminForm->control('last_name', ['placeholder' => 'Last Name', 'class' => 'form-area', 'label' => 'Last Name*', 'required' => true]) ?>
                                        <?= $this->AdminForm->control('email', ['placeholder' => 'Email address', 'class' => 'form-control', 'label' => 'Email address*', 'required' => true]) ?>

                                        <?php /*= $this->AdminForm->control('mobile_code', ['placeholder' => 'Mobile', 'class' => 'form-area', 'label' => 'Mobile Code*', 'required' => true]) ?>

                                        <?= $this->AdminForm->control('mobile', ['placeholder' => 'Mobile', 'class' => 'form-area', 'label' => 'Mobile*', 'required' => true]) */ ?>

                                        <?= $this->element('mobile_with_code', ['mobileValue' => $user['mobile'], 'mobileCodeValue' => $user['mobile_code']]) ?>

                                        <?= $this->AdminForm->control('password', ['type' => 'password', 'placeholder' => 'Password', 'class' => 'form-area', 'value' => '', 'autocomplete' => 'off', 'label' => 'Password*']) ?>
                                        <?= $this->AdminForm->control('passwd', ['type' => 'password', 'placeholder' => 'Confirm Password', 'class' => 'form-area', 'label' => 'Confirm Password*']) ?>

                                        <?= $this->AdminForm->control('gender', ['placeholder' => 'Gender', 'type' => 'select', 'empty' => 'Select Gender', 'options' => [0 => 'Male', 1 => 'Female'], 'class' => 'form-area', 'label' => 'Gender*', 'required' => false]) ?>

                                        <?= $this->AdminForm->control('date', ['placeholder' => 'Date of Birth', 'value' => $user->bd, 'class' => 'form-area hasDate', 'label' => 'Date of Birth*', 'required' => false]) ?>

                                        <?= $this->AdminForm->control('nationality_id', ['placeholder' => 'Nationality', 'type' => 'select', 'class' => 'form-area', 'label' => 'Nationality*', 'options' => $countriesList, 'required' => false]) ?>

                                        <!-- <?= $this->AdminForm->control('country_id', ['placeholder' => 'Country of Residence', 'type' => 'select', 'empty' => 'Select Country of Residence', 'options' => $countriesList, 'class' => 'form-area', 'label' => 'Country of Residence*', 'required' => true]) ?> -->

                                        <?= $this->AdminForm->control('address', ['type' => 'text', 'placeholder' => 'Address', 'class' => 'form-area', 'label' => 'Address*', 'required' => false]) ?>


                                        <?= $this->AdminForm->control('country_id', [
                                            'placeholder' => 'Country of Residence', 'type' => 'select', 'empty' => 'Select Country of Residence',
                                            'options' => $countriesList, 'label' => 'Country of Residence*', 'required' => false,
                                        ]) ?>


                                        <?= $this->AdminForm->control('city', [
                                            'type' => 'text', 'placeholder' => 'City', 'label' => 'City*', 'required' => false,

                                        ]) ?>


                                        <?= $this->AdminForm->control('current_status', [
                                            'type' => 'text', 'placeholder' => 'Current/Previous-(School/University)', 'label' => 'Current/Previous-(School/University) *', 'required' => false,
                                        ]) ?>

                                        <?= $this->AdminForm->control('study_level_id', [
                                            'placeholder' => 'Level of study', 'type' => 'select', 'empty' => 'Select Level of study*',
                                            'options' => $mainStudyLevels, 'label' => 'Level of study*', 'required' => false,
                                        ]) ?>

                                        <?= $this->AdminForm->control('subject_area_id', [
                                            'placeholder' => 'Subject Area', 'type' => 'select', 'empty' => 'Select Subject Area*',
                                            'options' => $subjectAreas, 'label' => 'Subject Area*', 'required' => false,
                                        ]) ?>

                                        <?= $this->AdminForm->control('destination_id', [
                                            'placeholder' => 'Destination', 'type' => 'select', 'empty' => 'Select Destination',
                                            'options' => $destinationsList, 'label' => 'Destination*', 'required' => false,
                                        ]) ?>

                                        <?= $this->AdminForm->control('active', ['type' => 'checkbox']) ?>
                                        <?= $this->AdminForm->control('confirmed', ['type' => 'checkbox']) ?>
                                        <?= $this->AdminForm->control('is_subscribed', ['type' => 'checkbox']) ?>
                                        <?= $this->AdminForm->control('display_order', []) ?>

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

<!-- <?php

        echo $this->Html->script('select2.min');
        echo $this->Html->css('select2.min');
        ?>
<script>
    $(document).ready(function() {
        $('.select-single').select2();
        $('.select-multiple').select2();
    });
</script> -->