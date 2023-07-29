<?php

echo $this->Html->css(array('select2', 'chozen.css?v=1', 'jquery.ui.datepicker', 'jquery-ui'));
echo $this->Html->script(array(
    'select2', 'chzn-choices', 'chosen.ajaxaddition.jquery.js?v=111', '//code.jquery.com/ui/1.10.3/jquery-ui.min.js',
    'jquery.ui.datepicker', 'jquery-ui-timepicker-addon', 'jquery-ui-sliderAccess.js'
));


// print_r($finalFields);die;
$not_allowed_list = array("chk.enable_user_registration_on_functional_pages", "pwd.admin_password", "txt.admin_user_name");

$finalFields = array_merge(array_flip($conf_sort), $finalFields);
// $properOrderedArray = array_replace(array_flip(array('name', 'dob', 'address')), $customer);

$colours = array(
    '#005BAA' => 'blue',
    '#ED1C24' => 'red',
    '#58585B' => 'Gray',
    '#ffffff' => 'White',
    '#fff000' => 'Yellow',
    '#D3D3D3' => 'light grey',
    '#30db30' => 'light green',
    '#000000' => 'Black',
    '#ffa500' => 'orange',
);
$_titleOfPage = Cake\Utility\Inflector::humanize($group);
$hasTime = false;
$hasDate = false;
?>
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('General Configurations') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= ADMIN_LINK ?>"><?= __('Home') ?></a></li>
                        <li class="breadcrumb-item active"><?= __('General Configurations') ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header">

                            <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . ' ' . $_titleOfPage) ?></h3>
                        </div>
                        <div class="card-body">
                            <?php


                            ?>
                            <style type="text/css">
                                .hidden {
                                    display: none;
                                }

                                .show {
                                    display: block;
                                }
                            </style>
                            <?php
                            $labels = array();
                            ?>
                            <div class='FormExtended'>
                                <!-- <form action='?' method="post" > -->

                                <!-- <form id="GeneralConfigurationEdit" enctype="multipart/form-data" method="post" action="/admin/general_configurations/edit/<?php echo $group ?>"> -->
                                <?php

                                echo $this->AdminForm->create($Configurations, array('type' => 'file', 'url' => '/admin/general-configurations/manage/' . $group));
                                $colorFIelds = []; //['popup_buttons_background_color', 'popup_buttons_border_color', 'popup_background_color'];
                                $fileCounter = 0;
                                foreach ($finalFields as $key => $value) {

                                    $options = null;

                                    if (1) {
                                        if (!in_array($key, $fields))
                                            continue;
                                        if (in_array($key, $not_allowed_list)) { ?>

                                            <div class="hidden">
                                            <?php } else { ?>
                                                <!-- <br> -->
                                                <div class="show">
                                                <?php
                                            }
                                            $ext = substr($key, 0, strpos($key, '.'));
                                            $name = substr($key, strpos($key, '.') + 1);
                                            if ($name == 'seller_layout') {

                                                $options = array(1 => 'V1', 2 => 'V2');
                                            }

                                            $key = explode('.', $key);
                                            $key = $key[0] . '_' . $key[1];
                                            $_lable = Cake\Utility\Inflector::humanize($name);
                                            if (!empty($labels[$name]))
                                                $_lable = $labels[$name];
                                            if ($name == "registration_expiry")
                                                echo "<br><h4>Sales App   Send to Sold Follow Up</h4>";
                                            if ($name == "keywords")
                                                echo "<br><h4>Default SEO Settings</h4>";

                                            if ($ext == 'pwd') {
                                                $value = '';
                                            }
                                                ?>
                                                <?php if ($ext == 'chk') { ?>
                                                    <label for="<?= $key ?>">
                                                        <?= $_lable ?>
                                                    </label>
                                                    <br>
                                                    <?php
                                                    if (!isset($options)) {
                                                        $options = $dropdownYesNoOptions;
                                                    }

                                                    $options = array(1 => 'Yes', '0' => 'No');
                                                    // if ($name == 'default_list_view_for_search_results') {
                                                    //     $options = array('list' => 'List', 'grid' => 'Grid');
                                                    // }
                                                    // if ($name == 'car_search_results_style') {
                                                    //     $options = array(
                                                    //         'new_car_search_results_style  new-dynamic-banner' => 'New car search results style',
                                                    //         'old_car_search_results_style' => 'Old car search results style'
                                                    //     );
                                                    // }
                                                    // if ($name == 'enable_user_registration_on_functional_pages') {
                                                    //     $options = array(0 => 'Open Website', 1 => 'Become a member', 2 => 'AFS Sign-in', 3 => 'Limited open website');
                                                    //     // $options = array(0 => 'Open Website', /*1 => 'Become a member',*/ 2 => 'Fast Sign In Website', 3 => 'Verified Sign In Website');
                                                    // }
                                                    // if ($name == 'enable_user_registration_on_functional_pages_2') {
                                                    //     // $options = array(0 => 'Open Website', 1 => 'Become a member', 2 => 'AFS Sign-in', 3 => 'Limited open website');
                                                    //     $options = array(0 => 'Open Website', /*1 => 'Become a member',*/ 2 => 'Fast Sign In Website', 3 => 'Verified Sign In Website');
                                                    // }
                                                    // if ($name == 'enable_ozclub_function') {
                                                    //     $options = array(0 => 'No', 1 => 'Yes');
                                                    //     $_lable = "Enable OZClub Function";
                                                    // }
                                                    // if ($name == 'enable_sms_functional') {
                                                    //     $options = array(0 => 'No', 1 => 'Yes');
                                                    //     $_lable = "Enable SMS";
                                                    // }
                                                    // if ($name == 'poa') {
                                                    //     $options = array(1 => 'ON', 0 => 'OFF');
                                                    //     $_lable = "POA";
                                                    // }
                                                    // if ($name == 'web_discount') {
                                                    //     $options = array(0 => 'Full Form', 1 => 'SMS');
                                                    // }
                                                    // if ($name == 'buy_online_discount_type') {

                                                    //     $options = array(0 => 'No', 1 => '(%) Discount', 2 => 'Amount Discount');
                                                    // }

                                                    // if ($name == 'enable_cross_out_function') {

                                                    //     $options = array(0 => 'No', 1 => '(%) Discount', 2 => 'Amount Discount', 3 => 'OZClub');
                                                    // }

                                                    // if ($name == 'auction_notification_method') {
                                                    //     $options = array(0 => 'Off', 1 => 'SMS', 2 => 'E-mail');
                                                    // }

                                                    ?>
                                                    <?= $this->AdminForm->input($name, array('name' => 'data[GeneralConfiguration][' . $key . ']', 'legend' => false, 'label' => $_lable, 'type' => 'radio', 'options' => $options, 'value' => $value)); ?>
                                                <?php } elseif ($ext == 'dropdown' && !in_array($name, $colorFIelds)) {

                                                    if (!isset($options)) {
                                                        $options = $dropdownYesNoOptions;
                                                    }

                                                    // if ($name == 'sort_method') {
                                                    //     $options = array(
                                                    //         "price-asc" => "Price (low - high)",
                                                    //         "price-desc" => "Price (high - low)",
                                                    //         "year-asc" => "Year (old - new)",
                                                    //         "year-desc" => "Year (new - old)",
                                                    //         "kms-asc" => "Kms (low - high)",
                                                    //         "kms-desc" => "Kms (high - low)"
                                                    //     );
                                                    //     $_lable = "Search engine results";
                                                    // }
                                                    echo $this->AdminForm->control($name, array(
                                                        'name' => 'data[GeneralConfiguration][' . $key . ']', 'legend' => false, 'label' => $_lable, 'type' => 'select', 'empty' => 'Please select', 'options' => $options, 'value' => $value, "style" => "background-color:" . $value, 'class' => 'ColorsDropdown'

                                                    )); ?>
                                                <?php } elseif ($ext == 'colour' || in_array($name, $colorFIelds)) {

                                                    echo $this->AdminForm->control($name, array(
                                                        'name' => 'data[GeneralConfiguration][' . $key . ']', 'legend' => false, 'label' => $_lable, 'type' => 'select', 'empty' => 'Please select', 'options' => $colours, 'value' => $value, "style" => "background-color:" . $value, 'class' => 'ColorsDropdown'

                                                    )); ?>

                                                <?php
                                                } elseif ($ext == 'textarea') { ?>
                                                    <label for="<?= $key ?>">
                                                        <?php
                                                        echo $_lable;
                                                        ?>
                                                    </label>
                                                    <br>
                                                    <?php

                                                    $editor_class = "";
                                                    // if (in_array($key, ['textarea_auction_car_terms_and_conditions']))
                                                    //     $editor_class = "editor";

                                                    ?>
                                                    <textarea rows="10" cols="100" id='<?= $key ?>' name='data[GeneralConfiguration][<?php echo $key ?>]' class='INPUT textarea <?= $editor_class ?>'><?= $value ?></textarea>
                                                    <?php
                                                    // if (in_array($key, ['textarea_auction_car_terms_and_conditions']))

                                                    //     echo $this->AdminForm->enableEditors('.editor');

                                                    ?>
                                                <?php
                                                } elseif ($ext == 'file') {
                                                    $fileCounter++;

                                                    echo $_lable;

                                                    $modelClass = 'GeneralConfiguration';
                                                    $field = $name;

                                                    echo $this->AdminForm->control(
                                                        $field,
                                                        array(
                                                            'name' => 'data[GeneralConfiguration][' . $key . ']',
                                                            'class' => 'input',
                                                            'label' => $_lable,
                                                            'type' => 'file',
                                                            'value' => $value,
                                                            'after' => (empty($value)) ? '' : '<a target="_blank" href="' . $value . '"><img src="'.WEBSITE_URL.''.$value.'"> Preview</a>'
                                                        )
                                                    );
                                                } else {
                                                    $class = 'input';
                                                    if ($ext == 'time') {
                                                        $class = 'input hasTimepicker';
                                                        $hasTime = true;
                                                    }
                                                    if ($ext == 'date') {
                                                        $class = 'input hasDatepicker';
                                                        $hasDate = true;
                                                    }
                                                    echo $this->AdminForm->control(
                                                        $name,
                                                        array(
                                                            'name' => 'data[GeneralConfiguration][' . $key . ']',
                                                            'class' => $class,
                                                            'placeholder' => $_lable,
                                                            'type' => $extensions[$ext],
                                                            'value' => $value,
                                                            'label' => $_lable,
                                                            'id' => $key
                                                        )
                                                    );
                                                } ?>

                                                </div>
                                        <?php
                                    } //end if
                                }
                                        ?>
                                            </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                        <?= $this->AdminForm->end() ?>
                    </div>
                    <!-- /.card -->

                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    <?php if ($hasTime) : ?>
        $(".hasTimepicker").timepicker({
            timeFormat: "HH:mm:00",
            minTime: "00:00:00", // 11:45:00 AM,
            maxTime: "23:59:59", // 11:45:00 AM,
            maxHour: 20,
            maxMinutes: 30,
            "step": 30,
            controlType: 'select',
            oneLine: true,
            startTime: new Date(0, 0, 0, 30, 0, 0), // 3:00:00 PM - noon
            stepMinute: 1 // 15 minutes
        });
    <?php endif; ?>

    $('.ColorsDropdown').change(function() {
        $(this).css('background-color', $(this).val());
    });
</script>