<div class="content">
    <!-- Archive -->
    <div class="left-side f-left">
        <div class="archive info_box f-left">
            <div class="title">Archive</div>
            <div class="topic-quiz">
                <dl>
                    <!-- load all topics with quizes names -->
                    <?php foreach($topics as $t){
                         echo '<dt>'.$t->topicName.'</dt>';
                            foreach($t->quizes as $q) {
                                echo '<dd>'.$q->quizName.' '.($q->Launched == 1?'(Launched)':'').' </dd>';
                            }
                    } ?>
                </dl>
            </div>
            <div class="btn-row">
                <button class="btn btn-a9 f-right" data-toggle="modal" data-target="#myModal">Create New Topic</button>
            </div>
        </div>
    </div>

    <!-- detailed topics -->
    <div class="right-side f-left">
        <!-- load topics -->
        <?php foreach($topics as $t){ ?>
            <div class="topic info_box f-left">
                <div class="title center"><?php echo $t->topicName; ?></div>
                <div class="topic-quiz f-left">
                    <ul class="quiz-list f-lfet">
                        <!-- load every quizes in the topic -->
                        <?php foreach($t->quizes as $q) { ?>
                            <li id="<?php echo $t->topicName.' - '.$q->quizName; ?>" data-toggle="modal" data-target="#myModal3" class="open-m">
                                <input type="hidden" id="qid" value="<?php echo $q->quizId ?>" />
                                <input type="hidden" id="tid" value="<?php echo $q->topicId ?>" />
                                <div class="quiz-icon">
                                    <img src="<?php echo base_url('/assets/Img/icon-quiz.png');?>" width="60" height="60" />
                                </div>
                                <?php echo $q->quizName.($q->Launched == 1?'(Launched)':'') ?>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="btn-row top-line f-left">
                    <button class="btn btn-a9 f-right open-modal" data-toggle="modal" data-target="#myModal2" id="<?php echo $t->topicId; ?>" >Create New Quiz</button>
                </div>
            </div>
        <?php } ?>
    </div>


    <!-- Modal create new topic form -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <?php echo form_open('Quiz/save')?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Enter New Topic Name</h4>
                </div>
                <div class="modal-body">
                    <?php $input_arr = array('id'=>'topicName','class'=>'long','name'=>'topicname')?>
                    <p><?php echo form_input($input_arr); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-a9" value="Create" />
                </div>
                <?php echo form_close() ?>
            </div>

        </div>
    </div>
    <!-- end Modal1 -->

    <!-- Modal2 create new quizes form -->
    <div class="modal fade" id="myModal2" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <?php echo form_open('Quiz/save_quiz')?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Quiz Setting</h4>
                </div>
                <div class="modal-body">
                    <?php
                        $options = array(
                            '10' => '10 questions',
                            '20' => '20 questions'
                        )
                    ?>
                    <input type="hidden" id="t_id" name="topicid"/>
                    <div class="row">
                        <label>Quiz Name</label>
                        <?php echo form_input(array('id'=>'quizName','class'=>'medium','name'=>'quizname'))?>
                    </div>
                    <div class="row">
                        <label>Quiz Size</label>
                        <?php echo form_dropdown('quizsize',$options,'10') ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-a9" value="Create" />
                </div>
                <?php echo form_close() ?>
            </div>

        </div>
    </div>
    <!-- end Modal2 -->

    <!-- Modal3 create details of quiz  -->
    <div class="modal fade" id="myModal3" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <?php echo form_open('Quiz/question')?>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="m-title"></h4>
                </div>
                <div class="modal-body" style="text-align: center">
                    <img src="<?php echo base_url('assets/Img/icon-quiz.png') ?>" width="200" height="200"/>
                </div>

                <input type="hidden" id="topic_id" name="topicid" value=""/>
                <input type="hidden" id="quiz_id" name="quizid" value=""/>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-a9" value="View Questions"/>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
    <!-- end Modal3 -->

</div>

<script type="text/javascript">

    // pass data to modals when click to open modal
    $(document).ready(function(){
        $('.open-modal').click(function(){
            var topicid = $(this).attr('id');
            $('#t_id').val(topicid);
        })

        $('li.open-m').click(function(){
            var title = $(this).attr('id');
            var tid= $(this).children('input#tid').val();
            var qid= $(this).children('input#qid').val();
            $('h4#m-title').html(title);
            $('#topic_id').val(tid);
            $('#quiz_id').val(qid);
        })
    })

</script>
