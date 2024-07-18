<div class="page_layout">
    <br>
    <div class="section">
        <div class="form_container-response">
         <div class="form_container_top">
            <div class = "form_container_top_title"><?= htmlspecialchars($form->title, ENT_QUOTES, 'UTF-8') ?></div>
            <div class = "form_container_top_desc"><?= htmlspecialchars($form->description, ENT_QUOTES, 'UTF-8') ?></div>
        </div>  

            <div id="questions-container">
                <?php if (!empty($questions)) : ?>
                    <?php foreach ($questions as $index => $question) : ?>
                        <div class="question-box" data-question-type="<?= htmlspecialchars($question->question_type, ENT_QUOTES, 'UTF-8') ?>" id="question-template" data-question_id="<?=htmlspecialchars($question->question_id, ENT_QUOTES, 'UTF-8')?>">
                            <div class="question-box_header">
                                <div class="response-questions" style="color:black;"><?= htmlspecialchars($question->question_text, ENT_QUOTES, 'UTF-8') ?></div>
                            </div>
                            <br>
                            <?php if ($question->question_type == 'paragraph') : ?>
                                <div class="question-box_short-answer">
                                <textarea class="response-text-area" placeholder="Your Answer"></textarea>
                                </div>
                            <?php else : ?>
                                <div id="options-container">
                                    <?php if (!empty($question->options)) : ?>
                                        <?php foreach ($question->options as $optionIndex => $option) : ?>
                                            <div class="question-box_option-block" id="option-template" data-option_id="<?=htmlspecialchars($option->option_id, ENT_QUOTES, 'UTF-8') ?>" >
                                                <?php if ($question->question_type == 'multiple-choice') : ?>
                                                    &nbsp;<input type="radio" id="option-<?= $optionIndex ?>" name="question-<?= $index ?>">
                                                    <label style="padding-top:12px;" for="option-<?= $optionIndex ?>"><?= htmlspecialchars($option->option_text, ENT_QUOTES, 'UTF-8') ?></label>
                                                <?php elseif ($question->question_type == 'checkbox') : ?>
                                                    &nbsp;<input type="checkbox" id="option-<?= $optionIndex ?>" name="question-<?= $index ?>[]">
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
            <a class = "publish-button"href="<?= base_url() ?>forms/publish_form/<?=$form->form_id?> ">Publish</a>
        </div>
    </div>
</div>
