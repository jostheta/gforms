<div class="page_layout">
    <br>
    <div class="section">
        <div class="form_container-response">
            <div class="form_container_top">
                <div class = "form_container_top_title"><?= htmlspecialchars($form->title, ENT_QUOTES, 'UTF-8') ?></div>
                <div class = "form_container_top_desc"><?= htmlspecialchars($form->description, ENT_QUOTES, 'UTF-8') ?></div>
            </div>
            <form id="response-form" action="<?= base_url('forms/submit_response') ?>" method="post">
                <input type="hidden" name="form_id" value="<?= $form->form_id ?>">
                <div id="questions-container">
                    <?php if (!empty($questions)) : ?>
                        <?php foreach ($questions as $index => $question) : ?>
                            <div class="question-box" data-question-type="<?= htmlspecialchars($question->question_type, ENT_QUOTES, 'UTF-8') ?>">
                                <div class="question-box_header">
                                    <div class="response-questions" ><?= htmlspecialchars($question->question_text, ENT_QUOTES, 'UTF-8') ?></div>
                                </div>
                                <br>
                                <?php if ($question->question_type == 'paragraph') : ?>
                                    <div class="question-box_short-answer">
                                        <textarea class="response-text-area" style="color:black;font-style:normal;" name="responses[<?= $question->question_id ?>]" placeholder="Your Answer"></textarea>
                                    </div>
                                <?php else : ?>
                                    <div id="options-container">
                                        <?php if (!empty($question->options)) : ?>
                                            <?php foreach ($question->options as $optionIndex => $option) : ?>
                                                <div class="question-box_option-block" id="option-template" data-option_id="<?= htmlspecialchars($option->option_id, ENT_QUOTES, 'UTF-8') ?>" >
                                                    <?php if ($question->question_type == 'multiple-choice') : ?>
                                                        &nbsp;<input type="radio" id="option-<?= $optionIndex ?>" name="responses[<?= $question->question_id ?>]" value="<?= htmlspecialchars($option->option_text, ENT_QUOTES, 'UTF-8') ?>">
                                                        <label style="padding-top:12px;"for="option-<?= $optionIndex ?>"><?= htmlspecialchars($option->option_text, ENT_QUOTES, 'UTF-8') ?></label>
                                                    <?php elseif ($question->question_type == 'checkbox') : ?>
                                                        &nbsp;<input type="checkbox" id="option-<?= $optionIndex ?>" name="responses[<?= $question->question_id ?>][]" value="<?= htmlspecialchars($option->option_text, ENT_QUOTES, 'UTF-8') ?>">
                                                        <label style="padding-top:12px;" for="option-<?= $optionIndex ?>"><?= htmlspecialchars($option->option_text, ENT_QUOTES, 'UTF-8') ?></label>
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
                <button class="response-submit" type="submit" >Submit</button>
            </form>
        </div>
    </div>
</div>
