<?php

use Cake\I18n\I18n;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $admin_title_prefix ?> | Dashboard </title>
    <script language="JavaScript" type="text/javascript" src="<?= ADMIN_ASSETS ?>/plugins/jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= ADMIN_ASSETS ?>/plugins/fontawesome-free/css/all.min.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= ADMIN_ASSETS ?>/dist/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= ADMIN_ASSETS ?>/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?= ADMIN_ASSETS ?>/custom_css.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= ADMIN_ASSETS ?>/datepicker/bootstrap-datepicker.min.css">

    <?php if ($currLang == "ar") { ?>
        <link rel="stylesheet" href="<?= ADMIN_ASSETS ?>/ar.css?v=<?= time() ?>">



        <!-- <link rel="stylesheet" href="<?= ADMIN_ASSETS ?>/RTL/AdminLTE-rtl.css">  -->
        <!-- <link rel="stylesheet" href="<?= ADMIN_ASSETS ?>/RTL/skins/_all-skins-rtl.min.css">  -->

    <?php } ?>

    <style type="text/css">
        body {
            /*zoom: 90%;*/
        }



        .btn-status {
            padding: 5px 10px;
            height: 35px;
            display: flex;
            text-align: center;
            width: max-content;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            font-size: 14px;

        }

        .btn-sm {
            margin-bottom: 5px;
        }

        .Apply {
            background: #d3d3d3;
        }

        .Under-Review {
            background: #0d6efd;
            color: #fff;
        }


        .Replied {
            background: #ffc107;
            color: #fff;

        }

        .Rejected {
            background: #bb2d3b;
            color: #fff;

        }

        .Joined-Successfully {
            background: #198754;
            color: #fff;

        }



        .No {
            background: #bb2d3b;
            color: #fff;
        }

        .Yes {
            background: #ffc107;
            color: #fff;

        }

        .select2-container {
            width: 100% !important;
            display: block;
            width: 100%;
            height: calc(2.25rem + 2px);
            padding: .375rem .75rem;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            box-shadow: inset 0 0 0 transparent;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;

        }

        .select2-container--default .select2-selection--single {
            border: none;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {

            top: 4px !important;
        }

        .select2-container--default .select2-selection--single {
            border: unset !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {

            margin-top: -10px !important;
        }
    </style>
</head>

<!--
  * sidebar-collapse
  * sidebar-mini
-->

<body class="hold-transition sidebar-mini flip">
    <!-- Start Loader -->
    <div class="overlay">
        <div class="overlay__inner">
            <div class="overlay__content"><span class="spinner"></span></div>
        </div>
    </div>
    <script type="text/javascript">
        var cr_url = location.href;
        if (cr_url.indexOf('admin/files/classification') !== -1) {

        } else {
            document.getElementsByClassName('overlay')[0].style.visibility = 'hidden';
        }
        var BASE_URL = '<?php echo $this->Url->build('/', ['fullBase' => true, 'secure' => true]); ?>';
        var _csrfToken = '<?= $this->request->getAttribute('csrfToken') ?>';

        $.ajaxSetup({
            beforeSend: function(xhr, settings) {
                if (!/^(GET|HEAD|OPTIONS|TRACE)$/i.test(settings.type) && !this.crossDomain) {
                    xhr.setRequestHeader("X-CSRF-Token", _csrfToken);
                }
            }
        });
    </script>
    <!-- End Loader -->


    <div class="wrapper">
        <?php echo $this->element('Admin/navbar'); ?>
        <?php echo $this->element('Admin/sidemenu'); ?>
        <?= $this->Flash->render() ?>

        <?= $this->fetch('content') ?>

        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <footer class="main-footer">
            <strong><?= __('Copyright') ?> &copy; 2022 <a href="#"><?= __($g_configs['general']['txt.site_name'] . ' System') ?></a>.</strong>
            <?= __('All rights reserved') ?>
            <div class="float-right d-none d-sm-inline-block">
                <b><?= __('Version') ?></b> 1.0.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->



    <!-- <script src="<?= ADMIN_ASSETS ?>/plugins/jquery/jquery.min.js"></script> -->
    <!-- <script src="<?= ADMIN_ASSETS ?>/new-js/jquery-3.6.3.min.js"></script> -->
    <script src="<?= ADMIN_ASSETS ?>/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?= ADMIN_ASSETS ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= ADMIN_ASSETS ?>/dist/js/adminlte.js"></script>
    <script src="<?= ADMIN_ASSETS ?>/custom_js.js?v=<?= time() ?>"></script>
    <script src="<?= ADMIN_ASSETS ?>/datepicker/bootstrap-datepicker.min.js"></script>


    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            if ($(".message.success").length) {
                toastr.success($(".message.success").text());
            }
            if ($(".message.error").length) {
                toastr.error($(".message.error").text());
            }
        });
    </script>


    <script type="text/javascript">
        $.fn.datepicker.dates['en'] = {
            days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
            daysShort: ["<?= __('Sun') ?>", "<?= __('Mon') ?>", "<?= __('Tue') ?>", "<?= __('Wed') ?>", "<?= __('Thu') ?>", "<?= __('Fri') ?>", "<?= __('Sat') ?>"],
            daysMin: ["<?= __('Su') ?>", "<?= __('Mo') ?>", "<?= __('Tu') ?>", "<?= __('We') ?>", "<?= __('Th') ?>", "<?= __('Fr') ?>", "<?= __('Sa') ?>"],
            months: ["<?= __('January') ?>", "<?= __('February') ?>", "<?= __('March') ?>", "<?= __('April') ?>", "<?= __('May') ?>", "<?= __('June') ?>", "<?= __('July') ?>", "<?= __('August') ?>", "<?= __('September') ?>", "<?= __('October') ?>", "<?= __('November') ?>", "<?= __('December') ?>"],
            monthsShort: ["<?= __('Jan') ?>", "<?= __('Feb') ?>", "<?= __('Mar') ?>", "<?= __('Apr') ?>", "<?= __('May') ?>", "<?= __('Jun') ?>", "<?= __('Jul') ?>", "<?= __('Aug') ?>", "<?= __('Sep') ?>", "<?= __('Oct') ?>", "<?= __('Nov') ?>", "<?= __('Dec') ?>"],
            today: "<?= __('Today') ?>",
            clear: "<?= __('Clear') ?>",
            format: "mm/dd/yyyy",
            titleFormat: "MM yyyy", // Leverages same syntax as 'format' 
            weekStart: 0
        };
        $('.hasDate').datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,
            clearBtn: true,
            orientation: "<?= $date_picket_orientation ?>"
        });
        // $('.hasTime').timepicker({
        //     icons: {
        //         up: 'fa fa-chevron-up',
        //         down: 'fa fa-chevron-down'
        //     }
        // });
        var mode = 'index'
        var intersect = true
        var ticksStyle = {
            fontColor: '#495057',
            fontStyle: 'bold'
        }
    </script>


    <!-- Datatable -->
    <?php if ($this->request->getParam('action') == "teamReporting") { ?>
        <script src="<?= ADMIN_ASSETS ?>/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?= ADMIN_ASSETS ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="<?= ADMIN_ASSETS ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="<?= ADMIN_ASSETS ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
        <script src="<?= ADMIN_ASSETS ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
        <script src="<?= ADMIN_ASSETS ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
        <script src="<?= ADMIN_ASSETS ?>/plugins/jszip/jszip.min.js"></script>
        <script src="<?= ADMIN_ASSETS ?>/plugins/pdfmake/pdfmake.min.js"></script>
        <script src="<?= ADMIN_ASSETS ?>/plugins/pdfmake/vfs_fonts.js"></script>
        <script src="<?= ADMIN_ASSETS ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
        <script src="<?= ADMIN_ASSETS ?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
        <script src="<?= ADMIN_ASSETS ?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
        <script>
            $(function() {
                $("#example1").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    searching: false,
                    pageLength: 100,
                    "buttons": [
                        // { extend: 'copy', text: '<?= __('Copy') ?>' }, 
                        // { extend: 'csv', text: '<?= __('CSV') ?>' }, 
                        // { extend: 'excel', text: '<?= __('Excel') ?>' }, 
                        // { extend: 'pdf', text: '<?= __('PDF') ?>' }, 
                        // { extend: 'print', text: '<?= __('Print') ?>' }, 
                        // { extend: 'colvis', text: '<?= __('Column visibility') ?>' }, 
                    ],
                    "oLanguage": {
                        "sSearch": "<?= __('Search') ?>"
                    },
                    "language": {
                        "paginate": {
                            "first": "<?= __('First') ?>",
                            "last": "<?= __('Last') ?>",
                            "previous": "<?= __('Previous') ?>",
                            "next": "<?= __('Next') ?>"
                        },
                        "emptyTable": "<?= __('No data available in table') ?>",
                        "info": "<?= __('Showing _START_ to _END_ of _TOTAL_ entries') ?>",
                        "infoEmpty": "<?= __('Showing 0 to 0 of 0 entries') ?>",
                        "loadingRecords": "<?= __('Loading...') ?>",
                        "processing": "<?= __('Processing...') ?>",
                        "search": "<?= __('Search') ?>:",
                        "zeroRecords": "<?= __('No matching records found') ?>",
                    }

                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            });
        </script>
    <?php } ?>



    <!-- Charts - Dashboard -->
    <?php if (
        $this->request->getParam('controller') == "Users" &&
        in_array($this->request->getParam('action'), ["usersPerCountry", "usersPerLesson", "usersPerDay", "usersPerMonth", "uploadsDuringTheDay", "usersDuringTheDay", "uploadsPerDay", "uploadsPerMonth", "uploadsPerLesson", "uploadsPerItem", "uploadsPerCountry"])
    ) { ?>

        <script src="<?= ADMIN_ASSETS ?>/plugins/chart.js/Chart.min.js"></script>
        <script src="<?= ADMIN_ASSETS ?>/dist/js/pages/dashboard3.js?v=1"></script>

        <?php if (!empty($x_axis_data)) { ?>
            <script type="text/javascript">
                var x_axis_data = <?php echo $x_axis_data; ?>;
                var y_axis_data = <?php echo $y_axis_data; ?>;
                var $visitorsChart = $('#users-per-country')
                // eslint-disable-next-line no-unused-vars
                var visitorsChart = new Chart($visitorsChart, {
                    data: {
                        labels: x_axis_data,
                        datasets: [{
                            type: 'line',
                            data: y_axis_data,
                            backgroundColor: 'transparent',
                            borderColor: '#007bff',
                            pointBorderColor: '#007bff',
                            pointBackgroundColor: '#007bff',
                            fill: false
                            // pointHoverBackgroundColor: '#007bff',
                            // pointHoverBorderColor    : '#007bff'
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        tooltips: {
                            mode: mode,
                            intersect: intersect
                        },
                        hover: {
                            mode: mode,
                            intersect: intersect
                        },
                        legend: {
                            display: false
                        },
                        scales: {
                            yAxes: [{
                                // display: false,
                                gridLines: {
                                    display: true,
                                    lineWidth: '4px',
                                    color: 'rgba(0, 0, 0, .2)',
                                    zeroLineColor: 'transparent'
                                },
                                ticks: $.extend({
                                    beginAtZero: true,
                                    suggestedMax: <?= !empty($suggestedMax) ? $suggestedMax : 100 ?>
                                }, ticksStyle)
                            }],
                            xAxes: [{
                                display: true,
                                gridLines: {
                                    display: false
                                },
                                ticks: ticksStyle
                            }]
                        }
                    }
                });
                $(".export_btn").click(function(e) {
                    e.preventDefault();
                    $("#export_value").val("export");
                    $("#filter_form").submit();
                });
                $("#filter_submit").click(function(e) {
                    e.preventDefault();
                    $("#export_value").val("");
                    $("#filter_form").submit();
                });
            </script>
        <?php } ?>


    <?php } ?>

    <?php if (
        $this->request->getParam('controller') == "Files" &&
        in_array($this->request->getParam('action'), ["classification", "annotation", "review"])
    ) { ?>
        <script type="text/javascript">
            var ajax_url = "<?php echo ADMIN_LINK ?>";
            var _csrfToken = '<?= $this->request->getAttribute('csrfToken') ?>';
        </script>
        <script src="<?= ADMIN_ASSETS ?>/files.js?v=<?= time() ?>"></script>
    <?php } ?>


    <script type="text/javascript">
        $(document).ready(function() {
            // *********************** Classification ***********************
            if (cr_url.indexOf('admin/files/classification') !== -1) {
                for (var i = 0; i < localStorage.length; i++) {
                    var gen_current_item = localStorage.key(i);
                    if (gen_current_item.indexOf('classification_') !== -1) {
                        var gen_current_item_arr = gen_current_item.split("_");
                        if (gen_current_item_arr[1]) {
                            var gen_current_file_id = gen_current_item_arr[1];
                            var gen_current_file_type = localStorage.getItem(gen_current_item);
                            var gen_current_side_text = $('.playlist_item_' + gen_current_file_id).text();

                            var gen_classification_icon = "";
                            if (gen_current_file_type == "1") {
                                gen_classification_icon = "<i class='fas fa-check'></i>";
                            } else if (gen_current_file_type == "2") {
                                gen_classification_icon = "<i class='fas fa-ban'></i>";
                            } else {
                                gen_classification_icon = "<i class='fas fa-border-all'></i>";
                            }
                            $('.playlist_item_' + gen_current_file_id).html(gen_current_side_text + gen_classification_icon);

                            $('.file_box_' + gen_current_file_id).attr("data-classification-type", gen_current_file_type);
                            $('.file_box_' + gen_current_file_id).attr("data-file-id", gen_current_file_id);

                        }
                    }
                    // $('body').append(localStorage.getItem(localStorage.key(i)));
                }
            }
            // *********************** Annotation ***********************
            if (cr_url.indexOf('admin/files/annotation') !== -1) {
                for (var i = 0; i < localStorage.length; i++) {
                    var gen_current_item = localStorage.key(i);

                    if (gen_current_item.indexOf('annotation_note_') !== -1) {
                        var gen_current_item_arr = gen_current_item.split("_note_");
                        if (gen_current_item_arr[1]) {
                            var gen_current_file_id = gen_current_item_arr[1];
                            var gen_current_file_type = localStorage.getItem('annotation_' + gen_current_file_id);
                            var gen_current_file_note = localStorage.getItem('annotation_note_' + gen_current_file_id);
                            var gen_current_side_text = $('.playlist_item_' + gen_current_file_id).text();

                            var gen_annotation_icon = "";
                            if (gen_current_file_type == "1") {
                                gen_annotation_icon = "<i class='fas fa-check'></i>";
                            }
                            $('.playlist_item_' + gen_current_file_id).html(gen_current_side_text + gen_annotation_icon);

                            $('.file_box_' + gen_current_file_id).attr("data-annotation-type", gen_current_file_type);
                            $('.file_box_' + gen_current_file_id).attr("data-file-id", gen_current_file_id);
                            $('.file_box_' + gen_current_file_id).find(".annotation_note").val(gen_current_file_note);

                        }
                    }
                    // $('body').append(localStorage.getItem(localStorage.key(i)));
                }
            }
            // *********************** Review ***********************
            if (cr_url.indexOf('admin/files/review') !== -1) {
                for (var i = 0; i < localStorage.length; i++) {
                    var gen_current_item = localStorage.key(i);

                    if (gen_current_item.indexOf('review_note_') !== -1) {
                        var gen_current_item_arr = gen_current_item.split("_note_");
                        if (gen_current_item_arr[1]) {
                            var gen_current_file_id = gen_current_item_arr[1];
                            var gen_current_file_type = localStorage.getItem('review_' + gen_current_file_id);
                            var gen_current_file_note = localStorage.getItem('review_ann_note_' + gen_current_file_id);
                            var gen_current_file_note_review = localStorage.getItem('review_note_' + gen_current_file_id);
                            var gen_current_side_text = $('.playlist_item_' + gen_current_file_id).text();

                            var gen_review_icon = "";
                            if (gen_current_file_type == "1") {
                                gen_review_icon = "<i class='fas fa-check'></i>";
                            }
                            $('.playlist_item_' + gen_current_file_id).html(gen_current_side_text + gen_review_icon);

                            $('.file_box_' + gen_current_file_id).attr("data-review-type", gen_current_file_type);
                            $('.file_box_' + gen_current_file_id).attr("data-file-id", gen_current_file_id);
                            $('.file_box_' + gen_current_file_id).find(".annotation_note").val(gen_current_file_note);
                            $('.file_box_' + gen_current_file_id).find(".review_note").val(gen_current_file_note_review);

                        }
                    }
                    // $('body').append(localStorage.getItem(localStorage.key(i)));
                }
            }

            $('.overlay').hide();
        });
    </script>


    <!-- Charts - Dashboard -->
    <?php if (
        $this->request->getParam('controller') == "FileLogs" &&
        in_array($this->request->getParam('action'), ["timeline"])
    ) { ?>

        <script src="<?= ADMIN_ASSETS ?>/plugins/chart.js/Chart.min.js"></script>
        <script src="<?= ADMIN_ASSETS ?>/dist/js/pages/dashboard3.js?v=1"></script>

        <?php if (!empty($x_axis_data)) { ?>
            <script type="text/javascript">
                var x_axis_data = <?php echo $x_axis_data; ?>;
                var y_axis_data = <?php echo $y_axis_data; ?>;
                var $visitorsChart = $('#users-per-country')
                // eslint-disable-next-line no-unused-vars
                var visitorsChart = new Chart($visitorsChart, {
                    data: {
                        labels: x_axis_data,
                        datasets: y_axis_data
                    },
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        tooltips: {
                            mode: mode,
                            intersect: intersect
                        },
                        hover: {
                            mode: mode,
                            intersect: intersect
                        },
                        legend: {
                            display: false
                        },
                        scales: {
                            yAxes: [{
                                // display: false,
                                gridLines: {
                                    display: true,
                                    lineWidth: '4px',
                                    color: 'rgba(0, 0, 0, .2)',
                                    zeroLineColor: 'transparent'
                                },
                                ticks: $.extend({
                                    beginAtZero: true,
                                    suggestedMax: <?= !empty($suggestedMax) ? $suggestedMax : 100 ?>
                                }, ticksStyle)
                            }],
                            xAxes: [{
                                display: true,
                                gridLines: {
                                    display: false
                                },
                                ticks: ticksStyle
                            }]
                        }
                    }
                });
                $(".export_btn").click(function(e) {
                    e.preventDefault();
                    $("#export_value").val("export");
                    $("#filter_form").submit();
                });
                $("#filter_submit").click(function(e) {
                    e.preventDefault();
                    $("#export_value").val("");
                    $("#filter_form").submit();
                });
            </script>
        <?php } ?>

        <script type="text/javascript">
            $(".custom_sorting").click(function(e) {
                e.preventDefault();
                var sort_value = $(this).data("sort");
                var dir_value = $(this).data("dir");

                $('<input>').attr({
                    type: 'hidden',
                    id: 'sort_value',
                    name: 'sort',
                    value: sort_value
                }).appendTo('#filterform');
                $('<input>').attr({
                    type: 'hidden',
                    id: 'dir_value',
                    name: 'dir',
                    value: dir_value
                }).appendTo('#filterform');

                $("#export_value").val("");
                $("#filterform").submit();
            });
        </script>

    <?php } ?>



</body>

</html>