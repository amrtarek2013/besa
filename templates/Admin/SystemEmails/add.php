<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= __('System Emails') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><?= __('System Emails') ?></li>
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
                            <h3 class="card-title"><?= __(ucfirst($this->getRequest()->getParam('action')) . ' System Emails') ?></h3>
                        </div>

                        <?php

                        $action = $this->request->getParam('action');
                        echo $this->AdminForm->create($email, ['id' => $action . 'Form']); ?>
                        

                        <div class="card-body">
                            <div class='FormExtended'>

                                <?php echo $this->AdminForm->control('title', ['placeholder' => 'title']); ?>
                                <?php echo $this->AdminForm->control('email_layout_id', ['empty' => 'Choose Layout']); ?>

                                <?php echo $this->AdminForm->control('subject', ['class' => 'subjectInput', 'placeholder' => 'subject']); ?>

                                <div class="row">
                                    <div class="form-group col-md-8">
                                        <?php echo $this->AdminForm->control('message', ['type' => 'textarea', 'class' => 'editor']); ?>

                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="layout-iddfsdf">placeholders</label>

                                        <?php
                                        if (!empty($placeholder)) {
                                            foreach ($placeholder as $key => $value) {
                                        ?>
                                                <a href="#" class="list-group-item add-placeholder">
                                                    <strong><?php echo $key ?></strong>: <?php echo $value ?>
                                                </a>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>



                                <?php echo $this->AdminForm->control('active', ['type' => 'checkbox']); ?>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <?php
                            if (!$email->isNew()) {
                                echo $this->element('save_as_new', array($email));
                            }
                            ?>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        <?= $this->AdminForm->enableEditors('.editor'); ?>
                        <?= $this->AdminForm->end() ?>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var focus_place;

        (function($) {
            $.fn.getCursorPosition = function() {
                var input = this.get(0);
                if (!input)
                    return; // No (input) element found
                if ('selectionStart' in input) {
                    // Standard-compliant browsers
                    return input.selectionStart;
                } else if (document.selection) {
                    // IE
                    input.focus();
                    var sel = document.selection.createRange();
                    var selLen = document.selection.createRange().text.length;
                    sel.moveStart('character', -input.value.length);
                    return sel.text.length - selLen;
                }
            }
        })(jQuery);

        (function($) {
            $.fn.setCursorPosition = function(selectionStart, selectionEnd) {
                var input = this.get(0);
                // IE
                if (input.createTextRange) {
                    var range = input.createTextRange();
                    range.collapse(true);
                    range.moveEnd('character', selectionEnd);
                    range.moveStart('character', selectionStart);
                    range.select();
                    // real browsers :)
                } else if (input.setSelectionRange) {
                    input.focus();
                    input.setSelectionRange(selectionStart, selectionEnd);
                }
                return this;
            }
        })(jQuery);



        $('a.add-placeholder').click(function(evt) {
            var elem = this;
            var txt = $(elem).find('strong').text();

            if ($(this).data('subject-position') !== null) {
                $(focus_place).val(function(i, v) {
                    return v.substring(0, $(elem).data('subject-position')) + txt + v.substring($(elem).data('subject-position'));
                });
                $(focus_place).setCursorPosition($(elem).data('subject-position') + txt.length, txt.length);
                $(focus_place).focus();
            } else {
                $(focus_place).val(function(i, v) {
                    return CKEDITOR.instances['message'].insertText(txt);
                });
                $(focus_place).focus();
            }
            evt.preventDefault();
        });

        $('a.add-placeholder').mouseenter(function() {
            if ($('.subjectInput').is(':focus')) {
                $(this).data('subject-position', $('.subjectInput').getCursorPosition());
                focus_place = '.subjectInput';
            } else {
                $(this).data('subject-position', null);
                $(this).data('subject-positionarea', $('.subjectInput').getCursorPosition());
                focus_place = '.textarea';
            }
        });

    });
</script>