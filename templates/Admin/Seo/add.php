<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('Seo') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><?= __('Seo') ?></li>
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
                            <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . '  Seo') ?></h3>
                        </div>
                        <div class="card-body">
                            <div class='FormExtended'>
                                <?php
                                echo $this->AdminForm->create($seo); ?>
                                <div class="note">
                                    <p>Criteria = URL to apply custom page title and meta tags to. </p>
                                    <p> <strong>\'%\'</strong> may be used to substitute characters in a URL </p>
                                    <p>For every requested URL, the most specific \'SEO Rule\' will apply.</p>
                                </div>

                                <?php
                                echo $this->AdminForm->control('criteria', ['type' => 'text']); ?>

                                <div class="note">

                                    <p><strong>Criteria Examples:</strong></p>

                                    <table cellpadding="2" cellspacing="2">
                                        <tr>
                                            <td><strong>/</strong></td>
                                            <td>This matches the Home page only</td>
                                        </tr>
                                        <tr>
                                            <td><strong>/%</strong></td>
                                            <td>This matches every page on the site <em>(except any page with a more specific rule applied)</em> </td>
                                        </tr>
                                        <tr>
                                            <td><strong>content/%</strong></td>
                                            <td>This matches every Content page <em>(except any page with a more specific rule applied)</em> </td>
                                        <tr>
                                            <td><strong>/content/about-us</strong></td>
                                            <td>This matches the About Us page only</td>
                                        </tr>
                                    </table>
                                </div>



                                <?php echo $this->AdminForm->control('title', ['type' => 'text']);
                                echo $this->AdminForm->control('keywords', ['type' => 'text']);
                                echo $this->AdminForm->control('description', ['type' => 'textarea']);

                                ?>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                        <?= $this->AdminForm->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>