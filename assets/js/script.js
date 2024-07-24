$(document).ready(function() {
    console.log('jQuery is ready');
    let questionCount = 0;

    // Make the question container sortable
    $('.form_container').sortable({
        items: '.question-box:visible',
        handle: '.question-box_header',
        placeholder: 'sortable-placeholder',
        update: function(event, ui) {
            // Handle the order update here if needed
            updateQuestionOrder();
        }
    });

    // Add new question
    $('#add-question').click(function() {
        questionCount++;

        // Clone the question template
        var newQuestion = $('#question-template').clone();
        newQuestion.removeAttr('id');
        newQuestion.attr('data-question-type', 'multiple-choice'); // Set default question type
        newQuestion.find('.question-box_header_question').attr('placeholder', 'Question ' );
        newQuestion.find('.question-box_option-block_option-text').attr('placeholder', 'Option 1');
        newQuestion.show(); // Ensure the cloned template is visible

        // Append the cloned question to the form container
        $('#question-template').parent().append(newQuestion);

        // Scroll to the newly added question and set it as active
        setActiveQuestion(newQuestion);

        //update sidebar
        updateSidebarMarginTop();
        
       
    });

    // Add new option to a question
    $(document).on('click', '#add-option', function() {
        const questionBox = $(this).closest('.question-box');
        const currentQuestionType = questionBox.attr('data-question-type');
        let optionCount = questionBox.find('.question-box_option-block').length + 1;

        var newOption = $('#option-template').clone();
        newOption.removeAttr('id');
        newOption.find('input').val('');
        newOption.find('input').attr('placeholder', 'Option ' + optionCount);

        if (currentQuestionType === 'multiple-choice') {
            newOption.find('img').attr('src', base_url+'assets/images/circle.png');
        } else if (currentQuestionType === 'checkbox') {
            newOption.find('img').attr('src', base_url+'assets/images/square.png');
        }
          else if (currentQuestionType === 'dropdown') {
            newOption.find('img').attr('src', base_url+'assets/images/down-arrow.png');
        }

        if (optionCount > 1) {
            newOption.append('<button class="question-box_option-block_option-close"><img src="'+base_url+'assets/images/close.png" alt="close option"></button>');
        }

        questionBox.find('#new-options').append(newOption).append('<br>');
    });

    // Remove an option from a question
    $(document).on('click', '.question-box_option-block_option-close', function() {
        $(this).closest('.question-box_option-block').next('br').remove();
        $(this).closest('.question-box_option-block').remove();
    });

    // Delete a question
    $(document).on('click', '.delete-question', function() {
        questionCount = questionCount - 1;
        var questionBox = $(this).closest('.question-box');
        var prevQuestionBox = questionBox.prev('.question-box');
        var nextQuestionBox = questionBox.next('.question-box');
        
        questionBox.next('br').remove(); // Remove the adjacent <br> element
        questionBox.remove(); // Remove the question box
    
        if (nextQuestionBox.length) {
            setActiveQuestion(nextQuestionBox);
        } else if (prevQuestionBox.length) {
            setActiveQuestion(prevQuestionBox);
        } else {
            // No questions left, align sidebar with form container top
            setActiveQuestion($([])); // Pass an empty jQuery object
        }

        //update sidebar
        updateSidebarMarginTop();
       
    });

    // Duplicate a question
    $(document).on('click', '.duplicate-question', function() {
        const originalQuestion = $(this).closest('.question-box');
        const duplicateQuestion = originalQuestion.clone();

        duplicateQuestion.removeAttr('id');
        duplicateQuestion.show();

        originalQuestion.after(duplicateQuestion).after('<br>');
    });

    // Handle question type change
    $(document).on('change', '#question-type', function() {
        const selectedType = $(this).val();
        const questionBox = $(this).closest('.question-box');
        const image = questionBox.find('#question-type-image');
        const optionsContainer = questionBox.find('#options-container');
        const shortAnswerContainer = questionBox.find('.question-box_short-answer');

        if (selectedType === 'multiple-choice') {
            image.attr('src', base_url+'assets/images/circle.png');
            image.attr('alt', 'Circle for Multiple Choice');
            optionsContainer.show();
            shortAnswerContainer.hide();
        } else if (selectedType === 'checkbox') {
            image.attr('src', base_url+'assets/images/square.png');
            image.attr('alt', 'Square for Checkbox');
            optionsContainer.show();
            shortAnswerContainer.hide();
        } 
          else if (selectedType === 'dropdown') {
            image.attr('src', base_url+'assets/images/down-arrow.png');
            image.attr('alt', 'down arrow for dropdown');
            optionsContainer.show();
            shortAnswerContainer.hide();
        }
          else if (selectedType === 'paragraph') {
            image.attr('src', '');
            image.attr('alt', '');
            optionsContainer.hide();
            shortAnswerContainer.show();
        }

        questionBox.attr('data-question-type', selectedType);
    }).trigger('change');

    function setActiveQuestion(questionBox) {
        // Remove active class from all question boxes
        $('.question-box').removeClass('active');
    
        // Add active class to the clicked question box
        questionBox.addClass('active');    
    }

    // Add click event listener to all question boxes to set active question
    $(document).on('click', '.question-box', function() {
        setActiveQuestion($(this));  
        //update sidebar
        updateSidebarMarginTop();
    });

    //update Sidebar Margin
    function updateSidebarMarginTop() {
        var sidebar = $('.sidebar');
        var questionCount = $('.question-box').length;
        var referencePoint = $('.reference-point');
        var activeQuestionBox = $('.question-box.active');
    
        if (questionCount === 0) {
            sidebar.css('margin-top', '0px');
        } else if (questionCount === 1) {
            sidebar.css('margin-top', '185px');
        } else {
            if (activeQuestionBox.length) {
                // Calculate the offset of the active question from the reference point
                var referenceOffsetTop = referencePoint.offset().top;
                var activeBoxOffsetTop = activeQuestionBox.offset().top;
                var offsetTop = activeBoxOffsetTop - referenceOffsetTop;
    
                sidebar.css('margin-top', offsetTop + 'px');
            }
        }
    }



    // Submit form
    $('#submit-form').click(function() {
        var formData = {
            title: $('#form-title').val(),
            description: $('#form-desc').val(),
            questions: []
        };

        $('.question-box:visible').each(function() {
            var questionBox = $(this);
            var questionData = {
                question: questionBox.find('.question-box_header_question').val(),
                type: questionBox.find('#question-type').val(),
                required: questionBox.find('.required-checkbox').is(':checked') ? 1 : 0,
                options: []
            };

            if (questionData.type !== 'paragraph') {
                questionBox.find('.question-box_option-block').each(function() {
                    var optionText = $(this).find('.question-box_option-block_option-text').val();
                    if (optionText) {
                        questionData.options.push(optionText);
                    }
                });
            }

            formData.questions.push(questionData);
        });

        console.log(formData);

        $.ajax({
            url: base_url+'forms/submit_form',
            type: 'POST',
            data: { formData: JSON.stringify(formData) },
            success: function(response) {
                console.log('Form data submitted successfully:', response);
                window.location.href = base_url + 'my_drafts';
            },
            error: function(xhr, status, error) {
                console.error('Error submitting form data:', error);
            }
        });
    });

    // Function to update question order
    function updateQuestionOrder() {
        // Here you can handle the update event if needed, e.g., save the new order to the database
        console.log('Question order updated');
    }
});



    $(document).ready(function() {
        $('#update-form').click(function() {
            var form_id = $(this).data('form_id');
            var title = $('#form-title').val();
            var description = $('#form-desc').val();
            var questions = [];
    
            $('.question-box:visible').each(function() {
                var question_id = $(this).data('question_id');
                var question_text = $(this).find('.question-box_header_question').val();
                var question_type = $(this).find('#question-type').val();
                var options = [];
    
                $(this).find('.question-box_option-block').each(function() {
                    var option_id = $(this).data('option_id');
                    var option_text = $(this).find('input').val();
                    options.push({
                        option_id: option_id,
                        option_text: option_text
                    });
                });
    
                questions.push({
                    question_id: question_id,
                    question_text: question_text,
                    question_type: question_type,
                    options: options
                });
            });
    
            var formData = {
                form_id: form_id,
                title: title,
                description: description,
                questions: JSON.stringify(questions)
            };
    
            console.log(formData);
    
            $.ajax({
                url: base_url + 'forms/update_form',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    console.log('Form updated successfully:', response);
                    window.location.href = base_url + 'my_drafts';
                    // Handle success response
                },
                error: function(xhr, status, error) {
                    console.error('Error updating form:', error);
                    console.log(error);
                    // Handle error
                }
            });
        });
    });

    $(document).ready(function() {
        // Handle dropdowns with initial "Choose" option
        $('select[data-initial-value="choose"]').on('change', function() {
            var $this = $(this);
            if ($this.val() === "") {
                $this.addClass('default-value');
            } else {
                $this.removeClass('default-value');
            }
        });
    
        $(document).ready(function() {
            $('#response-form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            alert('Response submitted successfully!');
                            // Optionally, you can clear the form or redirect the user
                            window.location.href = base_url + 'my_forms';
                        } else if (data.errors) {
                            // Clear previous error messages
                            $('.error-message').remove();
        
                            // Display validation errors
                            $.each(data.errors, function(question_id, error_message) {
                                var questionBox = $('div[data-question-id="' + question_id + '"]');
                                questionBox.append('<div class="error-message" style="color:red;">' + error_message + '</div>');
                            });
                        } else {
                            alert('An error occurred. Please try again.');
                        }
                    },
                    error: function() {
                        alert('An error occurred. Please try again.');
                    }
                });
            });
        });
            
    });