<section class="">

    <div class="container" >
        <div class="row">
            <div class="col-md-12">
                <div class="stats-section">
                    <header class="stats-header">
                        <h1>Students' Applications Stats</h1>
                        <div class="filter">
                            <select>
                                <option value="week">Week</option>
                                <!-- More options -->
                            </select>
                        </div>
                        <div class="legend">
                            <span class="legend-item apply">
                                <div class="color-square"></div> Apply
                            </span>
                            <span class="legend-item application-pass">
                                <div class="color-square"></div>Application Pass
                            </span>
                            <span class="legend-item university-offer">
                                <div class="color-square"></div>University's offer
                            </span>
                            <span class="legend-item joined-university">
                                <div class="color-square"></div> Joined the University
                            </span>
                            <span class="legend-item apply-fail">
                                <div class="color-square"></div> Apply Failed
                            </span>

                        </div>
                    </header>
                    <div class="stats-content">
                        <?php foreach ($usersApp as $userApp) : ?>
                            <div class="stats-row">
                                <span class="student-name"><?= $userApp['first_name'] . ' ' . $userApp['last_name'] ?></span>
                                <div class="progress-bars">
                                    <?php
                                    $appClass = 'app-not-apply';
                                    $appText = "";
                                    if (!empty($userApp['applications'])) {

                                        if ($userApp['applications'][0]['status'] == $statusLabel['Joined Successfully']) {
                                    ?>
                                            <div class="progress-bar apply" style="width: 10%;"></div>
                                            <div class="progress-bar application-pass" style="width: 20%;"></div>
                                            <div class="progress-bar university-offer" style="width: 30%;"></div>
                                            <div class="progress-bar joined-university" style="width: 40%;"></div>
                                        <?php
                                        } else if ($userApp['applications'][0]['status'] == $statusLabel['Rejected']) {
                                        ?>
                                            <div class="progress-bar apply" style="width: 10%;"></div>
                                            <div class="progress-bar apply-fail" style="width: 20%;"></div>
                                        <?php
                                        } else if ($userApp['applications'][0]['status'] == $statusLabel['University Offer']) {

                                        ?>
                                            <div class="progress-bar apply" style="width: 10%;"></div>
                                            <div class="progress-bar application-pass" style="width: 20%;"></div>
                                            <div class="progress-bar university-offer" style="width: 30%;"></div>
                                            <div class="progress-bar joined-university" style="width: 40%;"></div>
                                        <?php
                                        } else if ($userApp['applications'][0]['status'] == $statusLabel['Application Pass']) {

                                        ?>
                                            <div class="progress-bar apply" style="width: 10%;"></div>
                                            <div class="progress-bar application-pass" style="width: 20%;"></div>
                                        <?php
                                        } else {

                                        ?>
                                            <div class="progress-bar apply" style="width: 10%;"></div>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <div class="progress-bar apply-fail" style="width: 20%;"></div>
                                    <?php
                                    }
                                    ?>
                                    <!-- <div class="progress-bar apply" style="width: 10%;"></div>
                                    <div class="progress-bar application-pass" style="width: 20%;"></div>
                                    <div class="progress-bar university-offer" style="width: 30%;"></div>
                                    <div class="progress-bar joined-university" style="width: 40%;"></div>
                                    <div class="progress-bar apply-fail" style="width: 20%;"></div> -->

                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if (false) : ?>
                        <div class="container-formBoxs">
                            <div class="">
                                <div class="card-body">
                                    <div class="responsive-container" style="overflow: scroll;">
                                        <table id="Table" class="table table-striped projects" cellpadding="0" cellspacing="0" width="100%">
                                            <thead>
                                                <tr class="table-header">
                                                    <td class=""></td>
                                                    <td class="" style="width: 15% !important; ">Apply</td>
                                                    <td class="">Application's Pass</td>
                                                    <td class="">University's Offer</td>
                                                    <td class="">Joined Successfuly</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($usersApp as $userApp) : ?>
                                                    <tr class="user-status">
                                                        <td class='user-name'><?= $userApp['first_name'] . ' ' . $userApp['last_name'] ?></td>
                                                        <td colspan="4">
                                                            <div class="progressbar">
                                                                <?php
                                                                $appClass = 'app-not-apply';
                                                                $appText = "";
                                                                if (!empty($userApp['applications'])) {

                                                                    $appClass = 'app-apply';
                                                                    if ($userApp['applications'][0]['status'] == $statusLabel['Joined Successfully']) {

                                                                        $appClass = 'app-completed';
                                                                    } else if ($userApp['applications'][0]['status'] == $statusLabel['Rejected']) {

                                                                        $appClass = 'app-apply-fail';
                                                                        $appText = "<span class='app-fail-text'>Application Failed</span>";
                                                                    } else if ($userApp['applications'][0]['status'] == $statusLabel['University Offer']) {

                                                                        $appClass = 'app-uni-offer';
                                                                    } else if ($userApp['applications'][0]['status'] == $statusLabel['Application Pass']) {

                                                                        $appClass = 'app-apply-pass';
                                                                    }
                                                                } else {
                                                                    $appText = "<span class='app-fail-text'>Didn't Apply</span>";
                                                                }

                                                                ?>
                                                                <div class="<?= $appClass ?>"></div> <?= $appText ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>