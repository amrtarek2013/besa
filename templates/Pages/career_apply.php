<section class="main-banner register-banner  partiner-banner">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="background-banner-color">
                    <img src="<?= WEBSITE_URL ?>img/new-images/partiner-background.png" alt="" style="z-index: 2;">
                    <img src="<?= WEBSITE_URL ?>img/dots-153.png" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-6">
                <div class="relative-box-about ">
                    <h1 class="relative-text">CAREER</h1>
                    <h2 class="title text-left">APPLY <br> WITH BESA</h2>
                </div>
            </div>

            <?= $partnership_with_besa ?>

            <div class="col-md-12" style="padding: 0;">
                <div class="line-stained">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">

            <div class="col-md-12">

                <?= $this->Form->create(null, ['url' => '/enquiries/contactUs', 'id' => 'contactusForm']) ?>
                <input type="hidden" id="type" name="type" value="career-apply">
                <div class="container-formBox">
                    <div class="gray-box">
                        <p>Submit this form with your details and one of our representatives will be in contact with you.</p>

                    </div>
                    <div class="col-md-12" style="padding: 0 20px">

                        <?= $this->Form->control('career_id', [
                            'placeholder' => 'Career', 'type' => 'select', 'empty' => 'Select Career',
                            'options' => $careersList, 'label' => 'Career*', 'required' => true, 'value' => $id,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>
                    </div>
                    <div class="grid-container">



                        <?php

                        echo $this->Form->control('name', [
                            'placeholder' => 'Name', 'type' => 'text', 'label' => 'Name*',
                            'class' => 'required', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        ]);
                        echo $this->Form->control('surname', [
                            'placeholder' => 'Surname', 'type' => 'text', 'label' => 'Surname*',
                            'class' => 'required', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        ]);
                        echo $this->Form->control('phone', [
                            'placeholder' => 'Phone Number', 'type' => 'text', 'label' => 'Phone Number*',
                            'class' => 'required', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        ]);


                        echo $this->Form->control('email', [
                            'placeholder' => 'Email Address', 'type' => 'email',
                            'class' => 'required', 'required' => true, 'label' => 'Email address*',
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        ]);

                        echo $this->Form->control('address', [
                            'placeholder' => 'Address', 'type' => 'text',
                            'class' => 'required', 'required' => true, 'label' => 'Address*',
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        ]);

                        echo $this->Form->control('certificate', [
                            'type' => 'file',
                            'class' => 'required', 'required' => true, 'label' => 'Upload CV*',
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        ]);


                        echo $this->Form->control('how_hear_about_us', [
                            'placeholder' => 'How did you hear about us?', 'type' => 'text',
                            'class' => 'required', 'required' => true, 'label' => 'How did you hear about us?*',
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        ]);

                        ?>

                        <?= $this->element('security_code', ['show_label' => true]) ?>
                    </div>


                    <div class="container-submit">
                        <ul class="custome-list">
                            <li>For the purpose of applying regulation, your details are required.</li>
                        </ul>
                        <!-- <a href="#" class="btn greenish-teal" style="width: 240px;">SUBMIT</a> -->
                        <input type="submit" value="Submit" class="btn greenish-teal" style="width: 240px;">
                    </div>
                </div>

                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</section>