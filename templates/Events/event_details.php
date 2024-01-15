<?php
// $image_path = 'uploads' . DS . 'events' . DS . $event['image'];
// debug(WWW_ROOT . $image_path);
// debug($event);

// debug(file_exists(WWW_ROOT . $image_path));
use Cake\Routing\Router;
if($permalink=='education-fairs'){



?>

<div class="hero-section hero-education-fair">
    <div class="container-fluid">
        <div class="col-md-6">
            <div class="img-hero">
                <img src="<?= WEBSITE_URL ?>img/new-desgin/hero-education-fair.png" alt="hero about us">
            </div>
        </div>
        <div class="col-md-6">
            <h1 class="title-hero">International <span>Education Fair</span> </h1>
        </div>
    </div>

</div>

<section class="bottom-hero-section bottom-education-fair ">
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="">
                <div class="title-bottom-hero">
                    <?= $event['center_text'] ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if(false) { ?>
<div class="sec-upcoming">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4>Upcoming</h4>
                <h5>BESA Study Abroad Expo in Egypt</h5>
                <div class="text">
                    <p>Engage with university from diverse countries to learn more about study abroad  <br> 
                        inquiries, including admission requirements, partial scholarships, and registration <br>  
                        steps from A to Z!
                    </p>
                    <p style="font-weight: 500; font-size: 32px; margin-top:170px; color: #263238" > 
                        <span style="color: var(--text-color)">Entry is free!</span> 
                        Join us and pave the way <br> 
                        for your international education!
                    </p>
                </div>
            </div>
         
        </div>
    </div>
</div>
<?php }?>




<?php
/*if (isset($event['style'])) {
                ?>
                    <div class="col-md-6">
                        <div class="text ">
                            <?= $event['right_text'] ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="box-gray">

                            <?= $event['center_text'] ?>
                        </div>
                    </div>
                <?php } */ ?>
</section>

<?php //if (isset($_GET['test'])) { 
?>
<?php
if (!empty($event['left_text']) && $event['id'] == 7 && !empty($event['fair_events'])) {
    echo $event['left_text'];


    // if (isset($_GET['test'])) {
?>


    <div class="sec-upcoming" >
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php foreach ($event['fair_events'] as $fairEvent) { ?>
                        <div class="content">
                            <h3 style=""><?php// $fairEvent['title'] ?></h3>
                            <h4 class="location-center">
                                <img src="<?= WEBSITE_URL ?>img/new-desgin/location.svg" alt="">
                                 <?= $fairEvent['locations'] ?></h4>
                            <div class="grid-3col">                            
                                <div class="box date-time">
                                    <?= $fairEvent['dates'] ?>
                                </div>
                                <?php
                                //if (false) { 
                                ?>
                                <div class="box">
                                    <h3>Attending countries</h3>


                                    <?php
                                    if (!empty($fairEvent['countries'])) {
                                    ?>
                                        <div class="step-back-slider small-slider">
                                            <div class="image-gallery">
                                                <?php foreach ($fairEvent['countries'] as $img) { ?>
                                                    <div class="image-box" style="display: inline-block; margin: 5px; ">
                                                        <img src="<?= $img['flag_path'] ?>" alt="" style="width: 41.469px;height: 25.613px;">
                                                    </div>
                                                <?php } ?>
                                              

                                            </div>
                                            <h3>Attending countries</h3>
                                                <div class="grid-logos">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">
                                                    <img src="<?= WEBSITE_URL ?>img/new-desgin/dummy_image/120x35.png" alt="">

                                                </div>
                                        </div>

                                    <?php
                                    }
                                    ?>


                                </div>
                            </div>

                            <?php
                            if (!empty($fairEvent['universities'])) {
                            ?>
                                <div class=" step-back-slider logos-slider logo-slider-large">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h2 class="title_28">Attending Universities</h2>

                                                <div class="slider">
                                                    <div class="owl-carousel owl-logos-slider">
                                                        <?php

                                                        foreach ($fairEvent['universities'] as $img) {
                                                        ?>
                                                            <div class="item">
                                                                <div class="image-box">
                                                                    <img src="<?= $img['logo_path'] ?>" alt="">
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php
                            }
                            dd($g_dynamic_routes);
                            ?>


                        </div>
                        <a class="btn btn-register MainBtn" href="<?= Router::url('/'.$g_dynamic_routes['enquiries.visitorsapplication'].'?location=' . strtolower($fairEvent['title'])) ?>">Register Now</a>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>


<?php
}
// }

if (!empty($event['event_images'])) {
    echo $this->element('event-slider', ['slider_title' => $event['slider_title'], 'event_images' => $event['event_images']]);
}
?>





<?php
 
}
if($permalink=='the-british-trophy'){ ?>

<div class="hero-section hero-british-trophy">
    <div class="container-fluid">
        <div class="col-md-6">
            <div class="img-hero">
                <img src="<?= WEBSITE_URL ?>img/new-desgin/hero-british-trophy.png" alt="hero british trophy">
            </div>
        </div>
        <div class="col-md-6">
            <h1 class="title-hero">The British <span>Trophy</span> </h1>
        </div>
    </div>

</div>

<section class="bottom-hero-section bottom-british-trophy ">
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="">
                <div class="title-bottom-hero">
                    <h5 class="title-bottom">
                    The British Trophy is an <span class="blue">  annual football championship  </span>  <br> 
                    organised by BESA exclusively for <span class="blue">international schools</span> in Egypt. <br> Established in 2014
                    </h5>
                    <p class="description">this tournament has gained significance over the years and has become a tradition.</p>
                    <a href="#british-trophy-event-subscription" class="btn MainBtn">Subscribe in event</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="football-education-section">
    <div class="content">
        
                <p>Football teams from various international schools compete against each other  <br>
                     under the supervision of a designated school representative, usually the Physical <br> Education instructor.</p>
                <p>Each team consists of 7-9 players. Over the course of four days, 
                    <br> <br> multiple matches are played to secure advancement to subsequent rounds. The  <br> ultimate prize for the winning team is a week-long trip to the United Kingdom.</p>
                
                <div class="images-container">
                    <img src="https://dummyimage.com/1792x1024/d9d9d9/000000.png" alt="Students with trophy">
                    <img src="https://dummyimage.com/1792x1024/d9d9d9/000000.png" alt="Trophy">
                </div>
                
                <p>The primary objective of the British Trophy is to provide a gateway for Egyptian students to experience international educational opportunities and to promote the integration of physical education into the Egyptian school system.</p>
                <p>It offers a unique opportunity for senior students aged 15 to 18 to explore British universities and their campuses as part of the UK tour.</p>
         
    </div>
</section>


<div class="remodal remodal-form british-trophy-subscription-modal" data-remodal-id="british-trophy-event-subscription">
  <button data-remodal-action="close" class="remodal-close">
  <img src="<?= WEBSITE_URL ?>img/new-desgin/remodal-close.svg" alt="close remodal">

  </button>
  <h2>The British Trophy Event Subscription</h2>
  <form class="subscription-form">
    <div class="form-area">
      <label for="school-name">School name</label>
      <input type="text" id="school-name" placeholder="Enter school name" required>
    </div>
    <div class="form-area">
      <label for="work-email">Work Email</label>
      <input type="email" id="work-email" placeholder="Enter work email" required>
    </div>
    <div class="form-area">
      <label for="phone-number">Phone number</label>
      <input type="tel" id="phone-number" placeholder="Enter phone number" required>
    </div>
    <div class="form-area">
      <label for="email">Email</label>
      <input type="email" id="email" placeholder="Enter email" required>
    </div>
    <div class="form-area">
      <label for="file-upload">Upload attending students details</label>
      <input type="file" id="file-upload" required>
    </div>
    <div class="form-area ">
        <label for="" style="color:transparent;" class="hidden-mobile">`</label>
        <div class="checkbox-container">
            <div class="checkbox terms">
                <label for="terms-conditions">
                <input type="checkbox" id="terms-conditions" required> I agree to terms & conditions
                </label>
            </div>
            <div class="checkbox news">
                <label for="latest-news">
                <input type="checkbox" id="latest-news"> I'd like being informed about latest news and tips
                </label>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>


<!-- Remodal HTML structure for sponsor form -->
<div class="remodal remodal-form  british-trophy-sponsor-modal" data-remodal-id="british-trophy-sponsor">
  <button data-remodal-action="close" class="remodal-close">
    <img src="<?= WEBSITE_URL ?>img/new-desgin/remodal-close.svg" alt="close remodal">

  </button>
  <h2>Become a sponsor</h2>
  <form class="subscription-form">
      <div class="form-area">
        <label for="institution-name">Institution Name</label>
        <input type="text" id="institution-name" placeholder="Enter Institution Name" required>
      </div>
      <div class="form-area">
        <label for="contact-person-name">Contact Person Name</label>
        <input type="text" id="contact-person-name" placeholder="Enter Contact Person Name" required>
      </div>
      <div class="form-area">
        <label for="phone-number">Phone number</label>
        <input type="tel" id="phone-number" placeholder="Your phone number" required>
      </div>
      <div class="form-area">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Enter your email" required>
      </div>
    <button type="submit" class="btn btn-primary btn-submit">Submit</button>
  </form>
</div>


<?php
 
}?>

<?= $event['text'] ?>

<?= $this->element('BecomeSponsorPopUp') ?>


