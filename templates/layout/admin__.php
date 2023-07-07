<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$admin_title_prefix?> | Dashboard </title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?=ADMIN_ASSETS?>/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?=ADMIN_ASSETS?>/dist/css/ionicons.min.css">
    <link rel="stylesheet" href="<?=ADMIN_ASSETS?>/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?=ADMIN_ASSETS?>/custom_css.css?v=<?=time()?>">
    <link rel="stylesheet" href="<?=ADMIN_ASSETS?>/datepicker/bootstrap-datepicker.min.css">
    <style type="text/css">
        body{
            /*zoom: 90%;*/
        }
    </style>
</head>

<!--
  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php echo $this->element('Admin/navbar'); ?>
        <?php echo $this->element('Admin/sidemenu'); ?>
        <?= $this->Flash->render() ?>
        
        <?= $this->fetch('content') ?>

        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <footer class="main-footer">
            <strong>Copyright &copy; 2022 <a href="#">BESA</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>
    </div>
<!-- ./wrapper -->



<script src="<?=ADMIN_ASSETS?>/plugins/jquery/jquery.min.js"></script>
<script src="<?=ADMIN_ASSETS?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?=ADMIN_ASSETS?>/dist/js/adminlte.js"></script>
<script src="<?=ADMIN_ASSETS?>/custom_js.js"></script>
<script src="<?=ADMIN_ASSETS?>/datepicker/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
    $('.hasDate').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        clearBtn: true,
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
<?php if($this->request->getParam('action')=="index"){ ?>
    <script src="<?=ADMIN_ASSETS?>/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=ADMIN_ASSETS?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?=ADMIN_ASSETS?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?=ADMIN_ASSETS?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?=ADMIN_ASSETS?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?=ADMIN_ASSETS?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?=ADMIN_ASSETS?>/plugins/jszip/jszip.min.js"></script>
    <script src="<?=ADMIN_ASSETS?>/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?=ADMIN_ASSETS?>/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="<?=ADMIN_ASSETS?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?=ADMIN_ASSETS?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?=ADMIN_ASSETS?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
<?php } ?>



<!-- Charts - Dashboard -->
<?php if($this->request->getParam('controller')=="Users" && 
        in_array($this->request->getParam('action'), ["usersPerCountry","usersPerLesson"])    ){ ?>

    <script src="<?=ADMIN_ASSETS?>/plugins/chart.js/Chart.min.js"></script>
    <script src="<?=ADMIN_ASSETS?>/dist/js/pages/dashboard3.js?v=1"></script>
    
    <?php if(!empty($x_axis_data)){ ?>
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
                            suggestedMax: 100
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
        })
    </script>
    <?php } ?>


<?php } ?>


</body>
</html>


