<script src="https://www.google.com/recaptcha/api.js"></script>
<style>
    button.submit {

        font-family: 'Poppins';
        font-style: normal;
        font-weight: 400;
        font-size: 16px;
        line-height: 24px;
        letter-spacing: 0.02em;
        border: 1.2px solid #B4BEC8;
        border-radius: 4px;
        width: 100%;
        height: 50px;
        padding: 13px 14px;
        background: #FF5151;
        border-radius: 10px;
        height: 76px;
    }
</style>


<?= $this->Form->create(null, ['id' => 'contactusForm']) ?>
<input type="hidden" id="type" name="type" value="contact-us">
<section class="contact-us pageContact">
    <div class="top-dots-img">
        <img src="<?= WEBSITE_URL ?>img/icon/dots-bakground.svg" alt="">
    </div>
    <div class="container">
        <div class="row">
            <!--<div class="col-md-12">
                    <h2 class="title">Contact</h2>
                    
                </div>-->
            <div class="col-md-11 col-md-offset-1">
                <div class="form">

                </div>
            </div>
            <div class="col-md-12">
                <div class="container-form">
                    <h3 class="title-form">Send an Email</h3>
                    <!-- <form action=""> -->

                    <?php //= $this->Form->create($enquiry, ['url'=>'/enquiries/contactUs','id' => 'contactusForm']) 
                    ?>
                    <div class="gridFormContact ">
                        <input type="hidden" id="brnachID" value="" name="branch_id" placeholder="your name">
                        <div class="form-left form">
                            <?php

                            echo $this->Form->control('name', [
                                'placeholder' => 'Your name', 'type' => 'text',
                                'class' => 'required', 'required' => true,
                                'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                            ]);


                            echo $this->Form->control('phone', [
                                'placeholder' => 'Your Phone', 'type' => 'text',
                                'class' => 'required', 'required' => true,
                                'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                            ]);

                            echo $this->Form->control('email', [
                                'placeholder' => 'Email Address', 'type' => 'email',
                                'class' => 'required', 'required' => true,
                                'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                            ]);
                            ?>
                            <?= $this->element('security_code') ?>
                            <!-- <div class="form-area security_code">
                                <div class="input captcha" style="position: relative;">
                                    <?php
                                    echo $this->Html->image('/image.jpg/index.php?code=' . mt_rand(9999, 999999), array('class' => 'SecurImage', 'style' => "left: 13px;position: absolute;top: 10px;
                        z-index: 1; height:40px", 'id' => rand()));
                                    echo $this->AdminForm->control('security_code', [
                                        'placeholder' => 'Security Code', 'type' => 'text', 'required' => true,
                                        'class' => 'required', 'style' => "padding-left: 190px;", 'label' => false,
                                        'templates' => ['inputContainer' => '<div class="form-area">{{content}}</div>']
                                    ]);
                                    if (!empty($error_captcha)) :
                                    ?>
                                        <div class='error-message'><?= $error_captcha ?></div>
                                    <?php endif; ?>
                                </div>
                            </div> -->
                        </div>
                        <div class="form-right form">
                            <!-- <div class="form-area">
                                <label for="name">Subject</label>
                                <input type="text" id="Subject" name="subject" placeholder="Email Subject">
                            </div>
                            <div class="form-area">
                                <label for="name">Message</label>
                                <textarea id="message" name="message" placeholder="Your Message"></textarea>
                            </div> -->

                            <?php

                            echo $this->Form->control('subject', [
                                'placeholder' => 'Email subject', 'type' => 'text',
                                'class' => 'required', 'required' => true,
                                'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                            ]);
                            echo $this->Form->control('message', [
                                'placeholder' => 'Your Message', 'type' => 'textarea',
                                'class' => 'required', 'required' => true,
                                'class' => 'required', 'required' => true,
                                'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                            ]);
                            ?>
                            <div class="form-area">
                                <input type="submit" value="Send" class="btn MainBtn submit">
                            </div>
                            <!-- <button type="submit" class="g-recaptcha btn MainBtn submit" data-sitekey="6Lemf1EkAAAAAMnwcS1hUX3mEjXNKfFfIVTMrDGl" data-callback='onSubmit' data-action='submit'>Send</button> -->

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <div class="bottom-dots-img">
        <img src="<?= WEBSITE_URL ?>img/icon/dots-bakground.svg" alt="">

    </div>
</section>

<?= $this->Form->end() ?>