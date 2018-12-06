<?php include_once('TopNav.php'); ?>


<div class="container">
	<div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <?php if(isset($data) && count($data)>0){ ?>

                <div class="panel-heading text-info">
                    <h3 class="panel-title"><?php echo $data->title; ?>	</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <td><?php echo $data->description; ?></td>
                    </div>


                </div>
            </div>
        </div>



	</div>
	<?php }?>







        <div class="container">
            <div class="card">
                <div class="card-body">
                    <?php if(isset($comments)){  foreach ($comments as $c):?>
                    <div class="row">


                        <div class="col-md-1">
                            <img src="https://image.ibb.co/jw55Ex/def_face.jpg" class="img img-rounded img-fluid" width="50" height="50"/>

<!--                            <p class="text-secondary text-center">15 Minutes Ago</p>-->
                        </div>
                        <div class="col-md-11">
                            <p>
                               <strong class="text-primary"><?php echo $c->name; ?></strong>
                            </p>

<!--                            <div class="clearfix"></div>-->
                            <p><?php echo $c->message; ?></p><br>


<!--                            <p>-->
<!--                                <a class="float-right btn btn-outline-primary ml-2"> <i class="fa fa-reply"></i> Reply</a>-->
<!--                                <a class="float-right btn text-white btn-danger"> <i class="fa fa-heart"></i> Like</a>-->
<!--                            </p>-->
                        </div>
                         </div>



                        <?php
                        if(isset($c->reply)){?>


                            <div class="row" style="margin-left:60px; ">


                                <div class="col-md-1">
                                    <img src="https://image.ibb.co/jw55Ex/def_face.jpg" class="img img-rounded img-fluid" width="50" height="50"/>

                                    <!--                            <p class="text-secondary text-center">15 Minutes Ago</p>-->
                                </div>
                                <div class="col-md-11">
                                    <p>
                                        <strong class="text-primary"><?php echo ("Admin"); ?></strong>
                                    </p>
                                    <!--                            <div class="clearfix"></div>-->
                                    <p><?php echo $c->reply; ?></p><br>
                                </div>
                            </div>

                            <?php

                        }?>




                    <?php endforeach; } ?>




                      <!--end foreach comments -->
                </div>

            </div>

        </div>




</div>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
            <div class="Title-area">
                <h2 class="text-info">Comment</h2>
            </div><br>

        </div>
        <?php
        if(isset($_SESSION['public_user_name']) && isset($_SESSION['public_user_id'])){ ?>
        <div class="col-sm-6 col-md-8 no-padding">
            <div class="contact-us-1-form">
                <form onSubmit="return confirm('Comment Sent Successfully.Needs Approval from admin')" action="<?php echo Request::$BASE_URL; ?>index.php/post" method="POST">
                    <input type="hidden" name="table" value="comments">
                    <input type="hidden" name="user_public_id" value="<?php echo ($_SESSION['public_user_id']) ?>">
                    <input type="hidden" name="topic_id" value="<?php echo ($_GET['id']) ?>">
                    <input type="hidden" name="is_approved" value="0">

                    <div class="col-sm-12 no-padding contact-us-custom-padding">
                        <textarea class="form-control" rows="8" name="message" id="Message" placeholder="MESSAGE"></textarea>
                    </div><br>
                    <div class="col-sm-12 no-padding contact-us-custom-padding">
                        <input type="submit" name="submit" class="btn btn-success btn-block" value="Submit"><br><br><br>
                        </div>
                </form>
            </div>
        </div>

        <?php  }else
            {?>

            <div class="col-sm-6 col-md-8 no-padding">

                <?php
                echo("Please" )?>
                <a href="<?php echo Request::$BASE_URL; ?>index.php/login"> Login </a>
                <?php echo ("To Send Comment");

        } ?>

    <br><br><br></div>
            </div></div></div></div>
<!-- container ends -->


