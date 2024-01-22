<?php

use Cake\Routing\Router;

if ($permalink == 'education-fairs') {
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
                <div class="col-md-12">
                    <div class="title-bottom-hero">
                        <?= $event['center_text'] ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    /* ?>
        <div class="sec-upcoming">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Upcoming</h4>
                        <h5>BESA Study Abroad Expo in Egypt</h5>
                        <div class="text">
                            <p>Engage with university from diverse countries to learn more about study abroad <br>
                                inquiries, including admission requirements, partial scholarships, and registration <br>
                                steps from A to Z!
                            </p>
                            <p style="font-weight: 500; font-size: 32px; margin-top:170px; color: #263238">
                                <span style="color: var(--text-color)">Entry is free!</span>
                                Join us and pave the way <br>
                                for your international education!
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    <?php */
    ?>

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

    <?php
    if (!empty($event['left_text']) && $event['id'] == 7 && !empty($event['fair_events'])) {
        echo $event['left_text'];

        echo $this->element('events/event_details', ['event' => $event]);
    ?>



    <?php
    }
    if (!empty($event['event_images'])) {
        echo $this->element('event-slider', ['slider_title' => $event['slider_title'], 'event_images' => $event['event_images']]);
    }
}
if ($permalink == 'the-british-trophy') {

    ?>

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
                <div class="col-md-12">
                    <div class="title-bottom-hero">
                        <h5 class="title-bottom">
                            The British Trophy is an <span class="blue"> annual football championship </span> <br>
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

            <p>Football teams from various international schools compete against each other <br>
                under the supervision of a designated school representative, usually the Physical <br> Education instructor.</p>
            <p>Each team consists of 7-9 players. Over the course of four days,
                <br> <br> multiple matches are played to secure advancement to subsequent rounds. The <br> ultimate prize for the winning team is a week-long trip to the United Kingdom.
            </p>

            <div class="images-container">
                <img src="https://dummyimage.com/1792x1024/d9d9d9/000000.png" alt="Students with trophy">
                <img src="https://dummyimage.com/1792x1024/d9d9d9/000000.png" alt="Trophy">
            </div>

            <p>The primary objective of the British Trophy is to provide a gateway for Egyptian students to experience international educational opportunities and to promote the integration of physical education into the Egyptian school system.</p>
            <p>It offers a unique opportunity for senior students aged 15 to 18 to explore British universities and their campuses as part of the UK tour.</p>

        </div>
    </section>

    <?php
    if ($event['id'] == 4 && !empty($event['fair_events'])) {

        echo $this->element('events/event_details', ['event' => $event]);
    }
    ?>
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
                            <input type="checkbox" id="terms-conditions" required>
                            <p>I agree to terms & conditions</p>
                        </label>
                    </div>
                    <div class="checkbox news">
                        <label for="latest-news">
                            <input type="checkbox" id="latest-news">
                            <p>I'd like being informed about latest news and tips</p>
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

} ?>

<?= $event['text'] ?>

<?= $this->element('BecomeSponsorPopUp') ?>