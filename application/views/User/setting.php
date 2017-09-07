<div class="content">
    <div class="content-inner f-left">
        <?php echo form_open_multipart('User/do_upload','id="setting"'); ?>

        <!-- show errors if there are errors -->
        <?php $msg = $this->session->flashdata('error');
                if (isset($msg)) { ?>
                <div class="err row f-left">
                    <ul>
                        <?php foreach($msg as $err){
                            echo "<li>".$err."</li>";
                        } ?>
                    </ul>

                </div>
        <?php } ?>

        <!-- nickname input -->
        <div class="row f-left">
            <?php echo form_label('Nickname'); ?>
            <?php
                $user_avail = isset($user) && sizeof($user)>0; // check whether user data is passed over
                $input_arr = array('id'=>'nickname','class'=>'medium','name'=>'nickname');
                if ($user_avail) {
                    $input_arr = array(
                        'id'=>'nickname',
                        'class'=>'medium',
                        'name'=>'nickname',
                        'value'=>$user[0]->nickname
                    );
                }
                echo form_input($input_arr);
            ?>
        </div>

        <!-- upload image -->
        <div class="row f-left">
            <label>Avatar</label>
            <div class="f-left r-box">
                <span class="tip f-left" <?php echo $user_avail?'style="display:inline-block"':''; ?>>
                    Click the photo to change
                </span>
                <div class="img-upload f-left" >
                    <span style="<?php echo $user_avail?'display:none':''?>">+upload photo</span>
                    <img id="thumbnail" width="199" height="199" alt="your image"
                         src="<?php echo $user_avail?base_url('/uploads/'.$user[0]->avatar):'#'; ?>"
                            style="<?php echo $user_avail?'display:block':''; ?>"/>
                </div>
                <input type="file" name="userfile" size="20" id="img_upload"/>
            </div>
        </div>
        <div class="row f-left">
            <label></label>
            <input type="submit" name="submit" value="Save" class="btn btn-a9"/>
        </div>
        <?php echo '</form>'; ?>
    </div>
</div>

<script type="text/javascript">

    // script for pre-load upload image
    $(document).ready(function(){
        $("div.img-upload").click(function(){
            $("#img_upload").click();
        });

        $("#img_upload").change(function(){
            readURL(document.getElementById("img_upload"));
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('img#thumbnail')
                        .attr('src', e.target.result);
                    $('img#thumbnail').show();
                    $("div.img-upload").children("span").hide();
                    $("div.img-upload").prev("span").show();
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    });

</script>