$(document).ready(function() {
    console.log('jQuery is ready');
    let questionCount = 0;

    $('#add-question').click(function() {
        questionCount++;
        
        // Clone the question template
        var newQuestion = $('#question-template').clone();
        newQuestion.removeAttr('id');
        newQuestion.find('.question-box_header_question').attr('placeholder', 'Question ' + questionCount);
        newQuestion.find('.question-box_option-block_option-text').attr('placeholder', 'Option 1');
        newQuestion.show(); // Ensure the cloned template is visible

        // Append the cloned question to the form container
        $('#question-template').parent().append(newQuestion).append('<br>');

        // Bind question type change handler for the new question
        newQuestion.find('#question-type').on('change', function() {
            const selectedType = $(this).val();
            const image = $(this).closest('.question-box').find('#question-type-image');
            const optionsContainer = $(this).closest('.question-box').find('#options-container');
            const shortAnswerContainer = $(this).closest('.question-box').find('.question-box_short-answer');

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

            // Set the data attribute to the current question type
            $(this).closest('.question-box').attr('data-question-type', selectedType);
        }).trigger('change'); // Trigger change to set the initial image
    });

    $(document).on('click', '#add-option', function() {
        // Find the closest question box and its current question type
        const questionBox = $(this).closest('.question-box');
        const currentQuestionType = questionBox.attr('data-question-type');
        
        // Increment the option count
        let optionCount = questionBox.find('.question-box_option-block').length + 1;

        // Clone the template
        var newOption = $('#option-template').clone();
        newOption.removeAttr('id');
        newOption.find('input').val(''); 
        newOption.find('input').attr('placeholder', 'Option ' + optionCount); 

        // Set the appropriate image based on the current question type
        if (currentQuestionType === 'multiple-choice') {
            newOption.find('img').attr('src', base_url+'assets/images/circle.png');
        } else if (currentQuestionType === 'checkbox') {
            newOption.find('img').attr('src', base_url+'assets/images/square.png');
        }

        // Add close button to the new option if more than one option exists
        if (optionCount > 1) {
            newOption.append('<button class="question-box_option-block_option-close"><img src="'+base_url+'assets/images/close.png" alt="close option"></button>');
        }

        // Append the cloned option to new options space
        questionBox.find('#new-options').append(newOption).append('<br>');
    });

    $(document).on('click', '.question-box_option-block_option-close', function() {
        $(this).closest('.question-box_option-block').next('br').remove(); // Remove the <br> after the option
        $(this).closest('.question-box_option-block').remove(); // Remove the option
    });

    $(document).on('click', '.delete-question', function() {
        $(this).closest('.question-box').next('br').remove(); // Remove the <br> after the question box
        $(this).closest('.question-box').remove(); // Remove the question box
    });

    $(document).on('click', '.duplicate-question', function() {
        const originalQuestion = $(this).closest('.question-box'); // Get the closest question box
        console.log('Original Question:', originalQuestion);

        //selectedType = originalQuestion.attr('data-question-type');
        
        // Clone the original question box
        const duplicateQuestion = originalQuestion.clone();
        console.log('Duplicate Question Before Modifying:', duplicateQuestion);

        // Remove IDs from the cloned question to avoid duplicate IDs
        duplicateQuestion.removeAttr('id');
       

        console.log('Duplicate Question After Removing IDs:', duplicateQuestion);
        // Ensure the cloned question is visible
        duplicateQuestion.show();
        console.log('Duplicate Question After Show:', duplicateQuestion);

        // Append the duplicated question after the original question
        originalQuestion.after(duplicateQuestion).after('<br>');
        console.log('Duplicate Question Added to DOM');
        
        duplicateQuestion.find('#question-type').on('change', function() {
            
            const selectedType = $(this).val();
            const image = $(this).closest('.question-box').find('#question-type-image');
            const optionsContainer = $(this).closest('.question-box').find('#options-container');
            const shortAnswerContainer = $(this).closest('.question-box').find('.question-box_short-answer');

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

            // Set the data attribute to the current question type
            $(this).closest('.question-box').attr('data-question-type', selectedType);
        }).trigger('change'); // Trigger change to set the initial image
    });

    // Initial question type change handler for the existing question template
    $('#question-type').on('change', function() {
        const selectedType = $(this).val();
        const image = $('#question-type-image');
        const optionsContainer = $('#options-container');
        const shortAnswerContainer = $('.question-box_short-answer');

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

        // Set the data attribute to the current question type
        $(this).closest('.question-box').attr('data-question-type', selectedType);
    }).trigger('change'); // Trigger change to set the initial image

    function previewForm() {
        // Collect the form data
        var formTitle = $('#form-title').val();
        var formDesc = $('#form-desc').val();
        var questions = [];

        $('.question-box:visible').each(function() {
            var questionText = $(this).find('.question-box_header_question').val();
            var options = [];

            $(this).find('.question-box_option-block').each(function() {
                var optionText = $(this).find('.question-box_option-block_option-text').val();
                if (optionText) {
                    options.push(optionText);
                }
            });

            questions.push({
                questionText: questionText,
                options: options
            });
        });

        // Store the form data in localStorage
        localStorage.setItem('formTitle', formTitle);
        localStorage.setItem('formDesc', formDesc);
        localStorage.setItem('questions', JSON.stringify(questions));

        // Open the preview page
        window.open('preview.html', '_blank');
    }
});
