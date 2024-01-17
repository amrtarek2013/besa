<style>
    .iti {
        left: 10px;
        position: absolute !important;
        bottom: 55px;
    }
</style>
<section class="main-banner register-banner">

    <div class="container" style="width:100%">
       
        <div class="row">
            <?= $this->Form->create($counselor, array('type' => 'file', 'id' => 'FormProfile')); ?>
            <div class="col-md-12">
                <div class="container-profileUser container-profileCounselor">
                    <div class="grid-2col">
                        <?= $this->Form->control('first_name', [
                            'placeholder' => 'Full Name', 'class' => 'form-area', 'label' => 'Full Name*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>
                        <!-- <?= $this->Form->control('middle_name', [
                                    'placeholder' => 'Middle Name', 'class' => 'form-area', 'label' => 'Middle Name', 'required' => false,
                                    'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                                ]) ?>
                        <?= $this->Form->control('last_name', [
                            'placeholder' => 'Last Name', 'class' => 'form-area', 'label' => 'Last Name*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?> -->
                        <?= $this->Form->control('email', [
                            'placeholder' => 'Email address', 'class' => 'form-control', 'label' => 'Email address*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>


                        <?= $this->element('mobile_with_code') //, ['phone_name' => 'mobile', 'phone_label' => 'Mobile', 'phone_code' => 'mobile_code']) 
                        ?>



                        <?= $this->Form->control('password', [
                            'type' => 'password', 'placeholder' => 'Password', 'class' => 'form-area', 'value' => '', 'autocomplete' => 'off', 'label' => 'Password*',
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>
                        <?= $this->Form->control('passwd', [
                            'type' => 'password', 'placeholder' => 'Confirm Password', 'class' => 'form-area', 'label' => 'Confirm Password*',
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?= $this->Form->control('gender', [
                            'placeholder' => 'Gender', 'type' => 'select', 'empty' => 'Select Gender', 'options' => [0 => 'Male', 1 => 'Female'], 'class' => 'form-area', 'label' => 'Gender*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?= $this->Form->control('school_name', [
                            'placeholder' => 'School Name', 'class' => 'form-area', 'label' => 'School Name*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?= $this->Form->control('nationality', [
                            'placeholder' => 'Nationality', 'class' => 'form-area', 'label' => 'Nationality',
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?= $this->Form->control('address', [
                            'type' => 'text', 'placeholder' => 'Address', 'class' => 'form-area', 'label' => 'Address',
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>


                        <?= $this->Form->control('country_id', [
                            'placeholder' => 'Country of Residence', 'type' => 'select', 'empty' => 'Select Country of Residence',
                            'options' => $countriesList, 'label' => 'Country of Residence*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>
                        <!-- <?= $this->Form->control('city', [
                                    'type' => 'text', 'placeholder' => 'City', 'label' => 'City*', 'required' => true,
                                    'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                                ]) ?>
                        <?= $this->Form->control('current_status', [
                            'type' => 'text', 'placeholder' => 'Current/Previous-(School/University)', 'label' => 'Current/Previous-(School/University) *', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>
                        <?= $this->Form->control('study_level_id', [
                            'placeholder' => 'Level of study', 'type' => 'select', 'empty' => 'Select Level of study*',
                            'options' => $mainStudyLevels, 'label' => 'Level of study*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?= $this->Form->control('subject_area_id', [
                            'placeholder' => 'Subject Area', 'type' => 'select', 'empty' => 'Select Subject Area*',
                            'options' => $subjectAreas, 'label' => 'Subject Area*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>


                        <?= $this->AdminForm->control('destination_id', [
                            'placeholder' => 'Destination', 'type' => 'select', 'empty' => 'Select Destination',
                            'options' => $destinationsList, 'label' => 'Destination*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?> -->
                        <?php
                        echo $this->AdminForm->control('image', [
                            'label' => 'Profile Picture', 'type' => 'file', 'between' => $this->element('image_input_between', [
                                'data' => $counselor,
                                'field' => 'image',
                                'info' => [
                                    'width' => $uploadSettings['image']['width'],
                                    'height' => $uploadSettings['image']['height'],
                                    'path' => $uploadSettings['image']['path']

                                ],
                            ]),

                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]);
                        ?>

                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="container-btn-form">
                    <button type="submit" class="btn clear-blue btn-primary">Update</button>
                </div>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</section>