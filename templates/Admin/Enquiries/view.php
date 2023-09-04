<link rel="preload" href="<?= ADMIN_ASSETS ?>/custom_helper/jquery-2.2.4.min.js" as="script">
<link rel="preload" href="<?= ADMIN_ASSETS ?>/custom_helper/style.css?v=2" as="style">

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('View Enquiry') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= ADMIN_LINK ?>"><?= __('Home') ?></a></li>
                        <li class="breadcrumb-item active"><?= __('View Enquiry') ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= __('View ' . $enquiryType['title'] . ' Enquiry') ?></h3>
                        </div>
                        <div class='FormExtended'>
                            <!-- <h3>User Details</h3> -->
                            <table cellspacing="0" cellpadding="0" class="table listing-table" id="Table">
                                <tbody>
                                    <?php

                                    use Cake\Routing\Router;
                                    use Cake\Utility\Inflector;

                                    foreach ($enquiryType['fields'] as $key => $field) :
                                        if (is_string($key)) {
                                            $field = $key;
                                        }
                                    ?>
                                        <tr class="table-header">
                                            <th class=""><a><?= isset($enquiryType['fields'][$field]) ? $enquiryType['fields'][$field] : Inflector::humanize($field) ?></a></th>
                                            <?php
                                            $enquiry[$field] = ($field == 'mobile' && !empty($enquiry['mobile_code'])) ? '(+' . $enquiry['mobile_code'] . ') ' . $enquiry[$field] : $enquiry[$field];
                                            $enquiry[$field] = ($field == 'subject_area_id') ? $enquiry['subject_area']['title'] : $enquiry[$field];
                                            $enquiry[$field] = ($field == 'destination_id') ? $enquiry['country']['country_name'] : $enquiry[$field];
                                            if ($enquiry['type'] == 'book-appointment') {
                                                if (isset($_GET['dk']) && $field == 'study_level') {
                                                    var_dump($interestedStudyLevels[$enquiry[$field]]);
                                                }

                                                $enquiry[$field] = ($field == 'study_level' && isset($interestedStudyLevels)) ? $interestedStudyLevels[$enquiry[$field]] : $enquiry[$field];
                                            }
                                            ?>
                                            <td><?php echo (!empty($enquiry[$field]) ? ($field == 'certificate' ? ($enquiry['file_path'] != '#' ? '<a target="_blank" href="' . Router::url($enquiry['file_path']) . '">Download</a>' : '---') : $enquiry[$field]) : '') ?></td>
                                        </tr>
                                    <?php endforeach; ?>



                                    <tr class="table-header">
                                        <th class="" width=""><a>Date</a></th>
                                        <td><?php echo (!empty($enquiry->created->format('H:m:i d-m-Y')) ? $enquiry->created->format('H:m:i d-m-y') : '') ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>