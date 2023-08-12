<section class="main-banner Create-account-banner visitors-application educational-institution">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7">
                <div class="background-banner-color">
                    <img src="<?= WEBSITE_URL ?>img/Welcome-2.png" alt="">
                    <img src="<?= WEBSITE_URL ?>img/dots-153.png" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-5">
                <div class="relative-box-about ">
                    <h1 class="relative-text">Institution</h1>
                            <h2 class="title text-left">Educational <br />Institution</h2>
                </div>
            </div>




            <div class="col-md-12 ">
                <?= $this->Form->create(null, array('url' => 'contact-us', 'type' => 'file', 'id' => 'FormEducationalInstitution', 'class' => 'register')); ?>

                <input type="hidden" id="type" name="type" value="educational-institution">
                <p class="light-para">For the purpose of applying regulation, your details are required.</p>

                <div class="container-formBox">
                    <!-- <h4 class="title">Create an account to apply</h4> -->
                    <div class="grid-container">

                        <?= $this->Form->control('school_name', [
                            'placeholder' => 'School name', 'label' => 'School name*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?= $this->Form->control('school_counselor_name', [
                            'placeholder' => 'School counselor name *', 'label' => 'School counselor name *', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <div class="form-area ">
                            <?= $this->Form->label('phone', 'Mobile*') ?>
                            <?= $this->Form->control('phone', [
                                'type' => 'tel', 'placeholder' => 'Mobile', 'label' => false, 'class' => 'form-control', 'required' => true
                            ]) ?>
                            <?= $this->Form->control('phone_code', [
                                'placeholder' => 'Code', 'class' => 'country_code', 'label' => false, 'required' => true,
                                'type' => 'select', 'options' => $countriesCodesList
                            ]) ?>
                        </div>

                        <?= $this->Form->control('email', [
                            'placeholder' => 'Email', 'class' => 'form-control', 'label' => 'Email*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>

                        <?php /* $this->Form->control('attending_students_no', [
                            'type' => 'number', 'label' => 'Number of attending students*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="special-form form-area {{rquired}}">{{content}}</div>']
                        ]) */?>
                        <?= $this->Form->control('attending_students_no', [
                            'type' => 'number',
                            'label' => ['text' => 'Number of attending students*', 'class' => 'form-label'],
                            'required' => true,
                            'templates' => [
                                'inputContainer' => '<div class="custom-number-input">{{content}}<div class="button-group">{{append}}</div></div>',
                            ],
                            'inputTemplates' => [
                                'input' => '<input type="{{type}}" name="{{name}}" class="{{required}}"{{attrs}}>',
                            ],
                            'append' => '<button class="increment">+</button><button class="decrement">-</button>',
                        ]) ?>

                        
                        <?php /*$this->Form->control('certificate', [
                            'type' => 'file',
                            'class' => 'required', 'required' => true, 'label' => 'Upload attending students details*',
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        ]); */?>

                        <?= $this->Form->control('certificate', [
                            'type' => 'file',
                            'class' => 'required',
                            'required' => true,
                            'templates' => [
                                'inputContainer' => '<div class="form-area {{required}}">{{content}}</div>',
                                'label' => '<label{{attrs}}>Upload attending students details*<img src="/img/icon-label.svg"></label>'
                            ]
                        ]); ?>


                        <?= $this->element('security_code', ['show_label' => true]) ?>

                    </div>

                    <div class="container-submit">

                        <div class="checkboxes">
                            <div>
                                <input type="checkbox" name="terms" id="terms" required="required">
                                <label for="">I agree to <a href="#">terms & conditions</a> </label>
                            </div>
                            <div>
                                <input type="checkbox" name="is_subscribed" id="is_subscribed">
                                <label for="">I’d like being informed about latest news and tips</label>
                            </div>
                        </div>
                        <!-- <a href="#" class="btn greenish-teal">SUBMIT</a> -->

                    </div>
                    <button type="submit" class="btn greenish-teal">Submit</button>

                </div>
                <?= $this->Form->end() ?>

            </div>

        </div>
    </div>
</section>