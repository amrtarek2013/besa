<style type="text/css">
    .cursor-pointer {
        cursor: pointer;
    }

    .content strong {
        font-weight: bold !important;
    }
</style>
<?php
$Categories = $this->App->getInstance('Categories');
$categories_list = $Categories->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();

$categories_text = "";
$show_categories = explode(",", trim($recordedVideo['categories'], ","));
foreach ($show_categories as $category_val) {
    $categories_text .= $categories_list[$category_val] . ", ";
}
$categories_text = rtrim($categories_text, ", ");
?>
<!-- Start  Header -->
<section class="header">
    <div class=" Fixed-header">
        <div class="item">
            <img src="<?= $recordedVideo['full_width_image_path'] ?>" alt="">
            <div id="overlay_header-bottom"></div>

            <!-- <img src="<?php //!empty($recordedVideo['full_width_image_path'])?$recordedVideo['full_width_image_path']:'/images/ackground-show.png'
                            ?>" alt=""> -->
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="content">
                            <div class="text">
                                <h2><?= !empty($recordedVideo['cast']) ? $recordedVideo['cast'] . ' - ' : '' ?><?= $recordedVideo['title'] ?> </h2>
                                <h4><?= $categories_text ?></h4>
                                <p class="">
                                    <?= $recordedVideo['description'] ?>
                                </p>
                            </div>
                            <div class="box">
                                <div class="image">
                                    <img src="<?= $recordedVideo['thumb_path'] ?>" alt="">
                                </div>
                                <div class="text">
                                    <div class="icon">

                                        <?php if ($this->Session->check('Auth.Users') && isset($is_subscribed)) : ?>
                                            <?php if (false) { ?>
                                                <i class="fa fa-play-circle fa-4x cursor-pointer" data-remodal-target="playVideo" onclick="playVideo('<?= $recordedVideo['video'] ?>')"></i>
                                            <?php } ?>

                                            <img src="/images/Icons_original/Circle_Play_Button.svg" data-remodal-target="playVideo" onclick="playVideo('<?= $recordedVideo['video'] ?>')">

                                        <?php else : ?>
                                            <img src="/images/Icons_original/Circle_Play_Button.svg" id="not_subscribed_msg">
                                        <?php endif; ?>
                                        <div>
                                            <p><a class="cursor-pointer" data-remodal-target="playVideo" onclick="playVideo('<?= $recordedVideo['video'] ?>')">Start Here</a></p>
                                            <?php
                                            if (
                                                !empty($recordedVideo['video_length_hours']) ||
                                                !empty($recordedVideo['video_length_minutes']) ||
                                                !empty($recordedVideo['video_length_seconds'])
                                            ) { ?>
                                                <p>
                                                    <?php
                                                    if (!empty($recordedVideo['video_length_hours']) && $recordedVideo['video_length_hours'] > 0) {
                                                        echo $recordedVideo['video_length_hours'] . " hours ";
                                                    }
                                                    if (!empty($recordedVideo['video_length_minutes']) && $recordedVideo['video_length_minutes'] > 0) {
                                                        echo $recordedVideo['video_length_minutes'] . " minutes ";
                                                    }
                                                    if (!empty($recordedVideo['video_length_seconds']) && $recordedVideo['video_length_seconds'] > 0) {
                                                        echo $recordedVideo['video_length_seconds'] . " seconds ";
                                                    }
                                                    ?>
                                                </p>
                                            <?php } ?>

                                        </div>
                                    </div>
                                    <p><?php echo $recordedVideo['summary'] ?></p>

                                </div>
                            </div>
                            <p class="out-box"><span><strong>Languages:</strong> <?= $recordedVideo['language'] ?></span> <strong>Subtitles:</strong> <?= $recordedVideo['subtitles'] ?> </p>
                            <?php if (false) { ?>
                                <p class="out-box"><strong>Cast:</strong> <?= $recordedVideo['cast'] ?></p>
                            <?php } ?>

                            <?php

                            $favClass = '';
                            $faVAction = 'add';
                            $heart_class = "fa-heart";
                            if (in_array($recordedVideo['id'], $favourites_for_layout[3])) {
                                $favClass = ' addedTOFav';
                                $faVAction = 'delete';
                                $heart_class = "fa-heart-o";
                            }
                            ?>

                            <div class="fav">
                                <div class="icon-love <?= $favClass ?>" id="fav_<?= $recordedVideo['id'] ?>" onclick="addFavourites('<?= $recordedVideo['id'] ?>', 3,'<?= $recordedVideo['id'] ?>', '<?= $faVAction ?>')">
                                    <i class="fa <?= $heart_class ?>"></i>
                                </div>
                                <p>Add to Favourites</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>

    </div>
</section>
<!-- End  Hedaer -->

<!-- start Concert  -->
<section id="concert " class="concert ">
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="tabes">
                    <a class="active"> Other Videos</a>
                </div>
            </div>

            <div class="col-md-12">
                <div class="mytab hiddenSmallScreen">
                    <?php
                    if (!empty($otherVideos)) {
                        foreach ($otherVideos as $recordedVideo) {
                    ?>
                            <div class="box">

                                <div class="image">
                                    <a href="<?= $this->Url->build('/show/' . $recordedVideo['id']) ?>">
                                        <img src="<?= $recordedVideo['thumb_path'] ?>" alt="">
                                    </a>
                                </div>
                                <div class="text">

                                    <a href="<?= $this->Url->build('/show/' . $recordedVideo['id']) ?>">
                                        <h5><?= !empty($recordedVideo['cast']) ? $recordedVideo['cast'] . ' - ' : '' ?><?= $recordedVideo['title'] ?> </h5>
                                    </a>
                                    <p><?= $recordedVideo['summary'] ?> </p>
                                    <p class="last">
                                        <?php if (!empty($recordedVideo['advice'])) { ?>
                                            <span>Advice: <?= $recordedVideo['advice'] ?></span>
                                        <?php } ?>

                                        <span class="center">
                                            <?php
                                            if (!empty($recordedVideo['video_length_hours']) && $recordedVideo['video_length_hours'] > 0) {
                                                echo $recordedVideo['video_length_hours'] . " hours ";
                                            }
                                            if (!empty($recordedVideo['video_length_minutes']) && $recordedVideo['video_length_minutes'] > 0) {
                                                echo $recordedVideo['video_length_minutes'] . " minutes ";
                                            }
                                            if (!empty($recordedVideo['video_length_seconds']) && $recordedVideo['video_length_seconds'] > 0) {
                                                echo $recordedVideo['video_length_seconds'] . " seconds ";
                                            }
                                            ?>
                                        </span>

                                        <?php
                                        if (empty($recordedVideo['end_date'])) {
                                            echo "<span></span>";
                                        } else {
                                            echo "<span>Available until " . $recordedVideo->end_date->format('d M Y') . "</span>";
                                            // echo date('d M Y', $recordedVideo['end_date']) ;
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <!-- <div class="col-md-12">
                <div class="view-more hiddenSmallScreen">
                    <button class="bttn ">View-more</button>
                </div>
            </div> -->
            <!--  For mobile-->
            <div class="col-md-12">
                <div class="myTabMobile">


                    <?php

                    if (!empty($otherVideos)) {
                        foreach ($otherVideos as $recordedVideo) {
                    ?>
                            <div class="box">


                                <div class="icon">
                                    <i class="fa fa-play-circle fa-4x"></i>
                                    <div class="text">
                                        <p>1. Episode 1</p>
                                        <a href="<?= $this->Url->build('/show/' . $recordedVideo['id']) ?>">
                                            <p><?= $recordedVideo['title'] ?> </p>
                                        </a>
                                        <p><span><?= $recordedVideo['video_length'] ?>min</span>Available until <?= date('d M Y', $recordedVideo['data']) ?></p>

                                    </div>

                                </div>
                                <div class="arrowDescrp">
                                    <i class="fa fa-angle-up fa-large"></i>
                                    <i class="fa fa-angle-down fa-large displayNone" style="padding-top: 2px;"></i>
                                </div>
                                <div class="drscrp">
                                    <p><?= $recordedVideo['description'] ?> </p>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Concert  -->
<?php
$notf_msg = "";
if (!empty($FlashMessagePopSnippet)) {
    $notf_msg = str_replace('"', "'", $FlashMessagePopSnippet);
    $notf_msg = str_replace("\n", "", $notf_msg);
    $notf_msg = str_replace(array("\n", "\r"), '', $notf_msg);
}
$pop_up_image = "";
if (!empty($FlashMessagePopSnippet_image)) {
    $pop_up_image = $FlashMessagePopSnippet_image;
}

?>
<script type="text/javascript">
    if ($("#not_subscribed_msg").length) {
        $("#not_subscribed_msg").click(function() {
            var ss = "<?= $notf_msg ?>";
            var pop_up_image = "<?= $pop_up_image ?>";
            notificationSnippet(ss, '', pop_up_image, "freeze");
        });
    }
</script>