// Get the step elements and buttons
const steps = document.getElementsByClassName("step");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");

var request_busy = false;

document.getElementById('search-courses-steps').addEventListener("submit", function (event) {
    event.preventDefault();
});


// Get the timeline items
const timelineItems = document.getElementsByClassName("timeline-item");

// Function to show the current step
function showStep(stepIndex) {


    // Hide all steps
    for (let i = 0; i < steps.length; i++) {
        steps[i].classList.remove("active");
    }

    for (let i = 0; i < timelineItems.length; i++) {
        timelineItems[i].classList.remove("active");
    }

    if (stepIndex == 0)
        $('.timeline').hide();
    else
        $('.timeline').show();

    // Show the current step
    timelineItems[stepIndex].classList.add("active");

    // Show the current step
    steps[stepIndex].classList.add("active");

    if (prevBtn) {
        // Update the buttons
        if (stepIndex === 0) {
            prevBtn.style.display = "none"; // Hide previous button on first step
        } else {
            prevBtn.style.display = "inline-block";
        }
    }

    if (stepIndex === steps.length - 1) {
        nextBtn.innerHTML = "Submit"; // Change next button text on last step
    } else {
        nextBtn.innerHTML = "Next";
    }
}

// Function to go to the next step
// function nextStep() {
//     if (currentStep < steps.length - 1) {
//         currentStep++;
//         showStep(currentStep);
//     } else {
//         // Perform form submission or validation here
//         // Submit the form data
//         // ...
//     }
// }

// Function to go to the previous step
function prevStep() {
    if (currentStep > 0) {
        currentStep--;
        showStep(currentStep);
    }
}

// Event listeners for button clicks
nextBtn.addEventListener("click", nextStep);

if (prevBtn) {
    prevBtn.addEventListener("click", prevStep);
}

// Show the initial step
showStep(currentStep);

// Function to update the active step and timeline
function updateStep(stepIndex) {
    // Hide all steps
    for (let i = 0; i < steps.length; i++) {
        steps[i].classList.remove("active");
    }
    // console.log(timelineItems);
    for (let i = 0; i < timelineItems.length; i++) {
        timelineItems[i].classList.remove("active");
    }

    if (stepIndex == 0)
        $('.timeline').hide();
    else
        $('.timeline').show();

    alert(stepIndex);
    $('#laststep').val(stepIndex);
    currentStep = stepIndex;
    // Show the current step
    steps[stepIndex].classList.add("active");
    timelineItems[stepIndex].classList.add("active");

    if (prevBtn) {
        // Update the buttons
        if (stepIndex === 0) {
            prevBtn.style.display = "none"; // Hide previous button on first step
        } else {
            prevBtn.style.display = "inline-block";
        }

    }
    if (stepIndex === steps.length - 1) {
        nextBtn.innerHTML = "Finish"; // Change next button text on last step
    } else {

        if (currentStep == 0) {
            nextBtn.innerHTML = "Agree and Continue";
            // nextBtn.innerHTML = "Continue" + ' <img src="/img/new-images/chevron-left.png" alt="">';
        } else {
            nextBtn.innerHTML = "Continue";
            // nextBtn.innerHTML = "Continue" + ' <img src="/img/new-images/chevron-left.png" alt="">';
        }
    }
}

// Function to go to the next step
function nextStep() {

    //  else {
    //     // Perform form submission or validation here
    //     // Submit the form data
    //     // ...
    // }
    // alert('T1 - '+currentStep);
    // alert('T1');
    $('.timeline').show();
    if (currentStep == 0) {

        $('.timeline').hide();
        // if (document.getElementById('study_level_id').value == '' || document.getElementById('study_level_id').value == undefined) {
        //   alert("Please select an option.");
        //   return false;
        // }
        // document.getElementById('subject-area-id').value='';
        // document.getElementById('study_level_id').value='';

        // var elements = document.querySelectorAll('.level-box');
        // for (var i = 0; i < elements.length; i++) {
        //   elements[i].classList.remove('active');
        // }
        // var elements = document.querySelectorAll('.course-box');
        // for (var i = 0; i < elements.length; i++) {
        //   elements[i].classList.remove('active');
        // }
        $('#laststep').val(0);
        if ($('#id').val() == undefined || $('#id').val() == '') {
            $('#search-courses-steps').validate({
                rules: {

                    'first_name': {
                        required: true,
                    },
                    'last_name': {
                        required: true,
                    },
                    'mobile': {
                        required: true,
                        minlength: 7,
                        maxlength: 13
                    },
                    'email': {
                        required: true,
                        email: true
                    },
                    'password': {
                        required: true,
                    },
                    'passwd': {
                        required: true,
                    },
                    // 'nationality_id': {
                    //   required: true
                    // },
                    'country_id': {
                        required: true,
                    },
                    'mobile': {
                        required: true,
                    },
                    'mobile_code': {
                        required: true,
                    },
                    'current_status': {
                        required: true,
                    },
                    // 'current_study_level': {
                    //   required: true,
                    // },
                    // 'destination_id': {
                    //   required: true,
                    // },
                    // 'subject_area_id': {
                    //   required: true,
                    // },
                    // 'city': {
                    //   required: true,
                    // },
                },
                messages: {

                },
                errorClass: "error-message",
                errorElement: "div",
                errorPlacement: function (error, element) {
                    error.insertAfter(element, false);
                },
                submitHandler: function (form) {
                    // form.submit();

                    registerSubmitForm(form);
                }
            });
        } else {

            registerSubmitForm($('#search-courses-steps'));
        }

    } else if (currentStep == 1) {
        $('#laststep').val(1);
        alert('ssssssssss');
        $('#search-courses-steps').validate({
            rules: {

                'subject_area_id': {
                    required: true,
                },
            },
            messages: {

            },
            errorClass: "error-message",
            errorElement: "div",
            errorPlacement: function (error, element) {
                error.insertAfter(element, false);
            },
            submitHandler: function (form) {
                registerSubmitForm($('#search-courses-steps'));
            }
        });
        // if (document.getElementById('subject-area-id').value == '' && document.getElementById('study_level_id').value == '') {
        //     alert("Please select an option.");
        //     return false;
        // }

        // var checkboxes = document.querySelectorAll('input[name="country_id[]"]');
        // for (var i = 0; i < checkboxes.length; i++) {
        //   checkboxes[i].checked = false;
        // }
        // document.getElementById('curriculum').value = '';

    } else if (currentStep == 2) {
        $('#laststep').val(2);
        $('#search-courses-steps').validate({
            rules: {

                'study_level_id': {
                    required: true,
                },
            },
            messages: {

            },
            errorClass: "error-message",
            errorElement: "div",
            errorPlacement: function (error, element) {
                error.insertAfter(element, false);
            },
            submitHandler: function (form) {
                registerSubmitForm($('#search-courses-steps'));
            }
        });
        // var checkboxes = document.querySelectorAll('input[name="country_id[]"]');
        // var atLeastOneChecked = false;
        // for (var i = 0; i < checkboxes.length; i++) {
        //   if (checkboxes[i].checked) {
        //     atLeastOneChecked = true;
        //     break;
        //   }
        // }
        // if (!atLeastOneChecked && document.getElementById('curriculum').value == '') {
        //   alert("Please select an option.");
        //   return false;
        // }
    } else if (currentStep == 3) {
        $('#laststep').val(3);
        $('#search-courses-steps').validate({
            rules: {

                'country_id': {
                    required: true,
                },
            },
            messages: {

            },
            errorClass: "error-message",
            errorElement: "div",
            errorPlacement: function (error, element) {
                error.insertAfter(element, false);
            },
            submitHandler: function (form) {
                registerSubmitForm($('#search-courses-steps'));
            }
        });
    } else if (currentStep == 4) {
        $('#laststep').val(4);
        $('#search-courses-steps').validate({
            rules: {

                'budget': {
                    required: true,
                },
            },
            messages: {

            },
            errorClass: "error-message",
            errorElement: "div",
            errorPlacement: function (error, element) {
                error.insertAfter(element, false);
            },
            submitHandler: function (form) {
                registerSubmitForm($('#search-courses-steps'));
            }
        });
    }

    if (currentStep < steps.length - 1 && currentStep != 0) {
        currentStep++;
        updateStep(currentStep);
    } else {
        // var form = document.getElementById('search-courses-steps');
        // form.submit();
    }
}


function registerSubmitForm(form, register) {

    if (!request_busy) {

        $('body').LoadingOverlay("show");

        request_busy = true;
        // $('#registerbox .modalMsg').append("<div class='remodal-loading'></div>");
        $.ajax({
            type: "POST",
            url: $(form).prop('action'),
            data: $(form).serialize(),
            dataType: 'json',
        }).done(function (data) {
            request_busy = false;
            $('.remodal-loading').remove();
            // console.log(data.status);
            if (data.status) {


                // notification('success', data.message, data.title);


                $('.error-message').remove();
                // $(form)[0].reset();


                $('#id').val(data.user.id);

                alert(data.laststep);
                console.log(data.user);
                currentStep++;
                updateStep(currentStep);
                // reLoadCaptchaV3();

            } else {

                $('body').LoadingOverlay("hide");

                // notification('error', data.message, data.title);


                var rmodal_id = 'modalMsg';

                // reLoadCaptchaV3();
                $('.error-message').remove();
                if (data['validationErrors']) {
                    for (i in data.validationErrors) {
                        if (typeof (data.validationErrors[i]) === 'object') {
                            var errors_array = data.validationErrors[i];
                            for (j in errors_array) {
                                $(form).find('*[name="' + i + '"]').parent().append('<div class="error-message">' + errors_array[j] + '</div>');
                            }
                        } else {
                            $(form).find('*[name="' + i + '"]').parent().append('<div class="error-message">' + data.validationErrors[i] + '</div>');
                        }
                    }
                }

            }

            $('.modalMsg #msgText').html(data.message);
            var inst = $('[data-remodal-id=modalMsg]').remodal();
            inst.open();
        });

        $('body').LoadingOverlay("hide");
    }
}
// Function to go to the previous step
function prevStep() {
    if (currentStep > 0) {
        // Delete activity from current step
        const currentTimelineItem = timelineItems[currentStep];
        currentTimelineItem.classList.remove("active");

        currentStep--;
        updateStep(currentStep);
    }
}

// Event listeners for button clicks
nextBtn.addEventListener("click", nextStep);

if (prevBtn) {
    prevBtn.addEventListener("click", prevStep);
}
// Event listeners for timeline item clicks
for (let i = 0; i < timelineItems.length; i++) {
    timelineItems[i].addEventListener("click", () => {
        updateStep(i);
    });
}

// Show the initial step and timeline
updateStep(currentStep);
