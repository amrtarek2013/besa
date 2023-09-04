<section class="main-banner register-banner  app-support-banner">

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="background-banner-color">
                    <img src="<?= WEBSITE_URL ?>/img/new-images/App-background.png" alt="" style="z-index: 2;">
                    <img src="<?= WEBSITE_URL ?>/img/dots-153.png" width="100%" height="100%" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-6">
                <div class="relative-box-about ">
                    <h1 class="relative-text"> Support</h1>
                    <h2 class="title text-left">App Support</h2>
                    <p class="descrpBannar">
                        Our app support team would love to hear <br>
                        from you any feedback and way to <br>
                        improve our service to you!
                    </p>
                </div>

            </div>
            <div class="col-md-12">
                <!-- <form action="" class="register"> -->

                <?= $this->Form->create(null, ['url' => '/enquiries/contactUs', 'class' => 'regsiter', 'id' => 'contactusForm']) ?>
                <input type="hidden" id="type" name="type" value="app-support">
                <div class="container-formBox">
                    <div class="gray-box">
                        <p>For Any App Enquiries Such As Technical Or Log In Issues Do Not Hesitate To Contact Us Through The Form Below</p>
                    </div>
                    <div class="grid-container">
                        <?php

                        echo $this->Form->control('name', [
                            'placeholder' => 'Your name', 'type' => 'text', 'label' => 'Name*',
                            'class' => 'required', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        ]);
                        echo $this->Form->control('surname', [
                            'placeholder' => 'Surname', 'type' => 'text', 'label' => 'Surname*',
                            'class' => 'required', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        ]);


                        echo $this->Form->control('email', [
                            'placeholder' => 'Email Address', 'type' => 'email',
                            'class' => 'required', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        ]);
                        ?>

                    </div>
                    <!-- <div class="form-area">
                            <label for="">Message</label>
                            <textarea name="" id="" cols="40" rows="10"></textarea>
                        </div> -->
                    <div style="padding: 0 20px;">
                        <?php
                        echo $this->Form->control('message', [
                            'placeholder' => 'Your Message', 'type' => 'textarea',
                            'class' => 'required', 'required' => true, 'label' => 'Message*',
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                        ]);
                        ?>
                        <?= $this->element('security_code') ?>
                        <div class="container-submit">
                            <ul class="custome-list">
                                <li>For the purpose of applying regulation, your details are required.</li>
                            </ul>

                            <input type="submit" value="Send" class="btn greenish-teal" style="width: 240px;">
                        </div>
                    </div>
                </div>

                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</section>


<!-- <?= $app_support_section ?> -->