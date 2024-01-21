<section class="content adminChat row">
    <div class="container-fluid">


        <?php //echo $this->Html->css(array("grid.css")); 
        ?>
        <style>
            .text input {
                width: 100%;
            }

            .checkbox {
                margin-top: 38px;
            }

            .bottom-line {
                border-bottom: 1px solid antiquewhite;
                margin-bottom: 15px
            }
        </style>
        <div class="FormExtended ">
            <?php
            echo $this->AdminForm->create(null, array('url' => array('action' => 'workTimes', $id)));



            ?>

            <h2><?php __("Work Times"); ?></h2>
            <!-- <div class="col-md-12"> -->
            <?php


            $i = 0;
            // dd($counselorWorkDayTimes);
            foreach ($days as $k =>  $day) {

                $i = $day_id = $k;

                $defult_settings = array(
                    'active' => true,
                    'from' => "00:00:00",
                    'to' => "23:59:59",
                );
                $availableDate = isset($counselorWorkDayTimes[$day_id]) ? $counselorWorkDayTimes[$day_id] : $defult_settings;
                @$from = ($availableDate && $availableDate->time != null) ? $availableDate->time : $agent_time_configs['time.default_agent_chat_time_from'];


                echo $this->AdminForm->hidden("CounselorWorkDayTimes.$i.id", array("value" => @$availableDate->id, "class" => "input required"));
            ?>
                <div class="row bottom-line">


                    <div class="col-md-2" style="align-self: center;">
                        <div>

                            <b><?php echo $day; ?></b>

                            <?php
                            echo $this->AdminForm->hidden("CounselorWorkDayTimes.$i.day", array("value" => $day_id));

                            ?>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <?php
                        echo $this->AdminForm->control("CounselorWorkDayTimes.$i.active", array("type" => "checkbox", 'label' => 'On/Off', 'checked' => $availableDate['active'], "class" => "input chceckbox"));
                        ?>
                    </div>



                    <div class="col-md-3">
                        <?php
                        echo $this->AdminForm->control("CounselorWorkDayTimes.$i.time", array("type" => "text", 'value' => $from, "class" => "input Time required Time_" . $i));
                        ?>
                    </div>




                    <div class="col-md-2" style="align-self: center;">

                        <div class="input submit ">
                            <!-- <button type="button" onclick="resetDefault(<?php echo $i ?>)"><span class="btn btn-lg btn-success-border ">Reset to default</span></button> -->
                        </div>
                    </div>
                </div>
            <?php
                $i++;
            }
            ?>

            <div class="row">

                <div class="col-md-12 btnRight">
                    <?php
                    echo $this->AdminForm->submit(__("Submit", true), array("class" => "Submit"));
                    ?>
                    <?php
                    echo $this->AdminForm->end();

                    ?>
                </div>
            </div>
        </div>
        <?php
        echo $this->Html->css(array('select2', 'chozen.css?v=1', 'jquery.ui.datepicker', 'jquery-ui'));
        echo $this->Html->script(array(
            'select2', 'chzn-choices', 'chosen.ajaxaddition.jquery.js?v=111', '//code.jquery.com/ui/1.10.3/jquery-ui.min.js',
            'jquery.ui.datepicker', 'jquery-ui-timepicker-addon', 'jquery-ui-sliderAccess.js'
        ));
        ?>
        <script type="text/javascript">
            var busy = false;
            $(document).ready(function() {



                $(".Time").timepicker({
                    timeFormat: "HH:mm:00",
                    maxHour: 20,
                    maxMinutes: 30,
                    "step": 60,
                    controlType: 'select',
                    oneLine: true,
                    startTime: new Date(0, 0, 0, 30, 0, 0), // 3:00:00 PM - noon
                    stepMinute: 5 // 15 minutes
                });



            });
        </script>

    </div>
    </div>
</section>