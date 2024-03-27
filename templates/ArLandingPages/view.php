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

                <form class="contact-form">
                    <div class="input-group">
                        <label for>Your name</label>
                        <input type="text" id="name" name="name" placeholder="Enter your name" required>
                    </div>
                    <div class="input-group">
                        <label for>Email address</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="input-group">
                        <label for>Your message</label>
                        <textarea id="message" name="message" placeholder="Enter your message" required></textarea>
                    </div>
                    <button type="submit" class="btn contact-submit">Send</button>
                </form>
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