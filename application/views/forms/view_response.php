<div class="page_layout">
    <br>
    <div class="section">
        <div class="form_container-response">
            <div class="form_container_top">
                <div class="form_container_top_title" style="border-bottom:none;">
                    <?= htmlspecialchars($form->title, ENT_QUOTES, 'UTF-8') ?>
                </div>
                <div class="form_container_top_desc" style="border-bottom:none;">
                    <?= htmlspecialchars($form->description, ENT_QUOTES, 'UTF-8') ?>
                </div>
                <div>
                    <br>
                    <div class="form_container_top_user-details">
                        Response ID: <?= $response->response_id ?>
                    </div>
                    <div class="form_container_top_user-details">
                        Submitted At: <?= date('Y-m-d H:i:s', strtotime($response->created_at)) ?>
                    </div>
                </div>
            </div>

            <div id="questions-container">
                <?php if (!empty($questions)) : ?>
                    <?php foreach ($questions as $index => $question) : ?>
                        <div class="question-box" data-question-type="<?= htmlspecialchars($question->question_type, ENT_QUOTES, 'UTF-8') ?>">
                            <div class="question-box_header">
                                <div class="response-questions" style="color:black;">
                                    <?= htmlspecialchars($question->question_text, ENT_QUOTES, 'UTF-8') ?>
                                </div>
                            </div>
                            <br>
                            <?php
                            $answer_texts = [];
                            foreach ($response->answers as $answer) {
                                if ($answer->question_id == $question->question_id) {
                                    $answer_texts[] = htmlspecialchars($answer->answer_text, ENT_QUOTES, 'UTF-8');
                                }
                            }
                            ?>
                            <?php if ($question->question_type == 'paragraph') : ?>
                                <div class="question-box_short-answer">
                                    <textarea class="response-text-area" name="responses[<?= $question->question_id ?>]" placeholder="Paragraph" readonly><?= implode("\n", $answer_texts) ?></textarea>
                                </div>
                            <?php elseif ($question->question_type == 'dropdown') : ?>
                                <div class="question-box_dropdown">
                                    <select name="responses[<?= $question->question_id ?>]" class="form-control" disabled>
                                        <option value="">Select an option</option>
                                        <?php foreach ($question->options as $option) : ?>
                                            <option value="<?= htmlspecialchars($option->option_text, ENT_QUOTES, 'UTF-8') ?>" <?= in_array(htmlspecialchars($option->option_text, ENT_QUOTES, 'UTF-8'), $answer_texts) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($option->option_text, ENT_QUOTES, 'UTF-8') ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php else : ?>
                                <div id="options-container">
                                    <?php if (!empty($question->options)) : ?>
                                        <?php foreach ($question->options as $optionIndex => $option) : ?>
                                            <div class="question-box_option-block" id="option-template" data-option_id="<?= htmlspecialchars($option->option_id, ENT_QUOTES, 'UTF-8') ?>">
                                                <?php if ($question->question_type == 'multiple-choice') : ?>
                                                    &nbsp;<input type="radio" id="option-<?= $optionIndex ?>" name="responses[<?= $question->question_id ?>]" value="<?= htmlspecialchars($option->option_text, ENT_QUOTES, 'UTF-8') ?>" <?= (in_array(htmlspecialchars($option->option_text, ENT_QUOTES, 'UTF-8'), $answer_texts)) ? 'checked' : '' ?> disabled>
                                                    <label style="padding-top:12px;" for="option-<?= $optionIndex ?>"><?= htmlspecialchars($option->option_text, ENT_QUOTES, 'UTF-8') ?></label>
                                                <?php elseif ($question->question_type == 'checkbox') : ?>
                                                    &nbsp;<input type="checkbox" id="option-<?= $optionIndex ?>" name="responses[<?= $question->question_id ?>][]" value="<?= htmlspecialchars($option->option_text, ENT_QUOTES, 'UTF-8') ?>" <?= (in_array(htmlspecialchars($option->option_text, ENT_QUOTES, 'UTF-8'), $answer_texts)) ? 'checked' : '' ?> disabled>
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
        </div>
    </div>
</div>
