<div class="content">
    <div class="content-inner">
        <div class="quiz">
            <div class="title"><?php echo $title; ?></div>
            <div class="questions top-line">
                <?php echo form_open('TakeQuiz/checkAnswer'); ?>
                <?php $q_num = 1; ?>
                <!-- load questions -->
                <?php if ($questions != null && sizeof($questions) > 0 ) {
                    foreach ($questions as $q) { ?>
                        <div class="mcq">
                            <div class="mcq-question">
                                <span><?php echo $q_num . ". "; ?></span><?php echo $q->q_content; ?>
                            </div>
                            <div class="mcq-answer-box">
                                <ul>
                                    <!-- load answers of the questions -->
                                    <?php foreach ($q->answers as $a) { ?>
                                        <li>
                                            <input type="radio" name="<?php echo 'question' . $q->question_id; ?>"
                                                   value="<?php echo $a->IsCorrect; ?>"/>
                                            <span class="mcq-answer">
                                                <?php echo $a->a_content; ?>
                                            </span>
                                        </li>

                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <?php
                        $q_num++;
                    }
                }?>
                <input type="hidden" name="quizid" value="<?php echo $quiz_id ?>'" />
                <input type="submit" class="btn btn-a9" value="Submit"/>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
