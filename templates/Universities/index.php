<section class="main-banner banner-about-us blogs-banner">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7">
                <div class="background-banner-color">
                    <img src="<?= WEBSITE_URL ?>img/hero-bg45.png" alt="">
                    <img src="<?= WEBSITE_URL ?>img/dots-153.png" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-5">
                <div class="relative-box-about ">
                    <h1 class="relative-text">Universities</h1>
                    <h2 class="title text-left">Universities</h2>
                </div>
            </div>

        </div>
    </div>

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
                                    <img src="<?= $university['image_path'] ?>" alt="This Is University Img 1" loading="lazy">
                                    <div class="content-blog">
                                        <p><?= $university['title'] ?></p>
                                        <p><?= $university['short_description'] ?></p>
                                        <a href="/blog-details/<?= $university['permalink'] ?>" class="read-anchor">READ MORE</a>
                                    </div>
                                </div>

                                <?php
                                if ($counter % 2 == 0) {
                                    echo '</div><div class="display-flex">';
                                }
                                ?>

                            <?php endforeach; ?>

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
                        </div>

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