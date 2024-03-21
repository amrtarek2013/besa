<div class="universities-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="container-universities">
                    <div class="header-box">
                        <div class="title-left">
                            <img src="<?= WEBSITE_URL ?>img/new-desgin/university-icon.svg" alt="Canadian Flag Icon">

                            <h4><?= isset($sectionTitle) ? $sectionTitle : 'Universities' ?> </h4>
                        </div>
                        <a href="<?= isset($seeAllLink) ? $seeAllLink : '#' ?>" class="link-see-more search-type" data-stype="u">
                            See All <img src="<?= WEBSITE_URL ?>img/new-desgin/arrow right.svg" alt="Arrow Icon">
                        </a>
                    </div>
                    <div class="grid-universities">
                        <?php

                        use Cake\Routing\Router;

                        $countriesList = !is_array($countriesList) ? $countriesList->toArray() : $countriesList;
                        // print_r($uniWishLists);
                        // dd($universitiesResults);
                        foreach ($universitiesResults as $univ) :
                        ?>
                            <div class="university">
                                <div class="header-box">
                                    <div class="logo">
                                        <!-- <img src="<?= WEBSITE_URL ?>img/new-desgin/logo-university.png" alt="<?= $univ['university_name'] ?> Logo">
                                        <h5><?= $univ['university_name'] ?></h5> -->
                                        <img src="<?= $univ['logo_path'] ?>" alt="<?= $univ['university_name'] ?> Logo">
                                        <h5><a class="link" href="<?= Router::url('/' . $g_dynamic_routes['universities.details'] . '/') . $univ['permalink'] ?>"><?= $univ['university_name'] ?></a></h5>
                                    </div>
                                    <div class="icon-favorite addingUniwish" data-univid="<?= $univ['id'] ?>" data-action="<?= isset($uniWishLists[$univ['id']]) ? 'delete' : 'add' ?>">
                                        <i id="wishuni-<?= $univ['id'] ?>" class="<?= isset($uniWishLists[$univ['id']]) ? 'fa-solid' : 'fa-regular' ?> fa-heart fa-lg"></i>
                                    </div>
                                </div>
                                <div class="university-info">
                                    <p><?= $countriesList[$univ['country_id']] ?></p>

                                </div>
                                <?php
                                debug($countriesList);
                                debug($univ);

                                $queryParams = $this->request->getQueryParams();
                                $queryParams['stype'] = 'c'; // Change 'newValue' to your desired value
                                $queryParams['university_id'] = $univ['university_id']; // Change 'newValue' to your desired value
                                $queryString = http_build_query($queryParams);
                                // Concatenate the base URL with the new query string
                                $newUrl = Cake\Routing\Router::url('/results') . '?' . $queryString;


                                ?>
                                <a href="<?= $newUrl ?>" class=" btn apply-now-btn">Check Courses</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    var current_controller = '<?= strtolower($this->request->getParam('controller')) ?>';
    var current_action = '<?= strtolower($this->request->getParam('action')) ?>';
    var busy = false;
    var isLoggedIn = '<?= isset($_SESSION['Auth']['User']) ? 1 : 0 ?>';

    $(document).on('click', '.addingUniwish', function(e) {

        if (isLoggedIn == 0) {
            $('.modalMsg .remodal-cancel').show();
            $('.modalMsg #msgText').html('Please register first!');
            var inst = $('[data-remodal-id=modalMsg]').remodal();
            inst.open();

            $(document).on('confirmation', '.modalMsg', function(e) {

                window.location.assign('<?= Router::url('/') ?>user/register');
            });
        } else if (!busy) {
            let el = this;
            busy = true;
            let universityid = $(el).data('univid');

            $.ajax({
                url: "/wish-lists/add-uni/" + universityid + "/" + $(el).data('action'),
                method: "get",
                data: {},
                success: function(result) {


                    result = JSON.parse(result);

                    if (result.status != 'deleted') {
                        $(el).data('action', 'delete');

                        $(el).attr('data-action', 'delete');
                        $(el).prop('data-action', 'delete');
                        $('i#wishuni-' + universityid).removeClass('fa-regular').addClass('fa-solid');
                    } else {
                        $(el).data('action', 'add');

                        $(el).attr('data-action', 'add');
                        $(el).prop('data-action', 'add');
                        $('i#wishuni-' + universityid).removeClass('fa-solid').addClass('fa-regular');

                        if (current_controller == 'wishlists')
                            $('#box-result-' + universityid).hide(3000);

                    }

                    $('.modalMsg #msgText').html(result.message);
                    var inst = $('[data-remodal-id=modalMsg]').remodal();
                    inst.open();

                    busy = false;

                }
            });
        }
    });
</script>