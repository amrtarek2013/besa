<section class="main-banner register-banner  partiner-banner">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="background-banner-color">
                    <img src="<?= WEBSITE_URL ?>img/new-images/partiner-background.png" width="" alt="" style="z-index: 2;">
                    <img src="<?= WEBSITE_URL ?>img/dots-153.png" width="" alt="" class="relative-dots-about">
                </div>
            </div>
            <div class="col-md-6">
                <div class="relative-box-about ">
                    <h1 class="relative-text">APPLY</h1>
                    <h2 class="title text-left">APPLY NOW</h2>
                </div>
            </div>

            <?php //= $partnership_with_besa 
            ?>
            <div class="col-md-12" style="padding: 0">
                <div class="title-banner-blue">
                    <h3>BESA: CONNECTING PEOPLE WORLDWIDE</h3>
                </div>
            </div>
            <!--             
            <div class="col-md-12" style="padding: 0;">
                <div class="container-iconsPartners">
                    <div class="boxPart">
                        <img src="<?= WEBSITE_URL ?>img/new-images/part-icon01.png" alt="">
                        <h4 class="titlePart">GROWTH</h4>
                        <p class="descrip">BESA is your trusted partner, <br> together we will fulfill student’s <br> ambitions internationally</p>
                    </div>
                    <div class="boxPart">
                        <img src="<?= WEBSITE_URL ?>img/new-images/part-icon02.png" alt="">
                        <h4 class="titlePart">ACCESS</h4>
                        <p class="descrip">Partnering with BESA means access to a wide range of resources and opportunities in the industry</p>
                    </div>
                    <div class="boxPart">
                        <img src="<?= WEBSITE_URL ?>img/new-images/part-icon03.png" alt="">
                        <h4 class="titlePart">EVENTS</h4>
                        <p class="descrip">BESA’s events are not to be missed! An opportunity for our partners to grow their presence and join us in exciting ventures</p>
                    </div>
                </div>
            </div>
             -->

            <div class="col-md-12" style="padding: 0;">
                <div class="line-stained">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->element('courses_list', ['courses' => $courses, 'wishLists' => $wishLists, 'appCourses' => $appCourses, 'gridContainerCols' => 3]); ?>

<section class="main-banner register-banner  partiner-banner">
    <div class="container">
        <div class="row">

            <div class="col-md-12">

                <?php
                if (!empty($appErrors))
                    foreach ($appErrors as $fieldName => $msg) {
                        echo "{$fieldName}: " . $msg . '</br>';
                    }
                ?>
                <?= $this->Form->create($application, array('url' => '/applications/index', 'id' => 'FormApp', 'class' => 'apply', 'type' => 'file')); ?>

                <div class="container-formBox">
                    <div class="gray-box">
                        <p>Submit this form with your business details and one of our representatives will be in contact with you.</p>
                    </div>
                    <div class="grid-container">


                        <?= $this->Form->control('study_level_id', [
                            'placeholder' => 'Study Level*', 'type' => 'select', 'empty' => 'Select Study Level', 'options' => $studyLevels, 'value' => isset($studyLevel) ? $studyLevel['id'] : $application['study_level_id'],

                            'templates' => ['inputContainer' => '<div class="form-area">{{content}}</div>'], 'label' => 'Study Level*', 'required' => true
                        ]) ?>
                    </div>
                    <div class="grid-container">


                        <?php foreach ($appFiles as $fieldName => $option) : ?>
                            <div class="form-area">
                                <label for="<?= $fieldName ?>"><?= $option['label'] ?></label>
                                <input type="file" id="<?= $fieldName ?>" name="<?= $fieldName ?>" placeholder="<?= $option['label'] ?>" <?= $option['required'] ? 'required="required"' : '' ?>>
                            </div>

                        <?php endforeach; ?>
                    </div>


                    <div class="container-submit">
                        <ul class="custome-list">
                            <li>For the purpose of applying regulation, your details are required.</li>
                        </ul>
                        <button type="submit" class="btn greenish-teal" name="save" style="width: 240px;">Apply</button>
                        <button type="submit" class="btn greenish-teal save_later" name="save_later" style="width: 240px;">Save Later</button>
                    </div>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</section>



<script>
    var lastSelectedLevel = '';
    $(document).ready(function() {


        if ($('#study-level-id').val() != '')
            lastSelectedLevel = $('#study-level-id').val();

        $(document).on('change', '#study-level-id', function(e) {
            if ($(this).val() != '')
                window.location.assign('<?= Cake\Routing\Router::url('/applications/index', true) ?>/' + $(this).val());
            else {
                $('.modalMsg #msgText').html('Please choose your study level first!');
                var inst = $('[data-remodal-id=modalMsg]').remodal();
                inst.open();
            }
        });
        $(document).on('confirmation', '.modalMsg', function(e) {
            if ($('#study-level-id').val() == '' && lastSelectedLevel != '')
                $('#study-level-id').val(lastSelectedLevel);
        });

        $('.save_later').on('click', function(e) {

            $('.form-area input').removeAttr('required');

        });
    });
</script>