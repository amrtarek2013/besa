$(".delete-action").click(function(){
	return confirm('Are you sure you want to delete this item?');
});

$('.main_group').change(function() {
	var permission_group = $(this).val();
    if(this.checked) {
        $('input[data-permission-group="'+permission_group+'"]').prop('checked', true);
    }else{
        $('input[data-permission-group="'+permission_group+'"]').prop('checked', false);
    }

});

$(document).ready(function(){
	$('.main_group').each(function(){
		var permission_group = $(this).val();
		var all_checked = true;
		$('input[data-permission-group="'+permission_group+'"]').each(function(){
			if(this.checked) {
			}else{
				all_checked = false;

			}
		});
		// alert(all_checked)
		if(all_checked){
			$(this).prop('checked', true);
		}
	});
});

$('#all_os').change(function() {
    if(this.checked) {
        $('.os_item').prop('checked', true);
    }else{
        $('.os_item').prop('checked', false);
    }
});
var active_page_url = window.location.href;
$('.nav-link2').each(function(){
	// console.log($(this).attr("href"))
	if($(this).attr("href")==active_page_url){
		$(this).addClass("active2");
	}
});


$(".custom_sorting").click(function(e){
	e.preventDefault();
	var sort_value = $(this).data("sort");
	var dir_value  = $(this).data("dir");
	$("#sort_value").val(sort_value);
	$("#dir_value").val(dir_value);

	$("#export_value").val("");
	
    $("#filter_form").submit();
}); 


$('#enable_random_selection').change(function() {

    if(this.checked) {
    	var check_val = 1;
    }else{
    	var check_val = 0;    
    }
    $.ajax({
        type: "POST",
        url: "https://rdidt.com/dashboard/admin/general-configurations/enable-random-selection",
        data: {'_csrfToken': _csrfToken,"check":check_val},
        dataType: 'json',
    }).done(function(data) {
        toastr.success("Your settings saved successfully.");
    });

});