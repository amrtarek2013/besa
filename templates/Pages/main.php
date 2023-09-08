<?= $this->element('home_slider', ['sliders' => $sliders, 'g_dynamic_routes' => $g_dynamic_routes], ['cache' => ['key' => 'home_slider', 'config' => '_view_long_']]) ?>
<?= $homeEvents ?>
<!--New section 25/5/2023 by en -->
<?= $home_study_journey ?>

<?= $home_why_besa2 ?>


<?= $this->element("choose-place-earth", ['colWidth' => '9', 'redirectUrl' => 'destination'], ['cache' => ['key' => 'choose_place_earth', 'config' => '_view_long_']]) ?>

<?= $this->element('testimonials', ['testimonials' => $testimonials], ['cache' => ['key' => 'home_testimonials', 'config' => '_view_long_']]) ?>

<section class="contact-us">
    <div class="top-dots-img">
        <img loading="lazy" src="<?= WEBSITE_URL ?>img/icon/dots-bakground.svg" alt="">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title">Need any help?</h2>

            </div>
            <div class="col-md-12">
                <h3 class="title-form">Drop us a message and one of our Advisor and Study Abroad Experts will respond to you</h3>
            </div>
            <div class="col-md-5 col-md-offset-1 ">
                <div class="form">

                    <?= $this->Form->create($enquiry, ['url' => '/enquiries/contactUs', 'id' => 'contactusForm']) ?>

                    <input type="hidden" id="type" name="type" value="home">

                    <?php

                    echo $this->Form->control('name', [
                        'placeholder' => 'Your name', 'type' => 'text', 'label' => false,
                        'class' => 'required', 'required' => true,
                        'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                    ]);



                    echo $this->Form->control('email', [
                        'placeholder' => 'Email Address', 'type' => 'email',
                        'class' => 'required', 'label' => false, 'required' => true,
                        'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                    ]);


                    echo $this->Form->control('message', [
                        'placeholder' => 'Your Message', 'type' => 'textarea',
                        'class' => 'required', 'label' => false, 'required' => true,
                        'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                    ]);
                    ?>

                    <?= $this->element('security_code') ?>
                    <input type="submit" value="Send" class="btn MainBtn submit">

                    <?= $this->Form->end() ?>

                </div>

            </div>
            <div class="col-md-6">
                <?php if (!empty($mainBranch)) { ?>
                    <div class="text">
                        <p>
                            <?= $mainBranch['name'] ?>

                        </p>
                        <p><?= $mainBranch['phone'] ?></p>
                        <p><?= $mainBranch['email'] ?></p>
                    </div>

                <?php } ?>
            </div>

        </div>
    </div>
    <div class="bottom-dots-img">
        <img loading="lazy" src="<?= WEBSITE_URL ?>img/icon/dots-bakground.svg" alt="">

    </div>
</section>