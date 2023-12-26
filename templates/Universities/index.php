<section class="hero-country hero-Universities">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="image-container">
                    <img src="<?= WEBSITE_URL ?>img/new-desgin/ottawa-parliament-hill-building.png" alt="hero Universities">
                    <div class="text-container">
                        <a class="" href="<?php // Router::url('/user/register') ?>">
                            <h3> <span>Universities </span> in Canada</h3>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="universities-section absolute">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="container-universities">
                    <div class="header-box">
                        <div class="title-left">
                            <img src="<?= WEBSITE_URL ?>img/new-desgin/university-icon.svg" alt="Canadian Flag Icon">

                            <h4>Universities in Canada</h4>
                        </div>
                        <a href="#" class="link-see-more">
                            See All <img src="<?= WEBSITE_URL ?>img/new-desgin/arrow right.svg" alt="Arrow Icon">
                        </a>
                    </div>
                    <div class="grid-universities">
                        <?php foreach ($universities as $university) : ?>
                            <div class="university">
                                <div class="header-box">
                                    <div class="logo">
                                        <img src="<?= $university['logo_path'] ?>" alt="This Is University Img 1" loading="lazy">

                                        <h5><?= $university['university_name'] ?></h5>
                                    </div>
                                    <div class="icon-favorite">
                                        <i class="fa-regular fa-heart fa-lg"></i>
                                    </div>
                                </div>
                                <div class="university-info">
                                    <p><?= $university['short_description'] ?></p>
                                </div>
                                <a href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['universitycourses.index']) ?>/<?= $university['id'] ?>/<?= $university['permalink'] ?>/2" class="btn apply-now-btn">Apply now</a>

                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class=" blogs-banner">

    <div class="blogs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">


                    <?php if (!empty($universities)) : ?>
                        <?php $counter = 0; ?>

                        <div class="display-flex">
                            <?php foreach ($universities as $university) : ?>
                                <?php $counter++; ?>
                                <div class="box-blog display-flex">
                                    <img src="<?= $university['logo_path'] ?>" alt="This Is University Img 1" loading="lazy">
                                    <div class="content-blog">
                                        <p class="title"><?= $university['university_name'] ?></p>
                                        <p><?= $university['short_description'] ?></p>
                                        <a href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['universitycourses.index']) ?>/<?= $university['id'] ?>/<?= $university['permalink'] ?>/2" class="read-anchor">Check Courses</a>
                                    </div>
                                </div>

                                <?php
                                if ($counter % 2 == 0) {
                                    echo '</div><div class="display-flex">';
                                }
                                ?>

                            <?php endforeach; ?>

                            <?php
                            if ($counter % 2 != 0) {
                                echo '<div class="box-blog display-flex"></div>';
                            }
                            ?>
                        </div>

                        <?php if (sizeof($universities) == 20) : ?>
                            <div class="paginator">
                                <ul class="pagination">
                                    <?= $this->Paginator->first(' << ') ?>
                                    <?= $this->Paginator->prev(' < ') ?>
                                    <?= $this->Paginator->numbers() ?>
                                    <?= $this->Paginator->next(' > ') ?>
                                    <?= $this->Paginator->last(' >> ') ?>
                                </ul>
                                <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <!-- <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>

                    <ul class="pagination">
                        <?php
                        echo $this->Paginator->prev('&laquo;', array('tag' => 'li', 'escape' => false), '<a href="#">&laquo;</a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
                        echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'active', 'currentTag' => 'a'));
                        echo $this->Paginator->next('&raquo;', array('tag' => 'li', 'escape' => false), '<a href="#">&raquo;</a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
                        ?>
                    </ul> -->
                </div>
            </div>
        </div>
    </div>
</section>