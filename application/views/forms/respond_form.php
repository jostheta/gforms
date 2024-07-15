<div class="page_layout">
    <br>
    <div class="section">
        <div class="form-container">
            <h1><?= htmlspecialchars($form->title, ENT_QUOTES, 'UTF-8') ?></h1>
            <p><?= htmlspecialchars($form->description, ENT_QUOTES, 'UTF-8') ?></p>

            <form id="response-form" action="<?= base_url('forms/submit_response') ?>" method="post">
                <input type="hidden" name="form_id" value="<?= $form->form_id ?>">
                <div id="questions-container">
                    <?php if (!empty($questions)) : ?>
                        <?php foreach ($questions as $index => $question) : ?>
                            <div class="question-box" data-question-type="<?= htmlspecialchars($question->question_type, ENT_QUOTES, 'UTF-8') ?>">
                                <div class="question-box_header">
                                    <h3><?= htmlspecialchars($question->question_text, ENT_QUOTES, 'UTF-8') ?></h3>
                                </div>
                                <br>
                                <?php if ($question->question_type == 'paragraph') : ?>
                                    <div class="question-box_short-answer">
                                        <textarea name="responses[<?= $question->question_id ?>]" placeholder="Paragraph"></textarea>
                                    </div>
                                <?php else : ?>
                                    <div id="options-container">
                                        <?php if (!empty($question->options)) : ?>
                                            <?php foreach ($question->options as $optionIndex => $option) : ?>
                                                <div class="question-box_option-block" id="option-template" data-option_id="<?= htmlspecialchars($option->option_id, ENT_QUOTES, 'UTF-8') ?>" >
                                                    <?php if ($question->question_type == 'multiple-choice') : ?>
                                                        <input type="radio" id="option-<?= $optionIndex ?>" name="responses[<?= $question->question_id ?>]" value="<?= htmlspecialchars($option->option_text, ENT_QUOTES, 'UTF-8') ?>">
                                                        <label for="option-<?= $optionIndex ?>"><?= htmlspecialchars($option->option_text, ENT_QUOTES, 'UTF-8') ?></label>
                                                    <?php elseif ($question->question_type == 'checkbox') : ?>
                                                        <input type="checkbox" id="option-<?= $optionIndex ?>" name="responses[<?= $question->question_id ?>][]" value="<?= htmlspecialchars($option->option_text, ENT_QUOTES, 'UTF-8') ?>">
                                                        <label for="option-<?= $optionIndex ?>"><?= htmlspecialchars($option->option_text, ENT_QUOTES, 'UTF-8') ?></label>
                                                    <?php endif; ?>
                                                </div>
                                                <br>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <br>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>No questions found for this form.</p>
                    <?php endif; ?>
                </div>
                <button type="submit" style="color: #fff; background-color: #1a73e8; font-weight: 500; padding: 10px; border: none;">Submit</button>
            </form>
        </div>
    </div>
</div>
