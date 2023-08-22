<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('Dynamic Routes') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><?= __('Dynamic Routes') ?></li>
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
                            <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . ' Dynamic Route') ?></h3>
                        </div>

                        <?php
                        $action = $this->request->getParam('action');
                        ?>
                        <?= $this->AdminForm->create($dynamicRoute, ['id' => $action . 'Form']); ?>
                        <div class="card-body">
                            <?php
                            echo '<h4>Original URL (you can always use this URL): /' . $dynamicRoute['controller'] . '/' . $dynamicRoute['action'] . ($dynamicRoute['has_params'] ? '/*' : '') . '</h4>';
                            echo '<h4>Current New URL: /<span id="new-url">' . $dynamicRoute['slug'] . '</span>' . ($dynamicRoute['has_params'] ? '/*' : '') . '</h4>';
                            echo '<p><b>Note "/*"</b> means: the url contain some params</p>';

                            echo $this->AdminForm->control('title', ['type' => 'text', 'class' => 'INPUT required']);
                            echo $this->AdminForm->control('slug', ['type' => 'text', 'class' => 'INPUT required']);
                            echo '<p></p>';

                            // echo $this->AdminForm->control('is_active');
                            // echo $this->AdminForm->control('has_params');

                            ?>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"><?= __('Save') ?></button>
                            <?php
                            if (!$dynamicRoute->isNew()) {

                                echo $this->element('save_as_new', array($dynamicRoute));
                            }
                            ?>
                        </div>
                        <?= $this->AdminForm->end() ?>
                    </div>
                    <!-- /.card -->

                </div>
            </div>
        </div>
    </section>
</div>

<style type="text/css">
    .related-text {
        display: none;
    }
</style>
<script type="text/javascript">
    $('.related-text').each(function(i, obj) {
        var current_text = $(obj).text();
        $(obj).prev().find("label").after("<br><label>" + current_text + "</label");
    });

    $('#slug').on('change focus keyup keypress keydown', function() { // ,keyup , keydown, focus
        let va = $(this).val();
        // va = va.replace(/\W+/g, '-').toLowerCase();
        va = va.replace(/[^a-z0-9/-]/gi, '-').toLowerCase();
        va = va.replace('--', '-');
        $(this).val(va);
        $('#new-url').html(va);
    });
</script>