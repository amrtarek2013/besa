<div class="hero-section hero-learners">
    <div class="container-fluid">
        <div class="col-md-6">
            <div class="img-hero">
                <img src="<?= WEBSITE_URL ?>img/new-desgin/hero-learners.png" alt="hero Young learners">
            </div>
        </div>
        <div class="col-md-6">
            <h1 class="title-hero">Young Learners </h1>
        </div>
    </div>

</div>

<?= $this->element('placement_list', ['placementList' => $youngLearners]); ?>
<?= $book_free_meeting ?>