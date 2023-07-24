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


<section class="main-banner contact-banner">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="background-banner-color">
                    <img src="/img/hero-bg10.png" alt="">
                    <img src="/img/dots-153.png" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-6">
                <div class="relative-box-about ">
                    <h1 class="relative-text">Contact</h1>
                    <h2 class="title text-left">Contact Us</h2>
                </div>
            </div>
            <div class="col-md-12" style="padding: 0">
                <div class="title-banner-blue">
                    <div class="icons">
                        <!-- <a href="#">
                            <i class="fab fa-facebook fa-2x"></i>
                        </a>
                        <a href="#">
                            <i class="fab fa-instagram fa-2x"></i>
                        </a>
                        <a href="#">
                            <i class="fab fa-youtube fa-2x"></i>
                        </a>
                        <a href="#">
                            <i class="fab fa-linkedin fa-2x"></i>
                        </a>
                        <a href="#">
                            <i class="fab fa-twitter fa-2x"></i>
                        </a> -->
                        <a href="<?= $g_configs['social_links']['txt.facebook_link'] ?>" class="facebook" target="_blank">
                            <img src="/img/icon/social-media/Facebook.svg" alt="facebook">
                        </a>
                        <a href="<?= $g_configs['social_links']['txt.instagram_link'] ?>" class="instagram">
                            <img src="/img/icon/social-media/Instagram.svg" alt="Instagram">

                        </a>
                        <a href="<?= $g_configs['social_links']['txt.youtube_link'] ?>" class="youtube" target="_blank">
                            <img src="/img/icon/social-media/YouTube.svg" alt="YouTube">

                        </a>
                        <a href="<?= $g_configs['social_links']['txt.linkedin_link'] ?>" class="linkedin" target="_blank">
                            <img src="/img/icon/social-media/Linkedin.svg" alt="Linkedin">

                        </a>
                        <a href="<?= $g_configs['social_links']['txt.twitter_link'] ?>" class="Twitter" target="_blank">
                            <img src="/img/icon/social-media/Twitter.svg" alt="twitter">

                        </a>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="content-en">
                    <div class="formSelect">
                        <h2 class="title">Select Country</h2>
    <div class="container-select">
        <select name="country" id="country">

            <option value="">Select Country</option>
            <?php
            foreach ($countries as $country) {
            ?>
                <option value="<?= $country ?>"><?= $country ?></option>
            <?php
            }
            ?>

        </select>
        <select name="city" id="city" style="display: block;">
            <option value="">Select Branch</option>
        </select>
    </div>

    <h3 class=" title" id="branch-name"></h3>
    <ul id="branch-details">
        
        <div class="icons">
            <a href="<?= $g_configs['social_links']['txt.facebook_link'] ?>" class="facebook" target="_blank">
                <img src="/img/icon/facebook.svg" alt="">
            </a>
            <a href="<?= $g_configs['social_links']['txt.instagram_link'] ?>" class="instagram">
                <img src="/img/icon/instagram.svg" alt="" target="_blank">
            </a>
            <a href="<?= $g_configs['social_links']['txt.youtube_link'] ?>" class="youtube" target="_blank">
                <img src="/img/icon/youtube.svg" alt="">
            </a>
            <a href="<?= $g_configs['social_links']['txt.linkedin_link'] ?>" class="linkedin" target="_blank">
                <img src="/img/icon/linkedin.svg" alt="">
            </a>
            <a href="<?= $g_configs['social_links']['txt.twitter_link'] ?>" class="twitter" target="_blank">
                <img src="/img/icon/twitter.svg" alt="">
            </a>
        </div>
    </ul>
    </div>

    </div>
    </div>
    </div>
    </div> -->

</section>
<?= $book_free_meeting ?>

<!-- <section class="free-meating " style="background: #fff;">
    <div class="container-fluid">
        <div class="row">
            <div class="grid-meating">
                <div class="image">
                    <img src="/img/smiling-handsome-business-leader-making-notes 1.png" alt="">
                </div>

                <div class="text">
                    <h2>
                        Book a <span> free meeting </span> with <br> our councillors, experts in <br> study abroad enquiries
                    </h2>
                    <a href="#" class="btn greenish-teal">Book Now <img src="img/icon/arrow-right.svg" alt=""></a>
                </div>
            </div>
        </div>
    </div>
</section> -->
<section class="contact-en">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="grid3col">

                    <?php
                    foreach ($branches as $branch) {
                    ?>

                        <div class="item">
                            <img src="<?= $branch['flag_path'] ?>" alt="">
                            <div class="content">
                                <h4><?= $branch['name'] ?></h4>
                                <p class="address"><?= $branch['address'] ?></p>
                                <p class="phone"><?= $branch['phone'] ?></p>
                                <p class="phone"><?= $branch['other_phone'] ?></p>
                                <p class="phone"><?= $branch['mobile'] ?></p>
                                <p class="email"><?= $branch['email'] ?></p>
                                <p class="time-red">
                                    <?= $branch['working_time'] ?>
                                </p>
                            </div>

                            <!-- <div class="content">
                                <h4><?= $branch['name'] ?></h4>
                                <p class="address"><?= $branch['address'] ?></p>
                                <p class="phone"><?= $branch['phone'] ?></p>
                                <p class="phone"><?= $branch['other_phone'] ?></p>
                                <p class="phone"><?= $branch['mobile'] ?></p>
                                <p class="email"><?= $branch['email'] ?></p>
                                <p class="time-red">
                                    <?= $branch['working_time'] ?>
                                </p>
                            </div> -->
                        </div>
                    <?php } ?>
                    <!-- <div class="item">
                        <img src="img/flag-uk.png" alt="">
                        <div class="content">
                            <h4>UK OFFICE</h4>
                            <p class="address">
                                Parkway Two, Parkway Business<br>
                                Centre, Princess Road,<br>
                                Manchester, M14 7HR
                            </p>
                            <p class="phone">(+44) 77668 91380</p>

                            <p class="email">uk.info@besaeg.com</p>
                            <p class="time-red">
                                MONDAY TO <br>
                                FRIDAY 9AM - 5PM <br>
                                UK TIME
                            </p>
                        </div>

                    </div>
                    <div class="item">
                        <img src="img/flag-sudan.png" alt="">
                        <div class="content">
                            <h4>SUDAN OFFICE</h4>
                            <p class="address">
                                71 Mecaa st, block no.15,<br>
                                Al-Ryad, Beside Barista café,<br>
                                Khartoum, Sudan
                            </p>
                            <p class="phone">+249 123 122 195</p>
                            <p class="phone">+249 123 122 196</p>
                            <p class="email">sudan@besaeg.com</p>
                            <p class="time-red">
                                SUNDAY TO <br>
                                THURSDAY 9AM - 5PM<br>
                                UK TIME
                            </p>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->Flash->render() ?>
<?= $this->Form->create($enquiry, ['url' => '/enquiries/contactUs', 'id' => 'contactusForm']) ?>
<input type="hidden" id="type" name="type" value="contact-us">
<section class="contact-us pageContact">
    <div class="top-dots-img">
        <img src="/img/icon/dots-bakground.svg" alt="">
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
                            <!-- <div class="form-area">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" placeholder="your name">
                                <input type="hidden" id="brnachID" value="" name="branch_id" placeholder="your name">
                            </div> -->
                            <?php

                            echo $this->Form->control('name', [
                                'placeholder' => 'Your name', 'type' => 'text',
                                'class' => 'required','required'=>true,
                                'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                            ]);


                            echo $this->Form->control('phone', [
                                'placeholder' => 'Your Phone', 'type' => 'text',
                                'class' => 'required','required'=>true,
                                'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                            ]);

                            echo $this->Form->control('email', [
                                'placeholder' => 'Email Address', 'type' => 'email',
                                'class' => 'required','required'=>true,
                                'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                            ]);
                            ?>
                            <div class="form-area security_code">
                                <div class="input captcha" style="position: relative;">
                                    <?php
                                    echo $this->Html->image('/image.jpg?code=' . mt_rand(9999, 999999), array('class' => 'SecurImage', 'style' => "left: 13px;position: absolute;top: 10px;
                        z-index: 1;", 'id' => rand()));
                                    echo $this->AdminForm->control('security_code', [
                                        'placeholder' => 'Security Code', 'type' => 'text','required'=>true,
                                        'class' => 'required', 'style' => "padding-left: 140px;", 'label' => false,
                                        'templates' => ['inputContainer' => '<div class="form-area">{{content}}</div>']
                                    ]);
                                    if (!empty($error_captcha)) :
                                    ?>
                                        <div class='error-message'><?= $error_captcha ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
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
                                'class' => 'required','required'=>true,
                                'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                            ]);
                            echo $this->Form->control('message', [
                                'placeholder' => 'Your Message', 'type' => 'textarea',
                                'class' => 'required','required'=>true,
                                'class' => 'required','required'=>true,
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
        <img src="/img/icon/dots-bakground.svg" alt="">

    </div>
</section>

<?= $this->Form->end() ?>

<script>
    // var branches = JSON.parse('<?= json_encode($branchesList) ?>');
    // var branchesDetails = JSON.parse('<?= json_encode($branches) ?>');

    // $(document).ready(function() {
    //     $('#country').on('change', function() {

    //         selectedCountry = $(this).val();
    //         if (selectedCountry != '' && selectedCountry != undefined) {

    //             var branchs = branches[selectedCountry];
    //             $('#city').html('<option value="">Select Branch</option>');


    //             if (branchs) {
    //                 $.each(branchs, function(key, value) {
    //                     $('#city').append('<option value="' + key + '">' + value + '</option>');;
    //                 });
    //             }
    //         }
    //     });

    //     $('#city').on('change', function() {

    //         selectedBranch = $(this).val();
    //         if (selectedBranch != '' && selectedBranch != undefined) {

    //             var branchDetails = branchesDetails[selectedBranch];


    //             if (branchDetails) {

    //                 $('#brnachID').val(branchDetails['id']);
    //                 $('#branch-name').html(branchDetails['name']);
    //                 details = '<li>' + branchDetails['address'] + ',' + branchDetails['city'] + ',' + branchDetails['state'] + ',' + branchDetails['postcode'] + ',' + branchDetails['country'] + '</li>';
    //                 details += '<li>' + branchDetails['phone'] + '</li>';
    //                 details += '<li>' + branchDetails['mobile'] + '</li>';
    //                 details += '<li>' + branchDetails['email'] + '</li>';
    //                 $('#branch-details').prepend(details);

    //                 if (branchDetails['facebook'] != null)
    //                     $('.facebook').attr('href', branchDetails['facebook']);
    //                 if (branchDetails['youtube'] != null)
    //                     $('.youtube').attr('href', branchDetails['youtube']);
    //                 if (branchDetails['instagram'] != null)
    //                     $('.instagram').attr('href', branchDetails['instagram']);
    //                 if (branchDetails['twitter'] != null)
    //                     $('.twitter').attr('href', branchDetails['twitter']);
    //                 if (branchDetails['linkedin'] != null)
    //                     $('.linkedin').attr('href', branchDetails['linkedin']);

    //             }
    //         }
    //     });
    // });
</script>
<script>
    function onSubmit(token) {
        document.getElementById("contactusForm").submit();
    }
</script>

<?php echo $this->Html->script('new-js/jquery.validate'); ?>

<script src='https://www.google.com/recaptcha/api.js?render=<?php echo CAPTCHA_SITE_KEY; ?>'></script>
<script>
    var number = 0;

    function reLoadCaptchaV3() {

        grecaptcha.execute('<?php echo CAPTCHA_SITE_KEY; ?>', {
                action: 'homepage'
            })
            .then(function(token) {
                //console.log(token);
                $('#g-recaptcha-response').val(token);
            });
        // });
    }
    grecaptcha.ready(function() {
        reLoadCaptchaV3();
    });
</script>

<script type="text/javascript">
    var request_busy = false;
    $(function() {
        setInterval(function() {
            reLoadCaptchaV3();
        }, 2 * 60 * 1000);
        $('#contactusForm').validate({
            rules: {
                'country': {
                    required: true,
                },
                'city': {
                    required: true,
                },
                'name': {
                    required: true,
                },
                'phone': {
                    required: true,
                    minlength: 10,
                    maxlength: 13
                },
                'email': {
                    required: true,
                    email: true
                },
                // 'email_confirm': {
                //     required: true,
                //s },
                'subject': {
                    required: true,
                },
                'message': {
                    required: true
                },
            },
            messages: {

            },
            errorClass: "error-message",
            errorElement: "div",
            errorPlacement: function(error, element) {
                error.insertAfter(element, false);
            },
            submitHandler: function(form) {
                form.submit();
                // contactusSubmitForm(form, true);
            }
        });

        contactusSubmitForm = function(form, register) {

            if (!request_busy) {

                // $('body').LoadingOverlay("show");

                request_busy = true;
                // $('#registerbox .modal').append("<div class='remodal-loading'></div>");
                $.ajax({
                    type: "POST",
                    url: $(form).prop('action'),
                    data: $(form).serialize(),
                    dataType: 'json',
                }).done(function(data) {
                    request_busy = false;
                    $('.remodal-loading').remove();
                    console.log(data.status);
                    if (data.status) {


                        notification('success', data.message, data.title);


                        $('.error-message').remove();
                        $(form)[0].reset();

                        reLoadCaptchaV3();

                    } else {

                        // $('body').LoadingOverlay("hide");

                        notification('error', data.message, data.title);

                        var rmodal_id = 'modal';

                        reLoadCaptchaV3();
                        $('.error-message').remove();
                        if (data['validationErrors']) {
                            for (i in data.validationErrors) {
                                if (typeof(data.validationErrors[i]) === 'object') {
                                    var errors_array = data.validationErrors[i];
                                    for (j in errors_array) {
                                        $(form).find('*[name="' + i + '"]').parent().append('<div class="error-message">' + errors_array[j] + '</div>');
                                    }
                                } else {
                                    $(form).find('*[name="' + i + '"]').parent().append('<div class="error-message">' + data.validationErrors[i] + '</div>');
                                }
                            }
                        }

                    }
                });

                // $('body').LoadingOverlay("hide");
            }
        }
        // var elem = $('#' + window.location.hash.replace('#', ''));
        // if (elem) {
        //     setTimeout(function() {
        //         $('html, body').animate({
        //             scrollTop: elem.offset().top - 50
        //         }, 2000);
        //     }, 2000);
        // }
    });
</script>