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
            <?= $this->element('counselor/points', ['counselor' => $counselor]) ?>

        </div>
    </div>
</section>