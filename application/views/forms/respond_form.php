<div class="page_layout">
    <br>
    <div class="section">
        <div class="form_container-response">
            <div class="form_container_top">
                <div class="form_container_top_title"><?= htmlspecialchars($form->title, ENT_QUOTES, 'UTF-8') ?></div>
                <div class="form_container_top_desc"><?= htmlspecialchars($form->description, ENT_QUOTES, 'UTF-8') ?>
                </div>
            </div>
            <form id="response-form" action="<?= base_url('forms/submit_response') ?>" method="post">
                <input type="hidden" name="form_id" value="<?= $form->form_id ?>">
                <div id="questions-container">
                    <?php if (!empty($questions)): ?>
                        <?php
                        $errors = $this->session->flashdata('errors');
                        $responses = $this->session->flashdata('responses');
                        ?>
                        <?php foreach ($questions as $index => $question): ?>
                            <div class="question-box"
                                data-question-type="<?= htmlspecialchars($question->question_type, ENT_QUOTES, 'UTF-8') ?>"
                                data-required="<?= $question->is_required ? 'true' : 'false' ?>">
                                <div class="question-box_header">
                                    <div class="response-questions">
                                        <?= htmlspecialchars($question->question_text, ENT_QUOTES, 'UTF-8') ?>
                                        <?= $question->is_required ? '<span style="color:red;">*</span>' : '' ?>
                                    </div>
                                    <?php if (!empty($errors[$question->question_id])): ?>
                                        <div class="error-message" style="color:red;">
                                            <?= htmlspecialchars($errors[$question->question_id], ENT_QUOTES, 'UTF-8') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <br>
                                <?php if ($question->question_type == 'paragraph'): ?>
                                    <div class="question-box_short-answer">
                                        <textarea class="response-text-area" style="color:black;font-style:normal;"
                                            name="responses[<?= $question->question_id ?>]"
                                            placeholder="Your Answer"><?php echo isset($responses[$question->question_id]) ? htmlspecialchars($responses[$question->question_id], ENT_QUOTES, 'UTF-8') : ''; ?></textarea>

                                    </div>
                                <?php else: ?>
                                    <div id="options-container">
                                        <?php if (!empty($question->options)): ?>
                                            <?php if ($question->question_type == 'dropdown'): ?>
                                                <select name="responses[<?= $question->question_id ?>]" class="form-control"
                                                    data-initial-value="choose">
                                                    <option value="" selected disabled>Choose</option>
                                                    <?php foreach ($question->options as $optionIndex => $option): ?>
                                                        <option value="<?= htmlspecialchars($option->option_text, ENT_QUOTES, 'UTF-8') ?>"
                                                            <?= isset($responses[$question->question_id]) && $responses[$question->question_id] == $option->option_text ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($option->option_text, ENT_QUOTES, 'UTF-8') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            <?php else: ?>
                                                <?php foreach ($question->options as $optionIndex => $option): ?>
                                                    <div class="question-box_option-block" id="option-template"
                                                        data-option_id="<?= htmlspecialchars($option->option_id, ENT_QUOTES, 'UTF-8') ?>">
                                                        <?php if ($question->question_type == 'multiple-choice'): ?>
                                                            &nbsp;<input type="radio" id="option-<?= $optionIndex ?>"
                                                                name="responses[<?= $question->question_id ?>]"
                                                                value="<?= htmlspecialchars($option->option_text, ENT_QUOTES, 'UTF-8') ?>"
                                                                <?= isset($responses[$question->question_id]) && $responses[$question->question_id] == $option->option_text ? 'checked' : '' ?>>
                                                            <label style="padding-top:12px;"
                                                                for="option-<?= $optionIndex ?>"><?= htmlspecialchars($option->option_text, ENT_QUOTES, 'UTF-8') ?></label>
                                                        <?php elseif ($question->question_type == 'checkbox'): ?>
                                                            &nbsp;<input type="checkbox" id="option-<?= $optionIndex ?>"
                                                                name="responses[<?= $question->question_id ?>][]"
                                                                value="<?= htmlspecialchars($option->option_text, ENT_QUOTES, 'UTF-8') ?>"
                                                                <?= isset($responses[$question->question_id]) && in_array($option->option_text, $responses[$question->question_id]) ? 'checked' : '' ?>>
                                                            <label style="padding-top:12px;"
                                                                for="option-<?= $optionIndex ?>"><?= htmlspecialchars($option->option_text, ENT_QUOTES, 'UTF-8') ?></label>
                                                        <?php endif; ?>
                                                    </div>
                                                    <br>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <br>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No questions found for this form.</p>
                    <?php endif; ?>
                </div>
                <button class="response-submit" type="submit">Submit</button>
            </form>
        </div>
    </div>
</div>