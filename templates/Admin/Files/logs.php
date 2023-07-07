<div class="content-wrapper">
    
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?=__('Log for ').$selected_file->file?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">File Logs</li>
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
                    <h3 class="card-title"><?= __('Log for ').$selected_file->file ?></h3>
                </div>

                <?php if(!empty($logs)){ ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Log ID</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($logs as $log) { ?>
                            <tr>
                                <td><?=$log->id?></td>
                                <td><?=$status_labels[$log->status]?></td>
                                <td><?=$log->created->format('d-m-Y H:i:s')?></td>
                            </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                <?php } ?>

            </div>
            <!-- /.card -->

        </div>
        </div>
    </div>
</section>
</div>



