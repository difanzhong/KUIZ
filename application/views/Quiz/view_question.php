<div class="content">
    <div class="content-inner">
        <div class="quiz">
            <div class="title"><?php echo $title; ?></div>
            <div class="questions top-line">
                <?php $q_num = 1; ?>
                <!-- load questions -->
                <?php if ($questions != null && sizeof($questions) > 0 ) {
                    foreach ($questions as $q) { ?>
                        <div class="mcq">
                            <div class="mcq-question">
                                <span><?php echo $q_num . ". "; ?></span><?php echo $q->q_content; ?></div>
                            <div class="mcq-answer-box">
                                <!-- load answers of this question -->
                                <ul>
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
                <?php
                    // check if the number of questions exceed the size of the quiz
                    if ($size > sizeof($questions)) {
                        echo '<button class="btn btn-a9 open-modal" data-toggle="modal" data-target="#myModal" id="'.$quiz_id.'">Add New Question</button>';
                    }
                    else if (!$Launched){
                        echo form_open("Quiz/Launch");
                        echo '<input type="hidden" name="quizid" value="'.$quiz_id.'" />';
                        echo '<input type="submit" class="btn btn-a9" value="Launch"/>';
                        echo form_close();
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal create question form-->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog long-modal">

        <!-- Modal content-->
        <?php echo form_open('Quiz/add_question')?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="m-title">Add New Question</h4>
            </div>
            <div class="modal-body" style="text-align: center">

                <div class="mcq">
                    <div class="mcq-question">
                        <div class="row">
                            <label>Question:</label>
                            <textarea name="question" class="f-left"></textarea>
                        </div>
                    </div>
                    <div class="mcq-answer-box">
                        <div class="row">
                            <label>Correct Answer</label>
                                <input type="text" name="correctAns" class="long f-left"/>
                        </div>
                        <div class="row">
                                <label>Other Answer</label>
                                <input type="text" name="answer[]" class="long f-left"/>
                            </div>
                        <div class="row">
                                <label>Other Answer</label>
                                <input type="text" name="answer[]" class="long f-left"/>
                            </div>
                        <div class="row">
                                <label>Other Answer</label>
                                <input type="text" name="answer[]" class="long f-left" />
                            </div>
                    </div>
                </div>
            </div>

            <input type="hidden" id="topic_id" name="topicid" value=""/>
            <input type="hidden" id="quiz_id" name="quizid" value=""/>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-a9" value="Create"/>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<!-- end Modal -->

<script type="text/javascript">

    // pass data when click to open modal
    $(document).ready(function() {
        $('.open-modal').click(function () {
            var qid = $(this).attr('id');
            $('#quiz_id').val(qid);
        });
    });

</script>