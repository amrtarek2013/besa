<!DOCTYPE html>
<html lang="ar">
<?php

$landing_page_assets = Cake\Routing\Router::url("/css/besa_landing_pages/");

debug($arLandingPage);

?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?php echo $landing_page_assets ?>css/style_rtl.css" />
    <title><?= isset($title) ? $g_configs['general']['txt.site_name'] . ' - ' . $title : $g_configs['general']['txt.site_name'] . ' - British Educational Services Group' ?></title>

</head>


<body>
    <div class="header">
        <div class="container">
            <div class="navbar flex-container">
                <div class="logo">
                    <img src="<?php echo $landing_page_assets ?>images/logo.png" />
                </div>
                <img src="<?php echo $arLandingPage['right_logo_path'] ?>" />
            </div>
        </div>
        <div class="container-fluid">
            <div class="hero flex-container">
                <div class="image">
                    <img src="<?php echo $arLandingPage['left_image_path'] ?>" alt />
                </div>

                <?php echo $arLandingPage['section_1'] ?>

            </div>
        </div>
    </div>


    <?php for ($i = 2; $i <= 7; $i++) {
        echo  $arLandingPage['section_' . $i];
    } ?>





    <!-- Contact Section -->
    <div class="contact">
        <div class="container">
            <h2 class="contact-heading bold-text ">تواصل معنا</h2>
            <p class="contact-subheading regular-text">اذا كان لديك أي استفسار أو
                مساعدة لا تتردد
                في التواصل معنا</p>
            <div class="contact-section" dir="ltr">



                <?= $this->Form->create($enquiry, ['url' => '/enquiries/contactUs', 'id' => 'contactusForm']) ?>

                <input type="hidden" id="type" name="type" value="landingpage-<?php echo $permalink ?>">

                <?php

                echo $this->Form->control('name', [
                    'placeholder' => 'Your name', 'type' => 'text', 'label' => false,
                    'class' => 'required', 'required' => true,
                    'templates' => ['inputContainer' => '<div class="input-group {{required}}">{{content}}</div>']
                ]);


                echo $this->Form->control('email', [
                    'placeholder' => 'Email Address', 'type' => 'email',
                    'class' => 'required', 'label' => false, 'required' => true,
                    'templates' => ['inputContainer' => '<div class="input-group {{required}}">{{content}}</div>']
                ]);

                // echo  $this->element('mobile_with_code', ['phone_label' => 'Mobile']);

                echo $this->Form->control('message', [
                    'placeholder' => 'Your Message', 'type' => 'textarea',
                    'class' => 'required', 'label' => false, 'required' => true,
                    'templates' => ['inputContainer' => '<div class="input-group {{required}}">{{content}}</div>']
                ]);
                ?>

                <?= $this->element('security_code') ?>
                <button type="submit" class="btn contact-submit">Send</button>


                <?= $this->Form->end() ?>





            </div>
        </div>
    </div>

    <?php
    echo  $arLandingPage['section_8'];
    ?>
    <?php
    echo  $arLandingPage['footer'];
    ?>

</body>

</html>