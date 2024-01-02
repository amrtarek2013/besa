
<div class="hero-section hero-blogs">
    <div class="container-fluid">
        <div class="col-md-6">
            <div class="img-hero icon-pencil-note">
                <img src="<?= WEBSITE_URL ?>img/new-desgin/hero-blogs.png" alt="hero blogs ">
            </div>
        </div>
        <div class="col-md-6">
            <h1 class="title-hero">Blogs </h1>
        </div>
    </div>
</div>

<div class="blogs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                <?php
                    if (!empty($blogs)) : ?>
                        <?php $counter = 0; ?>
                    <div class="grid-blogs-container">
                    <?php foreach ($blogs as $blog) : ?>
                                <?php $counter++; ?>
                                <div class="box-blog display-flex">
                                    <img src="<?= $blog['image_path'] ?>" alt="This Is Blog Img 1" loading="lazy">
                                    <div class="content-blog">
                                        <h4><?= $blog['title'] ?></h4>
                                        <a href="<?= Cake\Routing\Router::url('/' . $g_dynamic_routes['blogs.details'] . '/' . $blog['permalink']) ?>" class="btn btn-secondary read-anchor">READ MORE</a>
                                    </div>
                                </div>

                               

                            <?php endforeach; ?>

                           
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
                </div>
            </div>
        </div>
    </div>