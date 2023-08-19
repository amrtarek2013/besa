<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('Counselors') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><?= __('Counselors') ?></li>
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
                            <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . ' Counselor') ?></h3>
                        </div>

                        <?php
                        $action = $this->request->getParam('action');
                        ?>
                        <div class="card-body">
                            <?php
                            echo $this->AdminForm->create($counselor, ['type' => 'file', 'id' => $action . 'AdminForm']);
                            ?>

                            <div class="col-md-12">
                                <div class="container-formBox">
                                    <h4 class="title">Basic Information</h4>
                                    <div class="grid-container">
                                        <?= $this->AdminForm->control('first_name', ['placeholder' => 'Full Name', 'class' => 'form-area', 'label' => 'Full Name*', 'required' => true]) ?>
                                        <!-- <?= $this->AdminForm->control('middle_name', ['placeholder' => 'Middle Name', 'class' => 'form-area', 'label' => 'Middle Name', 'required' => false]) ?>
                                        <?= $this->AdminForm->control('last_name', ['placeholder' => 'Last Name', 'class' => 'form-area', 'label' => 'Last Name*', 'required' => true]) ?> -->
                                        <?= $this->AdminForm->control('email', ['placeholder' => 'Email address', 'class' => 'form-control', 'label' => 'Email address*', 'required' => true]) ?>

                                        <?= $this->AdminForm->control('mobile', ['placeholder' => 'Mobile', 'class' => 'form-area', 'label' => 'Mobile*', 'required' => true]) ?>


                                        <?= $this->AdminForm->control('password', ['type' => 'password', 'placeholder' => 'Password', 'class' => 'form-area', 'value' => '', 'autocomplete' => 'off', 'label' => 'Password*']) ?>
                                        <?= $this->AdminForm->control('passwd', ['type' => 'password', 'placeholder' => 'Confirm Password', 'class' => 'form-area', 'label' => 'Confirm Password*']) ?>

                                        <?= $this->AdminForm->control('gender', ['placeholder' => 'Gender', 'type' => 'select', 'empty' => 'Select Gender', 'options' => [0 => 'Male', 1 => 'Female'], 'class' => 'form-area', 'label' => 'Gender*', 'required' => true]) ?>
                                        <?= $this->AdminForm->control('school_name', ['placeholder' => 'School Name', 'class' => 'form-area', 'label' => 'School Name*', 'required' => true]) ?>
                                        <!-- <?= $this->AdminForm->control('nationality', ['placeholder' => 'Nationality', 'class' => 'form-area', 'label' => 'Nationality*', 'required' => true]) ?> -->

                                        <!-- <?= $this->AdminForm->control('country_id', ['placeholder' => 'Country of Residence', 'type' => 'select', 'empty' => 'Select Country of Residence', 'options' => $countriesList, 'class' => 'form-area', 'label' => 'Country of Residence*', 'required' => true]) ?> -->

                                        <!-- <?= $this->AdminForm->control('address', ['type' => 'text', 'placeholder' => 'Address', 'class' => 'form-area', 'label' => 'Address*', 'required' => true]) ?> -->

                                        <!-- <?= $this->AdminForm->enableAjaxUploads($id, 'counselor_' . $id, $mainAdminToken) ?> -->
                                        <?= $this->AdminForm->control('active', ['type' => 'checkbox']) ?>
                                        <?= $this->AdminForm->control('confirmed', ['type' => 'checkbox']) ?>
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
<script>
    var oldpp = '<?= $counselor['pp'] ?>';
    $('#password').on('change focus keyup keypress keydown', function() { // ,keyup , keydown, focus
        let va = $(this).val();
        // va = va.replace(/\W+/g, '-').toLowerCase();
        // $(this).val(va);
        console.log(va);
        console.log($(this).val() == '' || $(this).val() == undefined)
        if ($(this).val() == '' || $(this).val() == undefined)
            $('#pp').val(oldpp);
        else
            $('#pp').val($(this).val());
    });
</script>