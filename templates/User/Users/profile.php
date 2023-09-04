<style>
    .container-formBox .grid-container .grid-3col {
        display: -ms-grid;
        display: grid;
        -ms-grid-columns: 1fr 4px 1.5fr 4px 1.2fr;
        grid-template-columns: 1fr 1.5fr 1.2fr;
        grid-gap: 27px 8px;
    }

    select {
        background-position-x: calc(100% - 8px) !important;
    }

    .circle-img img {
        border-radius: 50%;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -o-border-radius: 50%;
    }
</style>
<link rel="stylesheet" href="<?= ADMIN_ASSETS ?>/datepicker/bootstrap-datepicker.min.css">
<section class="main-banner register-banner">

    <div class="container" style="width:100%">
        <div class="row">
            <div class="col-md-12">
                <h2 class="title text-left title-dash">Profile</h2>
            </div>
        </div>
        <div class="row">
            <?= $this->Form->create($user, array('type' => 'file', 'id' => 'FormProfile')); ?>
            <div class="col-md-12">
                <div class="container-formBox">
                    <h4 class="title">Basic Information</h4>
                    <div class="grid-container">


                        <?= $this->Form->control('first_name', [
                            'placeholder' => 'Name',
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>'], 'label' => 'Name*', 'required' => true
                        ]) ?>

                        <?= $this->Form->control('last_name', [
                            'placeholder' => 'Last name*', 'label' => 'Last name*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>
                        <?php
                        /*echo $this->Form->control('date', [
                            'placeholder' => 'Date of Birth', 'value' => $user->bd, 'class' => 'hasDate', 'label' => 'Date of Birth*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]);*/ ?>
                        <?php

                        use Cake\Routing\Router;

                        $days = [];
                        for ($i = 1; $i <= 31; $i++) {
                            $d = $i; //date('M', strtotime("last day of +$i month"));
                            $days[$d] = $d;
                        }
                        $months = [];
                        for ($i = 1; $i <= 12; $i++) {
                            $month = $i; // date('M', strtotime("last day of +$i month"));
                            $months[$month] = $month;
                        }

                        $years = [];
                        for ($i = 1980; $i <= 2015; $i++) {
                            $year = $i;

                            $years[$year] = $year;
                        }
                        ?>

                        <div class=" form-area">
                            <label for="">Date of Birth*</label>
                            <div class="grid-3col">
                                <?= $this->Form->control('day', [
                                    'placeholder' => 'Day*', 'label' => false, 'required' => true,
                                    'type' => 'select', 'empty' => 'Day', 'options' => $days,
                                    'templates' => ['inputContainer' => '{{content}}']
                                ]) ?>
                                <?= $this->Form->control('month', [
                                    'placeholder' => 'Month*', 'label' => false, 'required' => true,
                                    'type' => 'select', 'empty' => 'Month', 'options' => $months,
                                    'templates' => ['inputContainer' => '{{content}}']
                                ]) ?>
                                <?= $this->Form->control('year', [
                                    'placeholder' => 'Year*', 'label' => false, 'required' => true,
                                    'type' => 'select', 'empty' => 'Year', 'options' => $years,
                                    'templates' => ['inputContainer' => '{{content}}']
                                ]) ?>

                            </div>
                        </div>


                        <?= $this->Form->control('gender', [
                            'placeholder' => 'Gender*', 'label' => 'Gender*', 'required' => true,
                            'type' => 'select', 'empty' => 'Gender', 'options' => ['0' => 'Male', '1' => 'Female'],
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>
                        <?= $this->Form->control('nationality_id', [
                            'placeholder' => 'Nationality*', 'label' => 'Nationality*', 'required' => true,
                            'type' => 'select', 'empty' => 'Select Nationality*',
                            'options' => $countriesList,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>


                        <?= $this->element('mobile_with_code', ['phone_name' => 'mobile', 'phone_label' => 'Mobile', 'phone_code' => 'mobile_code']) ?>

                        <?= $this->Form->control('country_id', [
                            'placeholder' => 'Country of Residence', 'type' => 'select', 'empty' => 'Select Country of Residence',
                            'options' => $countriesList, 'label' => 'Country of Residence*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>


                        <?= $this->Form->control('city', [
                            'type' => 'text', 'placeholder' => 'City', 'label' => 'City*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>


                        <?= $this->Form->control('current_status', [
                            'type' => 'text', 'placeholder' => 'Current/Previous-(School/Uni.)', 'label' => 'Curr/Prev-(School/Uni.) *', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>


                        <?= $this->Form->control('current_study_level', [
                            'placeholder' => 'Current/last Level of study*', 'type' => 'select', 'empty' => 'Select Current/last Level of study*',
                            'options' => $mainStudyLevels, 'label' => 'Current/last Level of study*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>



                        <?= $this->Form->control('subject_area_id', [
                            'placeholder' => 'Major/subject of your study', 'type' => 'select', 'empty' => 'Select Major/subject of your study',
                            'options' => $subjectAreas, 'label' => 'Major/subject of your study', /*'required' => true,*/
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}" id="subject-area">{{content}}</div>']
                        ]) ?>


                        <?= $this->Form->control('destination_id', [
                            'placeholder' => 'Country of study', 'type' => 'select', 'empty' => 'Select Country of study',
                            'options' => $destinationsList, 'label' => 'Country of study*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>



                        <?= $this->Form->control('email', [
                            'placeholder' => 'Email', 'class' => 'form-control', 'label' => 'Email*', 'required' => true,
                            'templates' => ['inputContainer' => '<div class="form-area {{rquired}}">{{content}}</div>']
                        ]) ?>


                        <?= $this->Form->control('password', [
                            'type' => 'password',
                            'placeholder' => 'Password',
                            'label' => 'Password*',
                            'autocomplete' => false,
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}<i class="toggle-password fas fa-eye" onclick="togglePasswordVisibility(\'password\')"></i></div>']
                        ]) ?>
                        <?= $this->Form->control('passwd', [
                            'type' => 'password',
                            'placeholder' => 'Confirm Password',
                            'label' => 'Confirm Password*',
                            'templates' => ['inputContainer' => '<div class="form-area {{required}}">{{content}}<i class="toggle-password fas fa-eye" onclick="togglePasswordVisibility(\'passwd\')"></i></div>']
                        ]) ?>

                        <?php
                        echo $this->AdminForm->control('image', [
                            'label' => 'Profile Picture', 'type' => 'file', 'between' => $this->element('image_input_between', [
                                'data' => $user,
                                'field' => 'image',
                                'info' => [
                                    'width' => $uploadSettings['image']['width'],
                                    'height' => $uploadSettings['image']['height'],
                                    'path' => $uploadSettings['image']['path']

                                ],
                            ]),
                            'templates' => ['inputContainer' => '<div class=" {{rquired}}" style="margin-top: -19px !important;">{{content}}</div>']
                        ]);
                        ?>

                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="container-submit">
                    <!-- <div class="checkboxes">
                        <div>
                            <input type="checkbox" name="agree" id="agree">
                            <label for="agree">I agree to <a href="#">terms & conditions</a> </label>
                        </div>
                        <div>
                            <input type="checkbox" name="news_subscribe" id="news_subscribe">
                            <label for="news_subscribe">I’d like being informed about latest news and tips</label>
                        </div>
                    </div> -->
                    <button type="submit" class="btn clear-blue">Update</button>
                </div>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</section>

<script src="<?= ADMIN_ASSETS ?>/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?= ADMIN_ASSETS ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= ADMIN_ASSETS ?>/datepicker/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
    $.fn.datepicker.dates['en'] = {
        days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
        daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
        daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
        months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
        monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        today: "Today",
        clear: "Clear",
        format: "mm/dd/yyyy",
        titleFormat: "MM yyyy", // Leverages same syntax as 'format' 
        weekStart: 0
    };
    $('.hasDate').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        clearBtn: true,
        orientation: "left"
    });
    var mode = 'index'
    var intersect = true
    var ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
    }
</script>