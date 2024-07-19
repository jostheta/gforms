$(document).ready(function() {
    console.log('jQuery is ready');
    let questionCount = 0;

    // Add new question
    $('#add-question').click(function() {
        questionCount++;

        // Clone the question template
        var newQuestion = $('#question-template').clone();
        newQuestion.removeAttr('id');
        newQuestion.attr('data-question-type', 'multiple-choice'); // Set default question type
        newQuestion.find('.question-box_header_question').attr('placeholder', 'Question ' + questionCount);
        newQuestion.find('.question-box_option-block_option-text').attr('placeholder', 'Option 1');
        newQuestion.show(); // Ensure the cloned template is visible

        // Append the cloned question to the form container
        $('#question-template').parent().append(newQuestion);

        // Scroll to the newly added question and set it as active
        setActiveQuestion(newQuestion);
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
        $(this).closest('.question-box').next('br').remove();
        $(this).closest('.question-box').remove();
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
        } else if (selectedType === 'paragraph') {
            image.attr('src', '');
            image.attr('alt', '');
            optionsContainer.hide();
            shortAnswerContainer.show();
        }

        questionBox.attr('data-question-type', selectedType);
    }).trigger('change');

    // Function to set the active question and scroll the sidebar
    function setActiveQuestion(questionBox) {
        // Remove active class from all question boxes
        $('.question-box').removeClass('active');

        // Add active class to the clicked question box
        questionBox.addClass('active');

        // Scroll sidebar to the active question
        var offset = questionBox.offset().top - $('.sidebar').offset().top;
        $('.sidebar').animate({
            scrollTop: offset + $('.sidebar').scrollTop()
        }, 500);
    }

    // Add click event listener to all question boxes to set active question
    $(document).on('click', '.question-box', function() {
        setActiveQuestion($(this));
    });

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
        $('#response-form').on('submit', function(e) {
            e.preventDefault();
    
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: $(this).serialize(),
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        alert('Response submitted successfully!');
                        // Optionally, you can clear the form or redirect the user
                        window.location.href = base_url + 'my_forms';
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
       
    

