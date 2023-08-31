<style>
    .btn {
        color: blueviolet;
    }

    td {
        padding: 10px;
        border: 1px solid #33ca9424;
    }

    .table-header td {
        width: 20% !important;
    }

    .progressbar>div {
        background-color: var(--bs-light-blue);
        width: 46%;
        /* Adjust with JavaScript */
        height: 13px;
        float: left;
    }


    .progressbar .app-apply {
        width: 18%;
    }

    .progressbar .app-not-apply {
        width: 18%;

        background-color: unset;
        border: 1px solid #E3B505;
    }

    .progressbar .app-apply-pass {
        width: 46%;
    }

    .progressbar .app-apply-fail {
        width: 46%;
        background-color: unset;
        border: 1px solid #E3B505;
    }


    .progressbar .app-uni-offer {
        
        width: 75%;
    }

    .progressbar .app-completed {
        width: 100%;
        background-color: var(--bs-green);
    }

    .container-formBox table th,
    .container-formBox table td {
        border: none;
    }

    .app-fail-text {
        color: #E3B505;
        font-feature-settings: 'clig' off, 'liga' off;
        font-family: Poppins;
        font-size: 10px;
        font-style: normal;
        font-weight: 400;
        line-height: 127.5%;
        float: left;
        margin-left: 5px;
    }

    /* .container-formBox table th, */
    .container-formBox table th a,
    /* .container-formBox table td, */
    .container-formBox table td a {
        letter-spacing: 0.2px;
        color: #767B92;
        font-feature-settings: 'clig' off, 'liga' off;
        font-family: Poppins;
        font-size: 12px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }

    .container-formBox table th,
    .container-formBox table td {
        padding: 10px;
        color: #767B92;
        font-feature-settings: 'clig' off, 'liga' off;
        font-family: Poppins;
        font-size: 13.5px;
        font-style: normal;
        font-weight: 400;
        line-height: 208.5%;
        text-align: right !important;
    }

    .user-status td.user-name {
        text-align: left !important;
    }
</style>
<?php

// $statuses = [0 => 'Pendeing', 1 => 'Under-Review', 2 => 'Replied', 3 => 'Rejected', 4 => 'Approved'];
// $statusLabel = ['Pendeing' => 0, 'Under-Review' => 1, 'Replied' => 2, 'Rejected' => 3, 'Approved' => 4];
?>
<section class="register-banner">

    <div class="container" style="width:100%">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title text-left title-dash">Track & view your application</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="container-formBox">
                    <!-- <h4 class="title">Students</h4> -->
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
                                        <!-- <tr id="users_8">
                                            <td>Giselle</td>
                                            <td colspan="4">
                                                <div class="progressbar">
                                                    <div class="app-not-apply"></div><span class="app-fail-text">Didn't Apply</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr id="users_8">
                                            <td>Giselle</td>
                                            <td colspan="4">
                                                <div class="progressbar">
                                                    <div class="app-apply-fail"></div><span class="app-fail-text">Application Failed</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr id="users_8">
                                            <td>Giselle</td>
                                            <td colspan="4">
                                                <div class="progressbar">
                                                    <div class="app-apply-pass"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr id="users_8">
                                            <td>Giselle</td>
                                            <td colspan="4">
                                                <div class="progressbar">
                                                    <div class="app-uni-offer"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr id="users_8">
                                            <td>Giselle</td>
                                            <td colspan="4">
                                                <div class="progressbar">
                                                    <div class="app-completed"></div>
                                                </div>
                                            </td>
                                        </tr> -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php

                        // $statuses = [0 => 'Pendeing', 1 => 'Under-Review', 2 => 'Replied', 3 => 'Rejected', 4 => 'Approved'];


                        // // public $statusClasses = [0 => 'Pendeing', 1 => 'Under-Review', 2 => 'Replied', 3 => 'Rejected', 4 => 'Approved'];
                        // $statusLabel = ['Pendeing' => 0, 'Under-Review' => 1, 'Replied' => 2, 'Rejected' => 3, 'Approved' => 4];
                        // $fields = [
                        //     'basicModel' => 'users',
                        //     // 'id' => [],
                        //     // 'email' => [],
                        //     'first_name' => [],
                        //     // 'study_level.title' => ['title' => 'Study Level'],

                        //     'status' => ['format' => 'get_from_array', 'options' => ['items_list' => $statuses]],
                        // ];

                        // $multi_select_actions = array(
                        //     'delete' => array('action' => $this->Url->build(array('action' => 'delete_multi', 'Admin' => true)), 'confirm' => true)
                        // );


                        // $actions = [
                        //     'view' => $this->Html->link(__('View'), ['action' => 'view', '%id%'], array('class' => 'btn btn-primary btn-sm', 'icon' => 'fas fa-binoculars')),

                        //     // array(
                        //     //     'condition' => ' in_array($row["status"],array(2))',
                        //     //     'value' => $this->Html->link(__('Edit'), array('action' => 'edit', '%id%'), array('class' => 'btn btn-info btn-sm', 'icon' => 'fas fa-pencil-alt')),
                        //     // ),
                        //     'edit' => $this->Html->link(__('Edit'), array('action' => 'edit', '%id%'), array('class' => 'btn btn-info btn-sm', 'icon' => 'fas fa-pencil-alt')),

                        //     'delete' => $this->Html->link(

                        //         __('Delete'),
                        //         ['action' => 'delete', '%id%'],
                        //         [
                        //             'confirm' => 'Are you sure you wish to delete this?',
                        //             'class' => 'btn btn-danger btn-sm', 'icon' => 'fas fa-trash'
                        //         ]
                        //     )
                        // ];


                        // echo $this->List->adminIndex($fields, $users, $actions, false, $multi_select_actions, $parameters);
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>