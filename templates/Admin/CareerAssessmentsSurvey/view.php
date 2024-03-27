<script src="<?= ADMIN_ASSETS ?>/custom_helper/jquery-2.2.4.min.js"></script>
<link rel="stylesheet" href="<?= ADMIN_ASSETS ?>/custom_helper/style.css?v=2">

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card-header">
                    <h3 class="card-title"><?=   ' Answers to Career Assessments' ?></h3>
                </div>

                <div class="card">
                    <div class="card-header">
                         
                    </div>
                    <div class="card-body">
                        <table cellspacing="0" cellpadding="0" width="100%" class="table table-striped projects">
                           
                            <tr>
                                <td width="20%"><strong>Name</strong> </td>
                                <td><?php echo $careerAssessmentsSurvey['name'] ?></td>
                            </tr>
                            <tr>
                                <td width="20%"><strong>Email</strong> </td>
                                <td><?php echo $careerAssessmentsSurvey['email'] ?></td>
                            </tr>
                            <tr>
                                <td width="20%"><strong>Phone</strong> </td>
                                <td><?php echo $careerAssessmentsSurvey['Phone'] ?></td>
                            </tr>
                            <tr>
                                <td width="20%"><strong>Date</strong> </td>
                                <td><?php echo $careerAssessmentsSurvey['created'] ?></td>
                            </tr>
                            <tr>
                                <td width="20%"><strong>Chatgpt response</strong> </td>
                                <td><?php echo $careerAssessmentsSurvey['chatgpt_response'] ?></td>
                            </tr>

                        </table>
                        <br>
                        <h3><strong>Student Responses</strong> </h3>
                        <br>
                        <table cellspacing="0" cellpadding="0" width="100%" class="table table-striped projects">
                            <?php

                            foreach ($answers as $group => $items) {     ?>


                                <tr>
                                    <td colspan="2"><h3><?php echo $group ?></h3> </td>
                                 </tr>

                                <?php

                                foreach ($items as $question => $answer) {     ?>


                                    <tr>
                                        <td width="60%"> <?php echo $question ?> </td>
                                        <td><?php echo $answer ?></td>
                                    </tr>


                                <?php  } ?>



                            <?php  } ?>


                        </table>




                    </div>
                    <div class="card-footer">

                    </div>



                </div>
            </div>
        </div>
    </div>
    </section>