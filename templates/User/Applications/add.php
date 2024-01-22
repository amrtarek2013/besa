<style>
    .valid-error-msg {
        color: darkred;
        /* background-color: #BD362F; */
        opacity: 70%
    }

    .error-input {
        border: 2px solid #E61D1D !important;
    }

    .container-formBox .grid-container {

        grid-template-columns: 3fr 3fr;
    }

    .PreviewImg {
        text-align: right;
    }
</style>
<div class="content-wrapper">

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . ' Application') ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <?= $this->element('courses_list', ['courses' => $courses, 'wishLists' => $wishLists, 'appCourses' => $appCourses, 'gridContainerCols'=>2]); ?>

    <!-- <section class="main-banner register-banner  partiner-banner">
        <div class="">
            <div class="row">

                <div class="col-md-12"> -->

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <!-- <div class="card-header">
                            <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . ' Application') ?></h3>
                        </div> -->

                        <?php
                        $action = $this->request->getParam('action');
                        ?>
                        <div class="card-body">
                            <?php
                            echo $this->AdminForm->create($application, ['type' => 'file', 'id' => $action . 'AdminForm']);
                            ?>

                            <div class="col-md-12">
                                <div class="container-formBoxs">
                                    <h4 class="title">Student Application Files</h4>

                                    <?= $this->Form->create($application, array('id' => 'FormApp', 'class' => 'apply', 'type' => 'file')); ?>


                                    <div class="gray-box">
                                        <p>Submit this form with your files details and one of our representatives will be in contact with you.</p>
                                    </div>
                                    <!-- <div class="validation-messages" style='color: #fff; background-color: #BD362F; opacity: 70%'>

                            <h3>Please check the folowing erros!</h3>
                            <?php
                            /*
                            if (!empty($appErrors))
                                foreach ($appErrors as $fieldName => $msg) {
                            ?>
                                <!-- <p style="text-align: left"> -->
                                <p class="toast-error" style='text-align: left; color: #fff'>
                                    <storng><?= Cake\Utility\Inflector::humanize($fieldName) . '</storng>: ' . $msg ?>
                                        <!-- </p> -->
                                </p>
                            <?php
                                }
                                */
                            ?>
                        </div> -->
                                    <div class="grid-container">


                                        <?php foreach ($appFiles as $fieldName => $option) : ?>
                                            <!-- <div class="form-area">
                                    <label for="<?= $fieldName ?>"><?= $option['label'] ?></label>
                                    <input type="file" id="<?= $fieldName ?>" name="<?= $fieldName ?>" placeholder="<?= $option['label'] ?>" <?= $option['required'] ? 'required="required"' : '' ?>>
                                </div> -->
                                            <?php //= $this->Form->control($fieldName, ['type' => 'file']) 
                                            ?>
                                            <?= $this->AdminForm->control($fieldName, [
                                                'label' => $option['label'], 'type' => 'file',
                                                'accept' => 'application/pdf',
                                                'class' => isset($appErrors[$fieldName]) ? 'error-input' : '',
                                                'between' => $this->element(
                                                    'file_input_between',
                                                    [
                                                        'data' => $application,
                                                        'field' => $fieldName,
                                                        // 'show_file_name' => false,
                                                        'info' => [
                                                            'path' => 'uploads' . DS . 'files' . DS . 'applications'
                                                        ]
                                                    ]
                                                ),
                                                'templates' => [
                                                    'inputContainer' => '<div class="form-area">{{content}}</div>'
                                                ],
                                                'after' => isset($appErrors[$fieldName]) ? '<span class="valid-error-msg">' . $appErrors[$fieldName] . '</span>' : ''
                                            ]); ?>

                                        <?php
                                        endforeach; ?>
                                    </div>


                                    <div class="container-submit">
                                        <ul class="custome-list">
                                            <li>For the purpose of applying regulation, your details are required.</li>
                                        </ul>
                                        <div class="row">


                                            <button type="submit" class="btn greenish-teal" name="save" style="width: 240px; float:left; margin-right: 10px;">Apply</button>
                                            <button type="submit" class="btn btn-primary" name="save_later" style="width: 240px;">Save Later</button>
                                        </div>
                                    </div>
                                </div>
                                <?= $this->Form->end() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function() {
        // $('.select-single').select2();
        // $('.select-multiple').select2();

        $('div.form-group').addClass('form-area');
    });
</script>
<?php

// echo $this->Html->script('select2.min');
// echo $this->Html->css('select2.min');
