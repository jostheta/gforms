
<div class="page_layout">
    <br>
    <div class="section">
        <div class="form_container">
            <div class="form_container_top">
                <input type="text" id="form-title" class="form_container_top_title" style="color: black;" placeholder="Untitled Form">
                <input type="text" id="form-desc" class="form_container_top_desc" style="color: black;" placeholder="Form Description">
            </div>

            <br>
            <!-- New Questions will get added here -->
            <div class="question-box" id="question-template" style="display:none;">
                <!-- This is the question-box header contains question, type, add an img -->
                <div class="question-box_header">
                    <input type="text" id="" class="question-box_header_question" style="color: black;" placeholder="Question">
                    <img src="<?= base_url() ?>assets/images/image.png" alt="add an image" height="20px" width="20px">
                    <div class="question-box_header_question-type">
                        <select id="question-type" class="question-box_header_question-type_select">
                            <option value="multiple-choice">Multiple choice</option>
                            <option value="checkbox">Checkbox</option>
                            <option value="paragraph">Paragraph</option>
                        </select>
                    </div>
                </div>
                <!-- These are the style buttons to style your question -->
                <div class="question-box_header-style">
                    &nbsp;
                    <button><img src="<?= base_url() ?>assets/images/bold.png" width="14px" height="14px"></button>
                    <button><img src="<?= base_url() ?>assets/images/italics.png" width="14px" height="14px"></button>
                    <button><img src="<?= base_url() ?>assets/images/underline.png" width="16px" height="16px"></button>
                </div>
                <br>

                <!-- Add a textarea for short answer type -->
                <div class="question-box_short-answer" style="display: none;">
                    <div class="question-box_short-answer_placeholder">Paragraph</div>
                </div>

                <!-- These are the options -->
                <div id="options-container">
                    <div class="question-box_option-block" id="option-template">
                        <img id="question-type-image" src="<?= base_url() ?>assets/images/circle.png" alt="option circle" width="16px" height="16px">
                        <input type="text" placeholder="Option1" class="question-box_option-block_option-text">
                    </div>
                    <br>
                    <!-- New options should be appended here -->
                    <div id="new-options"></div>
                    <!-- To Add a new option -->
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
        </div>

        <div class="sidebar">
            <button id="add-question">
                <img src="<?= base_url() ?>assets/images/add.png" width="20px" height="20px" alt="add button">
                <button id="submit-form" style="color: #fff; background-color: #1a73e8; font-weight: 500; padding: 10px; border: none;">Submit</button>
            </button>
        </div>
    </div>
</div>

    <!-- now we are trying the side bar -->
    
    
    
     <!-- Include jQuery from a CDN -->
     <!-- <script src="<?= base_url() ?>assets/js/jquery.js"></script> -->
    <!-- Link to external script -->
    <!-- <script src="<?= base_url() ?>assets/js/script.js"></script> -->
   

