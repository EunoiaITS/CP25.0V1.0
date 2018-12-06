<link rel="stylesheet" href="<?php echo Request::$BASE_URL; ?>css/intlTelInput.min.css">

<?php include_once('TopNav.php'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h1>Package Expired<small></small></h1>
            </div>
        </div>
    </div>

    <ol class="breadcrumb">
        <li><a href="<?php echo Request::$BASE_URL; ?>">Home</a></li>
        <li class="active">Package Expired</li>
    </ol>
    <div class="row">
        
        <label class="col-md-offset-3 col-md-6">
            <h3>Package Expired</h3>

            <h5><?php echo $user->first_name." ".$user->last_name; ?></h5>
            <form action="<?php echo Request::$BASE_URL; ?>index.php/makePayment" onSubmit="return valid()" method="POST">
                
                <input type="hidden" name="table" value="user_public" />
                <input type="hidden" name="id" value="<?php echo $user->id; ?>" />
                
                <div class="form-group">
    
                    <label>Subscription :</label>



                    <?php
                    $output = "<select id='country' name='subscription_package_id' required>"; 
                    $output .= "<option value='0'>Select Packages</option>";

                    foreach ($subscription_packages as $i) {
                        if($i->price>0){
                            if ($i->category == 'normal') {
                                $output .= "<optgroup label ='Normal'>";
    
                                $output .= "<option value='$i->id'";
                                if ($i == $subscription_packages) {
                                    $output .= " selected";
                                }
                                $output .= ">$i->duration.months [MYR $i->price]</option>";
                            } elseif(($i->category == 'platinum') ) {
                                $output .= "<optgroup label ='Platinum'>";
    
                                $output .= "<option value='$i->id'";
                                if ($i == $subscription_packages) {
                                    $output .= " selected";
                                }
                                $output .= ">$i->duration.months [MYR $i->price]</option>";
                            } else {
                            $output .= "<optgroup label ='Trial'>";
    
                                $output .= "<option value='$i->id'";
                                if ($i == $subscription_packages) {
                                    $output .= " selected";
                                }
                                $output .= ">$i->duration.months [MYR $i->price]</option>";    
                            }
                        }
                      
                    }
                    $output .= "</optgroup>";
                    $output .= "</select>";

                    echo($output);
                    ?>         
                </div>

                <br>
                <input type="submit" name="submit" value="Make Payment" class="btn btn-block btn-primary" />
            </form><br>

            </div>
            <!-- right side of search ends -->
            </div>
            <!-- main row ends -->

            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Refund and Cancellation Policy</h2>



                        <p>

                            <br />    
                            You may cancel a free trial anytime during the free trial period and incur no charge. For all initial purchases of subscriptions longer than one month, you may cancel during the first 10 days (calculated from the date of purchase plus the free trial period, if applicable) and receive a full refund. If the cancellation occurs after the first 10 days, you won’t be eligible for a refund. If you cancel your subscription but are not eligible for a refund, you’ll retain access to the subscription until it expires.
                            <br /><br />
                            For renewals of subscriptions longer than one month, cancel within seven days of the renewal date to receive a full refund. No refund is available for monthly subscriptions.
                            <br /><br />
                            To cancel your subscription, please complete the required fields in this form and include the following information in the description field:
                            <br /><br />
                            Username<br />
                            Email address used when subscribing
                            <br /><br />
                            For more information, contact us at naisse.hall@gmail.com
                        </p>
                    </div>
                </div>
            </div>


    </div>
    <!-- container ends -->
<!--<script src="http://code.jquery.com/jquery-latest.min.js"></script>-->
<script src="<?php echo Request::$BASE_URL; ?>js/intlTelInput.min.js"></script>

<script type="text/javascript">
	$("#demo").intlTelInput();

        $(function () {
            $('.profession_field').hide();
            $('#profession').change(function () {
                $('.profession_field').hide();
                $('#' + $(this).val()).show();
            });
        });

    </script>