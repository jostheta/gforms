$(document).ready(function() {
    console.log('jQuery is ready');
    let questionCount = 0;

    $('#add-question').click(function() {
        questionCount++;
    
        // Clone the question template
        var newQuestion = $('#question-template').clone();
        newQuestion.removeAttr('id');
        newQuestion.attr('data-question-type', 'multiple-choice'); // Set default question type
        newQuestion.find('.question-box_header_question').attr('placeholder', 'Question ' + questionCount);
        newQuestion.find('.question-type-image').attr('src', base_url + 'assets/images/circle.png');
        newQuestion.find('.question-type-image').attr('alt', 'Circle for Multiple Choice');
    
        // Clear question text and remove existing options
        newQuestion.find('.question-box_header_question').val('');
        newQuestion.find('.question-box_option-block').each(function(index) {
            if (index === 0) {
                // Keep the first option placeholder text, clear others
                $(this).find('.question-box_option-block_option-text').val('').attr('placeholder', 'Option 1');
            } else {
                $(this).remove();
            }
        });
        newQuestion.find('.question-box_option-block:first').next('br').remove();
        newQuestion.find('#new-options').children('br').remove();
    
        newQuestion.show(); // Ensure the cloned template is visible
    
        // Append the cloned question to the form container
        $('#questions-container').append(newQuestion);
    });
    
    
//add new option
    $(document).on('click', '.add-option', function() {
        const questionBox = $(this).closest('.question-box');
        const currentQuestionType = questionBox.attr('data-question-type');
        let optionCount = questionBox.find('.question-box_option-block').length + 1;
    
        var newOption = $('#option-template .question-box_option-block').clone();
        newOption.find('input').val('');
        newOption.find('input').attr('placeholder', 'Option ' + optionCount);
    
        if (currentQuestionType === 'multiple-choice') {
            newOption.find('.question-type-image').attr('src', base_url + 'assets/images/circle.png');
            newOption.find('.question-type-image').attr('alt', 'Circle for Multiple Choice');
        } else if (currentQuestionType === 'checkbox') {
            newOption.find('.question-type-image').attr('src', base_url + 'assets/images/square.png');
            newOption.find('.question-type-image').attr('alt', 'Square for Checkbox');
        }
    
        // Check if the close button already exists before appending it
        if (optionCount > 1 && newOption.find('.question-box_option-block_option-close').length === 0) {
            newOption.append('<button class="question-box_option-block_option-close"><img src="' + base_url + 'assets/images/close.png" alt="close option"></button>');
        }
    
        // Append new option to the options container
        questionBox.find('#new-options').append(newOption);
    
        // Append <br> tag if it's not the last option
        if (optionCount > 1) {
            questionBox.find('#new-options').append('<br>');
        }
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
    $(document).on('change', '.question-box_header_question-type_select', function() {
        const selectedType = $(this).val();
        const questionBox = $(this).closest('.question-box');
        const images = questionBox.find('.question-type-image');
        const optionsContainer = questionBox.find('.options-container');
        const shortAnswerContainer = questionBox.find('.question-box_short-answer');

        if (selectedType === 'multiple-choice') {
            images.attr('src', base_url + 'assets/images/circle.png');
            images.attr('alt', 'Circle for Multiple Choice');
            optionsContainer.show();
            shortAnswerContainer.hide();
        } else if (selectedType === 'checkbox') {
            images.attr('src', base_url + 'assets/images/square.png');
            images.attr('alt', 'Square for Checkbox');
            optionsContainer.show();
            shortAnswerContainer.hide();
        } else if (selectedType === 'paragraph') {
            images.attr('src', '');
            images.attr('alt', '');
            optionsContainer.hide();
            shortAnswerContainer.show();
        }

        questionBox.attr('data-question-type', selectedType);
    }).trigger('change');

    $('#update-form').click(function() {
        var formData = {
            title: $('#form-title').val(),
            description: $('#form-desc').val(),
            questions: []
        };
    
        $('.question-box').each(function() {
            var questionBox = $(this);
            var questionData = {
                question_text: questionBox.find('.question-box_header_question').val(),
                question_type: questionBox.find('.question-box_header_question-type_select').val(),
                options: []
            };
    
            if (questionData.question_type !== 'paragraph') {
                questionBox.find('.question-box_option-block').each(function() {
                    var optionData = {
                        option_text: $(this).find('.question-box_option-block_option-text').val()
                    };
                    questionData.options.push(optionData);
                });
            }
    
            formData.questions.push(questionData);
        });
    
        console.log(formData);
    
        $.ajax({
            url: base_url + 'forms/edit_form',
            type: 'POST',
            data: { formData: JSON.stringify(formData) },
            success: function(response) {
                console.log('Form data updated successfully:', response);
                window.location.href = base_url + 'my_drafts';
            },
            error: function(xhr, status, error) {
                console.error('Error updating form data:', error);
            }
        });
    });
});
