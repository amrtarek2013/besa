<div class="hero-section hero-placement">
    <div class="container-fluid">
        <div class="col-md-6">
            <div class="img-hero">
                <img src="<?= WEBSITE_URL ?>img/new-desgin/hero-Placements.png" alt="hero Young learners">
            </div>
        </div>
        <div class="col-md-6">
            <h1 class="title-hero">University <span>Placements</span> </h1>
        </div>
    </div>
</div>

<?=$this->element('placement_list', ['placementList' => $universityPlacements]); ?>

<?= $book_free_meeting ?>