<?php

use Cake\Routing\Router;

if (isset($permissionList[strtolower($current_controller) . '.add'])) { ?>

    <a class="add-new-btn btn btn-primary <?= $currLang == 'en' ? 'float-right' : 'float-left' ?>" href="<?= Router::url(array('controller' => $current_controller, 'action' => 'add')) ?>">
        <?= __('Add new') ?>
    </a>
<?php } ?>
<?php if (isset($permissionList[strtolower($current_controller) . '.import'])) { ?> <a class="add-new-btn btn btn-warning <?= $currLang == 'en' ? 'float-right' : 'float-left' ?>" style="margin-right: 5px;color: #fff;" href="<?= Router::url(array('controller' => $current_controller, 'action' => 'import')) ?>">
        <i class="nav-icon fas fa-file-import"></i> <?= __('Import') ?>
    </a>

<?php } ?>

<?php
if (isset($permissionList[strtolower($current_controller) . '.export'])) { ?>
    <?php
    $url_query = [];
    if (isset($parameters['?'])) {
        $url_query = $parameters['?'];
    }

    ?>
    <div style="display: block; float:right; margin-right:5px" id="exporter" class="more_option_box">
        <form action="<?= Router::url(array('controller' => $current_controller, 'action' => 'export', '?' => $url_query)) ?>" method="get">

            <?php

            // dd($url_query);
            foreach ($url_query as $key => $value) :
            ?>
                <input type="hidden" value="<?= $value ?>" name="<?= $key ?>">

            <?php endforeach; ?>
            <button class="add-new-btn btn btn-info" type="submit"><i class="nav-icon fas fa-file-csv"></i> Export CSV File</button>
        </form>
    </div>

<?php } ?>