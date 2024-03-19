<style>
    .btn {
        color: blueviolet;
    }

    td {
        padding: 10px;
        border: 1px solid #33ca9424;
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
                                                    <div class="project-actions"><a href="<?= Cake\Routing\Router::url(['action' => 'view', $item->id]) ?>" class="btn btn-primary btn-sm" icon="fas fa-binoculars">View</a></div>
                                                </td>
                                            </tr>
                                        <?php
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>