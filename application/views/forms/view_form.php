<div class="page_layout">
    <br>
    <div class="section">
        <div class="form-container">
        <div class="form_container_top">
            <input type="text" id="form-title" value="<?= htmlspecialchars($form->title, ENT_QUOTES, 'UTF-8') ?>" class="form_container_top_title" style="color: black;" placeholder="Untitled Form">
            <input type="text" id="form-desc" value="<?= htmlspecialchars($form->description, ENT_QUOTES, 'UTF-8') ?>" class="form_container_top_desc" style="color: black;" placeholder="Form Description">
        </div>

            <div id="questions-container">
                <?php if (!empty($questions)) : ?>
                    <?php foreach ($questions as $index => $question) : ?>
                        <div class="question-box" data-question-type="<?= htmlspecialchars($question->question_type, ENT_QUOTES, 'UTF-8') ?>" data-question_id="<?= htmlspecialchars($question->question_id, ENT_QUOTES, 'UTF-8') ?>" id="question-template">
                            <div class="question-box_header">
                                <input type="text" value="<?= htmlspecialchars($question->question_text, ENT_QUOTES, 'UTF-8') ?>" class="question-box_header_question" style="color: black;" placeholder="Question <?= $index + 1 ?>">
                                <img src="<?= base_url() ?>assets/images/image.png" alt="add an image" height="20px" width="20px">
                                <div class="question-box_header_question-type">
                                    <select class="question-box_header_question-type_select">
                                        <option value="multiple-choice" <?= $question->question_type == 'multiple-choice' ? 'selected' : '' ?>>Multiple choice</option>
                                        <option value="checkbox" <?= $question->question_type == 'checkbox' ? 'selected' : '' ?>>Checkbox</option>
                                        <option value="dropdown" <?= $question->question_type == 'dropdown' ? 'selected' : '' ?>>Dropdown</option>
                                        <option value="paragraph" <?= $question->question_type == 'paragraph' ? 'selected' : '' ?>>Paragraph</option>
                                    </select>
                                </div>
                            </div>
                            <div class="question-box_header-style">
                                &nbsp;
                                <button><img src="<?= base_url() ?>assets/images/bold.png" width="14px" height="14px"></button>
                                <button><img src="<?= base_url() ?>assets/images/italics.png" width="14px" height="14px"></button>
                                <button><img src="<?= base_url() ?>assets/images/underline.png" width="16px" height="16px"></button>
                            </div>
                            <br>
                            <div class="question-box_short-answer" style="display: <?= $question->question_type == 'paragraph' ? 'block' : 'none' ?>;">
                                <div class="question-box_short-answer_placeholder">Paragraph</div>
                            </div>
                            <div class="options-container" style="display: <?= $question->question_type == 'paragraph' ? 'none' : 'block' ?>;">
                                <?php if (!empty($question->options)) : ?>
                                    <?php foreach ($question->options as $optionIndex => $option) : ?>
                                        <div class="question-box_option-block" data-option_id="<?= htmlspecialchars($option->option_id, ENT_QUOTES, 'UTF-8') ?>">
                                        <img class="question-type-image" src="<?= base_url() ?>assets/images/<?= $question->question_type == 'multiple-choice' ? 'circle' : ($question->question_type == 'checkbox' ? 'square' : ($question->question_type == 'dropdown' ? 'down-arrow' : '')) ?>.png" alt="option <?= $question->question_type ?>" width="16px" height="16px">
                                            <input type="text" value="<?= htmlspecialchars($option->option_text, ENT_QUOTES, 'UTF-8') ?>" class="question-box_option-block_option-text" placeholder="Option <?= $optionIndex + 1 ?>">
                                            <?php if ($optionIndex > 0) : ?>
                                                <button class="question-box_option-block_option-close"><img src="<?= base_url() ?>assets/images/close.png" alt="close option"></button>
                                            <?php endif; ?>
                                        </div>
                                       <br>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <div id="new-options"></div>
                                <div class="question-box_add-option">
                                    <button class="add-option" style="color:#1a73e8;font-weight: 500;">Add Option</button>
                                </div>
                            </div>
                            <div class="question-box_footer">
                                <button class="duplicate-question"><img src="<?= base_url() ?>assets/images/duplicate.png" width="24px" height="24px"></button>
                                <button class="delete-question"><img src="<?= base_url() ?>assets/images/trash.png" alt="delete question"></button>
                                <label class="checkbox-inline"> Required 
                                    <input type="checkbox" class="required-checkbox" <?= $question->is_required ? 'checked' : '' ?>>
                                </label>
                            </div>
                        </div>
                        <br>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>No questions found for this form.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="sidebar">
            <button id="add-question">
                <img src="<?= base_url() ?>assets/images/add.png" width="20px" height="20px" alt="add button">
            </button>
        </div>
    </div>
    <button class="update-form-button"id="update-form" data-form_id="<?= $form->form_id; ?>">Update</button>
</div>

<!-- Option Template -->
<div id="option-template" style="display:none;">
    <div class="question-box_option-block">
        <img class="question-type-image" src="<?= base_url() ?>assets/images/circle.png" alt="option multiple-choice" width="16px" height="16px">
        <input type="text" class="question-box_option-block_option-text" placeholder="Option">
        <button class="question-box_option-block_option-close"><img src="<?= base_url() ?>assets/images/close.png" alt="close option"></button>
    </div>
</div>

<script type="text/javascript">
    var base_url = '<?= base_url() ?>';
</script>
<script src="<?= base_url() ?>assets/js/jquery.js"></script>
<script src="<?= base_url() ?>assets/js/edit.js"></script>
</body>
</html>
