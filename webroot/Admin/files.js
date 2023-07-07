function update_local_classification(file_id,classification_type){
    if (typeof(Storage) !== "undefined") {
        localStorage.setItem("classification_"+file_id, classification_type);
        // stored_class_stat = localStorage.getItem("classification_"+file_id);
        // alert(stored_class_stat)
    } else {
      // Sorry! No Web Storage support..
    }
}

function after_classify_success(file_id,classification_type,current_box,classification_icon){
    update_local_classification(file_id,classification_type);
    if(current_box.closest('.audio-box').next().length){
        var next_box_element = current_box.closest('.audio-box').next();
    }else if(current_box.closest('.audio-box').prev().length){
        var next_box_element = current_box.closest('.audio-box').prev();
    }
    if(next_box_element){
        next_box_element.removeClass("hide-box").addClass("show-box");
        current_box.closest('.audio-box').fadeOut(1, function(){ $(this).addClass("hide-box").removeClass("show-box");});;
    }
    
    var side_link_html = $(".playlist_item_"+file_id).data("fname");
    $(".playlist_item_"+file_id).html(side_link_html+classification_icon);

    current_box.closest('.audio-box').attr("data-classification-type",classification_type);

    //highlight
    $('.playlist_item').removeClass("highlighted_track");
    $(".playlist_item_"+file_id).next().addClass("highlighted_track");

    //************************
    var done_items = 0;
    var total_items = 0;
    $(".audio-box").each(function (index, box) {
        if($(box).attr("data-classification-type")){
            done_items++;
        }
        total_items++;
    });
    var class_percentage = (done_items / total_items)*100;
    $(".prog_percentage1").css("width",class_percentage+"%");
    $(".prog_percentage2").text(class_percentage+"%");
    $(".prog_percentage3").text(done_items);
    //************************
}

function clear_classification_local_storage(){
    var cr_url = location.href;
    // alert(cr_url);
    // return false;
    if (cr_url.indexOf('admin/files/classification') !== -1) {
        for (var i = 0; i < localStorage.length; i++){
            var gen_current_item = localStorage.key(i);
            if (gen_current_item.indexOf('classification_') !== -1) {
                localStorage.removeItem(gen_current_item);
            }
            // $('body').append(localStorage.getItem(localStorage.key(i)));
        }
    }
    window.location.reload();
}


//***********************************************************************************
function update_local_annotation(file_id,annotation_type,annotation_note){
    if (typeof(Storage) !== "undefined") {
        localStorage.setItem("annotation_"+file_id, annotation_type);
        localStorage.setItem("annotation_note_"+file_id, annotation_note);
    }
}
function clear_annotation_local_storage(){
    var cr_url = location.href;
    if (cr_url.indexOf('admin/files/annotation') !== -1) {
        for (var i = 0; i < localStorage.length; i++){
            var gen_current_item = localStorage.key(i);
            if (gen_current_item.indexOf('annotation_') !== -1) {
                localStorage.removeItem(gen_current_item);
            }
            // $('body').append(localStorage.getItem(localStorage.key(i)));
        }
    }
    window.location.reload();
}
function after_annotate_success(file_id,annotation_type,annotation_note,current_box,annotation_icon){
    update_local_annotation(file_id,annotation_type,annotation_note);
    if(current_box.closest('.audio-box').next().length){
        var next_box_element = current_box.closest('.audio-box').next();
    }else if(current_box.closest('.audio-box').prev().length){
        var next_box_element = current_box.closest('.audio-box').prev();
    }
    if(next_box_element){
        next_box_element.removeClass("hide-box").addClass("show-box");
        current_box.closest('.audio-box').fadeOut(1, function(){ $(this).addClass("hide-box").removeClass("show-box");});;
    }
    
    var side_link_html = $(".playlist_item_"+file_id).data("fname");
    $(".playlist_item_"+file_id).html(side_link_html+annotation_icon);
    current_box.closest('.audio-box').attr("data-annotation-type",annotation_type);

    //highlight
    $('.playlist_item').removeClass("highlighted_track");
    $(".playlist_item_"+file_id).next().addClass("highlighted_track");
    //************************
    var done_items = 0;
    var total_items = 0;
    $(".audio-box").each(function (index, box) {
        if($(box).attr("data-annotation-type")){
            done_items++;
        }
        total_items++;
    });
    var percentage = (done_items / total_items)*100;
    $(".prog_percentage1").css("width",percentage+"%");
    $(".prog_percentage2").text(percentage+"%");
    $(".prog_percentage3").text(done_items);
    //************************
}





//***********************************************************************************
function update_local_review(file_id,review_type,annotation_note,review_note){
    if (typeof(Storage) !== "undefined") {
        localStorage.setItem("review_"+file_id, review_type);
        localStorage.setItem("review_note_"+file_id, review_note);
        localStorage.setItem("review_ann_note_"+file_id, annotation_note);
    }
}
function clear_review_local_storage(){
    var cr_url = location.href;
    if (cr_url.indexOf('admin/files/review') !== -1) {
        for (var i = 0; i < localStorage.length; i++){
            var gen_current_item = localStorage.key(i);
            if (gen_current_item.indexOf('review_') !== -1) {
                localStorage.removeItem(gen_current_item);
            }
            // $('body').append(localStorage.getItem(localStorage.key(i)));
        }
    }
    window.location.reload();
}
function after_review_success(file_id,review_type,annotation_note,review_note,current_box,review_icon){
    update_local_review(file_id,review_type,annotation_note,review_note);
    // current_box.closest('.audio-box').fadeOut(700, function(){ $(this).remove();});;
    if(current_box.closest('.audio-box').next().length){
        var next_box_element = current_box.closest('.audio-box').next();
    }else if(current_box.closest('.audio-box').prev().length){
        var next_box_element = current_box.closest('.audio-box').prev();
    }
    if(next_box_element){
        next_box_element.removeClass("hide-box").addClass("show-box");
        current_box.closest('.audio-box').fadeOut(1, function(){ $(this).addClass("hide-box").removeClass("show-box");});;
    }
    
    var side_link_html = $(".playlist_item_"+file_id).data("fname");
    $(".playlist_item_"+file_id).html(side_link_html+review_icon);
    current_box.closest('.audio-box').attr("data-review-type",review_type);

    //highlight
    $('.playlist_item').removeClass("highlighted_track");
    $(".playlist_item_"+file_id).next().addClass("highlighted_track");

    //************************
    var done_items = 0;
    var total_items = 0;
    $(".audio-box").each(function (index, box) {
        if($(box).attr("data-review-type")){
            done_items++;
        }
        total_items++;
    });
    var percentage = (done_items / total_items)*100;
    $(".prog_percentage1").css("width",percentage+"%");
    $(".prog_percentage2").text(percentage+"%");
    $(".prog_percentage3").text(done_items);
    //************************
}
//***********************************************************************************
function isEmpty( el ){
    return !$.trim(el.html())
}
$("#load-files").click(function(e){
    if ($('#classification-files').find(".audio-box").length) {
        alert("You should finish  the loaded files first.");
        return false;
    }
	e.preventDefault();
	$.ajax({
        type: "POST",
        url: ajax_url+"/files/load_files_classification",
        dataType: 'json',
        data: {
            "_csrfToken": _csrfToken,
        },
    }).done(function(data) {
    	if(data.status){
    		$("#classification-files").html(data.html);
            $(".playlist_menu").html(data.playlist_menu);
            $("#files_progress").html(data.progress_html);
            window.location.reload();
    	}else{
    		$("#classification-files").html("<p class='classify-error-msg'>"+data.error_msg+"</p>");
    	}
    });
});


$.createEventCapturing = (function () {
    var special = $.event.special;
    return function (names) {
        if (!document.addEventListener) {
            return;
        }
        if (typeof names == 'string') {
            names = [names];
        }
        $.each(names, function (i, name) {
            var handler = function (e) {
                e = $.event.fix(e);

                return $.event.dispatch.call(this, e);
            };
            special[name] = special[name] || {};
            if (special[name].setup || special[name].teardown) {
                return;
            }
            $.extend(special[name], {
                setup: function () {
                    this.addEventListener(name, handler, true);
                },
                teardown: function () {
                    this.removeEventListener(name, handler, true);
                }
            });
        });
    };
})();


$.createEventCapturing(['play','pause']);  

// $('body').on('pause', '.audio-elm', function(event) {
$('#classification-files').on('pause', '.audio-elm', function(event) {
	$(".audio-box").removeClass("active-box");
	$(".audio-box").removeClass("inactive-box");
	$(this).closest(".audio-box").addClass("active-box");
	
});
// $('body').on('play', '.audio-elm', function(event) {
$('#classification-files').on('play', '.audio-elm', function(event) {
	$(".audio-box").removeClass("active-box");
	$(".audio-box").removeClass("inactive-box");
	
	$(this).closest(".audio-box").addClass("active-box");
	$(".audio-elm").not(this).closest(".audio-box").addClass("inactive-box");
  	$(".audio-elm").not(this).each(function (index, audio) {
    	audio.pause();
  	});
});


$('#classification-files').on('click', '.classification-actions a', function(e) {
	e.preventDefault();
	var current_box = $(this);
	var classification_type = current_box.data("classification-type");
	var file_id = current_box.data("file-id");

    var classification_icon = "";
    if(classification_type=="1"){
        classification_icon = "<i class='fas fa-check'></i>";
    }else if(classification_type=="2"){
        classification_icon = "<i class='fas fa-ban'></i>";
    }else{
        classification_icon = "<i class='fas fa-border-all'></i>";
    }

    after_classify_success(file_id,classification_type,current_box,classification_icon);

    $.ajax({
        type: "POST",
        url: ajax_url+"/files/classify",
        dataType: 'json',
        cache: false,
        data: {
            "classification_type": classification_type,
            "file_id": file_id,
            "_csrfToken": _csrfToken,
        },
    }).done(function(data) {
        
    });
    

	// $.ajax({
 //        type: "POST",
 //        url: ajax_url+"/files/classify",
 //        dataType: 'json',
 //        cache: false,
 //        data: {
 //            "classification_type": classification_type,
 //            "file_id": file_id,
 //            "_csrfToken": _csrfToken,
 //        },
 //    }).done(function(data) {
 //    	if(data.status){
 //            //indexed db
 //            update_local_classification(file_id,classification_type);
 //            if(current_box.closest('.audio-box').next().length){
 //                var next_box_element = current_box.closest('.audio-box').next();
 //            }else if(current_box.closest('.audio-box').prev().length){
 //                var next_box_element = current_box.closest('.audio-box').prev();
 //            }
 //            if(next_box_element){
 //                next_box_element.removeClass("hide-box").addClass("show-box");
 //    		    current_box.closest('.audio-box').fadeOut(1, function(){ $(this).addClass("hide-box").removeClass("show-box");});;
 //            }
            
 //            var side_link_html = $(".playlist_item_"+file_id).data("fname");
 //            $(".playlist_item_"+file_id).html(side_link_html+classification_icon);

 //            current_box.closest('.audio-box').attr("data-classification-type",classification_type);

 //            //highlight
 //            $('.playlist_item').removeClass("highlighted_track");
 //            $(".playlist_item_"+file_id).next().addClass("highlighted_track");

 //            //************************
 //            var done_items = 0;
 //            var total_items = 0;
 //            $(".audio-box").each(function (index, box) {
 //                if($(box).attr("data-classification-type")){
 //                    done_items++;
 //                }
 //                total_items++;
 //            });
 //            var class_percentage = (done_items / total_items)*100;
 //            $(".prog_percentage1").css("width",class_percentage+"%");
 //            $(".prog_percentage2").text(class_percentage+"%");
 //            $(".prog_percentage3").text(done_items);
 //            //************************

 //    	}else{
 //    		alert(data.error_msg)
 //    	}
 //    });
});
$('.playlist_menu').on('click', '.playlist_item', function(e) {
    e.preventDefault();
    var file_id  = $(this).data("file-id");
    $(".audio-box").removeClass("show-box").addClass("hide-box");
    $(".file_box_"+file_id).removeClass("hide-box").addClass("show-box");

    //highlight
    $('.playlist_item').removeClass("highlighted_track");
    $(this).addClass("highlighted_track");
});

$('.submit_classified_files').click(function(e){
    e.preventDefault();
    var classified_data = [];
    $(".audio-box").each(function (index, box) {
        box_classification_type = $(box).attr("data-classification-type");
        // alert(box_classification_type)
        box_file_id = $(box).attr("data-file-id");
        if(box_classification_type){
            classified_data[box_file_id]=box_classification_type;
        }
    });
    
    if(classified_data){
        $.ajax({
            type: "POST",
            url: ajax_url+"/files/submit_classified_files",
            dataType: 'json',
            data: {
                "_csrfToken": _csrfToken,
                "classified_data": classified_data,
            },
        }).done(function(data) {
            if(data.status){
                clear_classification_local_storage()
                
            }else{
                alert("No data to submit.")
            }
        });
    }
});

$('body').on('click', '.load_next_file', function(e) {
// $('.load_next_file').click(function(e){
    e.preventDefault();
    var current_abox = $(".audio-box.show-box");
    if(current_abox.next('.audio-box').length){
        current_abox.removeClass("show-box").addClass("hide-box");
        current_abox.next('.audio-box').fadeOut(1, function(){ $(this).addClass("show-box").removeClass("hide-box");});;

        //highlight
        var next_file_id = current_abox.next('.audio-box').attr("data-file-id");
        if(next_file_id){
            $('.playlist_item').removeClass("highlighted_track");
            $('.playlist_item_'+next_file_id).addClass("highlighted_track");
        }
    }
});

$('body').on('click', '.load_prev_file', function(e) {
// $('.load_prev_file').click(function(e){
    e.preventDefault();
    var current_abox = $(".audio-box.show-box");
    if(current_abox.prev('.audio-box').length){
        current_abox.fadeOut(1, function(){ $(this).removeClass("show-box").addClass("hide-box");});
        current_abox.prev('.audio-box').fadeOut(1, function(){ $(this).addClass("show-box").removeClass("hide-box");});;

        //highlight
        var prev_file_id = current_abox.prev('.audio-box').attr("data-file-id");
        if(prev_file_id){
            $('.playlist_item').removeClass("highlighted_track");
            $('.playlist_item_'+prev_file_id).addClass("highlighted_track");
        }
    }
});


//************************* Annotation *************************
$("#load-annotation-files").click(function(e){
    if ($('#annotation-files').find(".audio-box").length) {
        alert("You should finish  the loaded files first.");
        return false;
    }
	e.preventDefault();
	$.ajax({
        type: "POST",
        url: ajax_url+"/files/load_files_annotation",
        dataType: 'json',
        data: {
            "_csrfToken": _csrfToken,
        },
    }).done(function(data) {
    	if(data.status){
    		$("#annotation-files").html(data.html);
            $(".playlist_menu").html(data.playlist_menu);
            $("#files_progress").html(data.progress_html)
            window.location.reload();
    	}else{
    		$("#annotation-files").html("<p class='classify-error-msg'>"+data.error_msg+"</p>");
    	}
    });
});
$('#annotation-files').on('click', '.annotation-actions a', function(e) {
	e.preventDefault();
	var current_box = $(this);
	var annotation_type = current_box.data("annotation-type");
	var file_id = current_box.data("file-id");
	var annotation_note = current_box.closest('.audio-box').find("textarea").val();
	if (!$.trim(annotation_note)) {
	    alert("You should add text on 'Annotate' textarea.");
	    return false;
	}

    var annotation_icon = "";
    if(annotation_type=="1"){
        annotation_icon = "<i class='fas fa-check'></i>";
    }
    after_annotate_success(file_id,annotation_type,annotation_note,current_box,annotation_icon);
	$.ajax({
        type: "POST",
        url: ajax_url+"/files/annotate",
        dataType: 'json',
        cache: false,
        data: {
            "annotation_type": annotation_type,
            "file_id": file_id,
            "annotation_note": annotation_note,
            "_csrfToken": _csrfToken,
        },
    }).done(function(data) {
    	
    });
});


$('.submit_annotated_files').click(function(e){
    e.preventDefault();
    var annotated_data = [];
    $(".audio-box").each(function (index, box) {
        box_annotation_type = $(box).attr("data-annotation-type");
        // alert(box_classification_type)
        box_file_id = $(box).attr("data-file-id");
        annotation_note = $(box).find(".annotation_note").val();
        if(box_annotation_type){
            annotated_data[box_file_id]=annotation_note;
        }
    });
    
    if(annotated_data){
        $.ajax({
            type: "POST",
            url: ajax_url+"/files/submit_annotated_files",
            dataType: 'json',
            data: {
                "_csrfToken": _csrfToken,
                "annotated_data": annotated_data,
            },
        }).done(function(data) {
            if(data.status){
                clear_annotation_local_storage();
                // window.location.reload();
            }else{
                alert("No data to submit.")
            }
        });
    }
});


//************************* Review *************************
$("#load-review-files").click(function(e){
    if ($('#review-files').find(".audio-box").length) {
        alert("You should finish  the loaded files first.");
        return false;
    }
	e.preventDefault();
	$.ajax({
        type: "POST",
        url: ajax_url+"/files/load_files_review",
        dataType: 'json',
        data: {
            "_csrfToken": _csrfToken,
        },
    }).done(function(data) {
    	if(data.status){
    		$("#review-files").html(data.html);
            $(".playlist_menu").html(data.playlist_menu);
            $("#files_progress").html(data.progress_html);
            window.location.reload();
    	}else{
    		$("#review-files").html("<p class='classify-error-msg'>"+data.error_msg+"</p>");
    	}
    });
});

$('#review-files').on('click', '.review-actions a', function(e) {
	e.preventDefault();
	var current_box = $(this);
	var review_type = current_box.data("review-type");
	var file_id = current_box.data("file-id");
	
    var annotation_note = current_box.closest('.audio-box').find("textarea.annotation_note").val();
    var review_note = current_box.closest('.audio-box').find("textarea.review_note").val();
	if (!$.trim(review_note)) {
	    alert("You should add text on 'review' textarea.");
	    return false;
	}
    if (!$.trim(annotation_note)) {
        alert("You should add text on 'Annotation' textarea.");
        return false;
    }
    var review_icon = "";
    if(review_type=="1"){
        review_icon = "<i class='fas fa-check'></i>";
    }
    after_review_success(file_id,review_type,annotation_note,review_note,current_box,review_icon);
	$.ajax({
        type: "POST",
        url: ajax_url+"/files/do_review",
        dataType: 'json',
        cache: false,
        data: {
            "review_type": review_type,
            "file_id": file_id,
            "review_note": review_note,
            "annotation_note": annotation_note,
            "_csrfToken": _csrfToken,
        },
    }).done(function(data) {

    });
});


$('.submit_reviewed_files').click(function(e){
    e.preventDefault();
    var reviewed_data = [];
    $(".audio-box").each(function (index, box) {
        box_review_type = $(box).attr("data-review-type");
        // alert(box_classification_type)
        box_file_id = $(box).attr("data-file-id");
        review_note = $(box).find(".review_note").val();
        if(box_review_type){
            reviewed_data[box_file_id]=review_note;
        }
    });
    
    if(reviewed_data){
        $.ajax({
            type: "POST",
            url: ajax_url+"/files/submit_reviewed_files",
            dataType: 'json',
            data: {
                "_csrfToken": _csrfToken,
                "reviewed_data": reviewed_data,
            },
        }).done(function(data) {
            if(data.status){
                clear_review_local_storage();
                // window.location.reload();
            }else{
                alert("No data to submit.")
            }
        });
    }
});

