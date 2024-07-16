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

    
});
