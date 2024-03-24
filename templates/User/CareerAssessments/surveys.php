<style>
    .btn {
        color: blueviolet;
    }

    td {
        padding: 10px;
        border: 1px solid #33ca9424;
    }

    .container-formBoxs .title {
        margin-top: -120px;
        margin-bottom: 80px;
        font-size: 32px;

    }

    @media (max-width: 768px) {
        .container-formBoxs .title {

            margin-top: 0;
        }

        h1 {
            font-size: 28px;
            margin-top: 0;

        }

        .assessment {
            margin: 0;
        }

        #question-head {
            margin-left: 0;
        }

        .options {
            margin: 20px 0 0 0;
        }

        fieldset {
            padding: 10px;
            width: 90%;
        }

        label {
            display: block;
        }
    }
</style>

<section class="register-banner">

    <div class="container" style="width:100%">

        <div class="row">
            <div class="col-md-12">
                <div class="container-formBoxs">
                    <h4 class="title">Subject discovery assessments</h4>
                    <div class="">
                        <div class="card-body">
                            <div class="responsive-container">
                                <?php if (!empty($careerAssessmentsSurvey)) { ?>
                                    <table id="Table" class="table table-striped projects" cellpadding="0" cellspacing="0" width="100%">
                                        <thead>
                                            <tr class="table-header">
                                                <td class=""><a href="#">Survey Date</a></td>
                                                <td class=""><a href="#">Status</a></td>
                                                <td class="" style="text-align:center">Actions</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($careerAssessmentsSurvey as $item) {
                                                debug($item);


                                            ?>
                                                <tr>
                                                    <td>

                                                        <?php echo (!empty($item->created->format('d-m-Y H:m')) ? $item->created->format('d-m-Y H:m') : '') ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($item->is_completed) { ?>
                                                            <span class="btn-status Under-Review">Completed</span>
                                                        <?php } else { ?>
                                                            <span class="btn-status Under-Review">Ongoing</span>

                                                        <?php  } ?>
                                                    </td>
                                                    <td class="">

                                                        <?php if ($item->is_completed) { ?>
                                                            <div class="project-actions"><a href="<?= Cake\Routing\Router::url(['action' => 'view', $item->id]) ?>" class="btn btn-primary btn-sm" icon="fas fa-binoculars">View</a></div>

                                                        <?php
                                                        } else {
                                                        ?>
                                                            <div class="project-actions"><a href="<?= Cake\Routing\Router::url(['action' => 'index', $item->id]) ?>" class="btn btn-primary btn-sm" icon="fas fa-binoculars">Complete</a></div>


                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php
                                            } ?>
                                        </tbody>
                                    </table>
                                <?php
                                } ?>
                            </div>
                        </div>

                    </div>
                    <br>
                    <a class="btn MainBtn assessment-now" href="<?= Cake\Routing\Router::url(['action' => 'index']) ?>" style="max-width: 300px; margin:auto;">Take a new assessment now</a>
                </div>
            </div>
        </div>
    </div>
</section>