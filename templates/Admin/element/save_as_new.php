<input class="SaveAsNew btn btn-primary"  type="button" value="<?php echo __('Save As New') ?>" onclick="$('#id').val('');
        $('#editForm').attr('action', $('#editForm').attr('action').replace('/edit/', '/add/'));
        $('#editForm').submit();" >
