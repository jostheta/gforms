<div class="page_layout">
    <br>
    <div class="section">
        <div class="form_container">
            <div class="form_container_top">
                <input type="text" id="form-title" class="form_container_top_title" style="color: black;" placeholder="Untitled Form" value="<?= $formData['form']['title']; ?>">
                <input type="text" id="form-desc" class="form_container_top_desc" style="color: black;" placeholder="Form Description" value="<?= $formData['form']['description']; ?>">
            </div>
            <br>
            
            <?php foreach ($formData['questions'] as $question): ?>
                <div class="question-box">
                    <div class="question-box_header">
                        <input type="text" class="question-box_header_question" style="color: black;" placeholder="Question" value="<?= $question['question_text']; ?>">
                        <img src="<?= base_url() ?>assets/images/image.png" alt="add an image" height="20px" width="20px">
                        <div class="question-box_header_question-type">
                            <select class="question-box_header_question-type_select">
                                <option value="multiple-choice" <?= $question['question_type'] == 'multiple-choice' ? 'selected' : ''; ?>>Multiple choice</option>
                                <option value="checkbox" <?= $question['question_type'] == 'checkbox' ? 'selected' : ''; ?>>Checkbox</option>
                                <option value="paragraph" <?= $question['question_type'] == 'paragraph' ? 'selected' : ''; ?>>Paragraph</option>
                            </select>
                        </div>
                    </div>
                    <div class="question-box_header-style">
                        &nbsp
                        <button><img src="<?= base_url() ?>assets/images/bold.png" width="14px" height="14px"></button>
                        <button><img src="<?= base_url() ?>assets/images/italics.png" width="14px" height="14px"></button>
                        <button><img src="<?= base_url() ?>assets/images/underline.png" width="16px" height="16px"></button>
                    </div>
                    <br>

                    <div class="question-box_short-answer" style="<?= $question['question_type'] == 'paragraph' ? '' : 'display: none;'; ?>">
                        <div class="question-box_short-answer_placeholder">Paragraph</div>
                    </div>

                    <div id="options-container" style="<?= $question['question_type'] != 'paragraph' ? '' : 'display: none;'; ?>">
                        <?php foreach ($question['options'] as $option): ?>
                            <div class="question-box_option-block">
                                <img src="<?= base_url() ?>assets/images/<?= $question['question_type'] == 'multiple-choice' ? 'circle' : 'square'; ?>.png" alt="option" width="16px" height="16px">
                                <input type="text" class="question-box_option-block_option-text" value="<?= $option['option_text']; ?>">
                                <button class="question-box_option-block_option-close"><img src="<?= base_url() ?>assets/images/close.png" alt="close option"></button>
                            </div>
                            <br>
                        <?php endforeach; ?>
                        <div id="new-options"></div>
                        <div class="question-box_add-option">
                            <button id="add-option" style="color:#1a73e8;font-weight: 500;">Add Option</button>
                        </div>
                    </div>

                    <div class="question-box_footer">
                        <button class="duplicate-question"><img src="<?= base_url() ?>assets/images/duplicate.png" width="24px" height="24px"></button>
                        <button class="delete-question"><img src="<?= base_url() ?>assets/images/trash.png" alt="delete question"></button>
                    </div>
                </div>
                <br>
            <?php endforeach; ?>
        </div>
    </div>
</div>
