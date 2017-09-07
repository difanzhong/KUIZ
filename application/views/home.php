<?php
/**
 * Created by PhpStorm.
 * User: difan
 * Date: 8/29/2015
 * Time: 10:47 PM
 */

//echo isset($_SESSION['username'])?$_SESSION['username']:'';
?>

<div class="content">
    <div class="left-side f-left">
        <div class="profile f-left">
            <div class='thumb f-left'>
                <img src="<?php echo base_url('/uploads/'.$student->avatar); ?>" width="100" height="100" style="border-radius:100%;margin:10% 0 2% 35%;" class="f-left"/>
            </div>
            <span><?php echo $student->nickname; ?></span>
        </div>
    </div>
    <div class="right-side f-left">
        <div class="timeline f-left">
            <?php if (isset($quizesDone) && sizeof($quizesDone) > 0){
                echo '<h4>Quizes I Have Done</h4>'; ?>
                    <div class="quizes-done-head f-left">
                        <div class="q-title f-left">Name</div>
                        <div class="score f-left">Score</div>
                        <div class="date f-left">Time</div>
                    </div>
                <?php foreach($quizesDone as $q){ ?>
                    <div class="quizes-done f-left">
                        <div class="q-title f-left"><?php echo $q->topicName.' -- '.$q->quizName; ?></div>
                        <div class="score f-left"><?php echo $q->score; ?></div>
                        <div class="date f-left"><?php echo $q->lastUpdate; ?></div>
                    </div>
                <?php }
                if (isset($availableQuizes) && sizeof($availableQuizes) > 0) {
                    echo "<p>Available Quizes:</p>";
                    foreach ($availableQuizes as $aq) {
                        echo '<p><a href="' . base_url("/TakeQuiz/Index/" . $aq->quizId) . '" >' . $aq->topicName . ' -- ' . $aq->quizName . '</a></p>';
                    }
                }
             }
            else{
                echo "<p>You Haven't Done Any Quizes.</p>";
                if (isset($availableQuizes) && sizeof($availableQuizes) > 0) {
                    echo "<p>Try Available Quizes:</p>";
                    foreach ($availableQuizes as $aq) {
                        echo '<p><a href="' . base_url("/TakeQuiz/Index/" . $aq->quizId) . '" >' . $aq->topicName . ' -- ' . $aq->quizName . '</a></p>';
                    }
                }
            }?>
        </div>
    </div>

</div>



