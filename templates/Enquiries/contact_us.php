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
<div class="hero-section hero-contact">
    <div class="container-fluid">
        <div class="col-md-6">
            <div class="img-hero icon-pencil-note">
                <img src="<?= WEBSITE_URL ?>img/new-desgin/hero-contact.png" alt="hero contact us ">
            </div>
        </div>
        <div class="col-md-6">
            <h1 class="title-hero">Contact Us </h1>
        </div>
    </div>
</div>
<div class="social-media">
    <div class="icons">
        <a href="<?= $g_configs['social_links']['txt.facebook_link'] ?>" class="facebook" target="_blank">
            <img src="<?= WEBSITE_URL ?>img/new-desgin/social-media/la_facebook.svg" alt="facebook">
        </a>
        <a href="<?= $g_configs['social_links']['txt.instagram_link'] ?>" class="instagram">
            <img src="<?= WEBSITE_URL ?>img/new-desgin/social-media/bi_instagram.svg" alt="Instagram">
        </a>
        <a href="<?= $g_configs['social_links']['txt.youtube_link'] ?>" class="youtube" target="_blank">
            <img src="<?= WEBSITE_URL ?>img/new-desgin/social-media/ant-design_youtube-outlined.svg" alt="YouTube">
        </a>
        <a href="<?= $g_configs['social_links']['txt.linkedin_link'] ?>" class="linkedin" target="_blank">
            <img src="<?= WEBSITE_URL ?>img/new-desgin/social-media/ant-design_linkedin-outlined.svg" alt="Linkedin">
        </a>
      
    </div>
</div>
<section class="main-banner contact-banner">
    
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
                <img src="<?= WEBSITE_URL ?>img/icon/facebook.svg" alt="">
            </a>
            <a href="<?= $g_configs['social_links']['txt.instagram_link'] ?>" class="instagram">
                <img src="<?= WEBSITE_URL ?>img/icon/instagram.svg" alt="" target="_blank">
            </a>
            <a href="<?= $g_configs['social_links']['txt.youtube_link'] ?>" class="youtube" target="_blank">
                <img src="<?= WEBSITE_URL ?>img/icon/youtube.svg" alt="">
            </a>
            <a href="<?= $g_configs['social_links']['txt.linkedin_link'] ?>" class="linkedin" target="_blank">
                <img src="<?= WEBSITE_URL ?>img/icon/linkedin.svg" alt="">
            </a>
            <a href="<?= $g_configs['social_links']['txt.tiktok_link'] ?>" class="tiktok" target="_blank">
                <img src="<?= WEBSITE_URL ?>img/icon/tiktok.svg" alt="">
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
                    <img src="<?= WEBSITE_URL ?>img/smiling-handsome-business-leader-making-notes 1.png" alt="">
                </div>

                <div class="text">
                    <h2>
                        Book a <span> free meeting </span> with <br> our counselors, experts in <br> study abroad enquiries
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
                                <p class="time-blue">
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

                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->Flash->render() ?>
<?= $this->Form->create($enquiry, ['url' => '/enquiries/contactUs', 'id' => 'contactusForm']) ?>
<input type="hidden" id="type" name="type" value="contact-us">
<section class="contact-us pageContact">
   
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title-form">If you have any 
                    <span class="blue">questions</span> 
                    or want to <span class="blue">communicate with</span> 
                    us, <br> write to us via the following form
                </h2>                <!-- <form action=""> -->

                <?php //= $this->Form->create($enquiry, ['url'=>'/enquiries/contactUs','id' => 'contactusForm']) 
                ?>
                <input type="hidden" id="brnachID" value="" name="branch_id" placeholder="your name">

                <div class="container-formBox">
                    <div class="grid-container ">
                            <?php

                            echo $this->Form->control('name', [
                                'placeholder' => 'Your name', 'type' => 'text',
                                'class' => 'required', 'required' => true,
                                'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                            ]);
                            
                            echo $this->Form->control('surname', [
                                'placeholder' => 'Last Name ', 'type' => 'text',
                                'placeholder' => 'Last Name*', 'label' => 'Last Name*', 'required' => true,
                                'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                            ]);
                                    
                         
                            echo  $this->element('mobile_with_code', ['phone_label' => 'Mobile']);

                            echo $this->Form->control('email', [
                                'placeholder' => 'Email Address', 'type' => 'email',
                                'class' => 'required', 'required' => true,
                                'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                            ]);
                            ?>
                            <?= $this->element('security_code') ?>

                            <?php


                            echo $this->Form->control('message', [
                                'placeholder' => 'Your Message', 'type' => 'textarea',
                                'class' => 'required', 'required' => true,
                                'class' => 'required', 'required' => true,
                                'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}</div>']
                            ]);
                            ?>
                         
                            <!-- <button type="submit" class="g-recaptcha btn MainBtn submit" data-sitekey="6Lemf1EkAAAAAMnwcS1hUX3mEjXNKfFfIVTMrDGl" data-callback='onSubmit' data-action='submit'>Send</button> -->

                    </div>
                        <div class="form-area">
                            <input type="submit" value="Send" class="btn MainBtn submit">
                        </div>
                </div>
                    
            </div>

        </div>
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
    //                 if (branchDetails['tiktok'] != null)
    //                     $('.tiktok').attr('href', branchDetails['tiktok']);
    //                 if (branchDetails['linkedin'] != null)
    //                     $('.linkedin').attr('href', branchDetails['linkedin']);

    //             }
    //         }
    //     });
    // });
</script>
<script>
    // function onSubmit(token) {
    //     document.getElementById("contactusForm").submit();
    // }
</script>

<script src="/js/new-js/jquery.validate.js" async></script>


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
                'mobile': {
                    required: true,
                    minlength: 10,
                    maxlength: 13
                },
                'email': {
                    required: true,
                    email: true
                },
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
                // form.submit();
                enquirySubmitForm(form, true);
            }
        });

        contactusSubmitForm = function(form, register) {

            if (!request_busy) {

                $('body').LoadingOverlay("show");

                request_busy = true;
                // $('#registerbox .modalMsg').append("<div class='remodal-loading'></div>");
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


                        // notification('success', data.message, data.title);


                        $('.error-message').remove();
                        $(form)[0].reset();

                        reLoadCaptchaV3();

                    } else {

                        $('body').LoadingOverlay("hide");

                        // notification('error', data.message, data.title);


                        var rmodal_id = 'modalMsg';

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

                    $('.modalMsg #msgText').html(data.message);
                    var inst = $('[data-remodal-id=modalMsg]').remodal();
                    inst.open();
                });

                $('body').LoadingOverlay("hide");
            }
        }

    });
</script>