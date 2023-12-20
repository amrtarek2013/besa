<div class="hero-section hero-placement Pathway-Programs">
    <div class="container-fluid">
        <div class="col-md-6">
            <div class="img-hero">
                <img src="<?= WEBSITE_URL ?>img/new-desgin/hero-Pathway-Programs.png" alt="hero Young learners">
            </div>
        </div>
        <div class="col-md-6">
            <h1 class="title-hero">Pathway  <span>Programs</span> </h1>
        </div>
    </div>
</div>

<div class="list-Pathway-Programs">
    <?= $this->element('placement_list', ['placementList' => $pathwayPrograms]); ?>

</div>


<?= $book_free_meeting ?>