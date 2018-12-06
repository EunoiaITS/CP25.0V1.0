<nav class="navbar">
    <button type="button" style="background-color:#ccc;"  data-target="#bs-example-navbar-collapse-1" data-toggle="collapse" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span style="background-color:#fff;" class="icon-bar"></span>
                <span style="background-color:#fff;" class="icon-bar"></span>
                <span style="background-color:#fff;" class="icon-bar"></span>
            </button>
  <div class="container-fluid">
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<ul class="nav navbar-nav navbar-right">
	        <li><a href="<?php echo Request::$BASE_URL; ?>index.php/company">Company Registration</a></li>
	        <li><a href="<?php echo Request::$BASE_URL; ?>index.php/refund_policy">Refund / Cancellation Policy</a></li>
	        <li><a href="<?php echo Request::$BASE_URL; ?>index.php/about">About Us</a></li>
	        <li><a href="<?php echo Request::$BASE_URL; ?>index.php/permission">Permission</a></li>
<!--	        <li><a href="--><?php //echo Request::$BASE_URL; ?><!--index.php/guide">Guide</a></li>-->
            <li><a href="<?php echo Request::$BASE_URL; ?>index.php/team">Our Team</a></li>
            <li><a href="<?php echo Request::$BASE_URL; ?>index.php/privacy_policy">Privacy Policy</a></li>
            <li><a href="<?php echo Request::$BASE_URL; ?>index.php/forum">Forum</a></li>
            <li><a href="<?php echo Request::$BASE_URL; ?>index.php/event">Events</a></li>
	        <?php if(isset($_SESSION['public_user_id']) && $_SESSION['public_user_id']>0){ ?>
	        	<li><a href="<?php echo Request::$BASE_URL ?>index.php/logout">Logout</a></li>
	        <?php }else{ ?>
	        	<li><a href="<?php echo Request::$BASE_URL ?>index.php/login">Register/Sign In</a></li>
	        <?php } ?>
	        <!-- <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
	          <ul class="dropdown-menu">
	            <li><a href="#">Action</a></li>
	            <li><a href="#">Another action</a></li>
	            <li><a href="#">Something else here</a></li>
	            <li role="separator" class="divider"></li>
	            <li><a href="#">Separated link</a></li>
	          </ul>
	        </li> -->
      	</ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>



<div class="container-fluid">
	<div class="row">
		<div class="col-md-6 top10 col-md-offset-3">

			<img  src="<?php echo Request::$BASE_URL; ?>images/logo.png" width="100%" />

		</div>
		<!-- Col Md 8 -->
	</div>
	<!-- Row -->



	<div class="row">
		<form action="<?php echo Request::$BASE_URL ?>index.php/results" method="GET">
		<div class="col-md-6 col-md-offset-1">
			<input type="text" class="form-control typeahead" style="width:100%" placeholder="Search for Prophetic Food or Disease" name="search" />
		</div>
		<!-- Col Md 6 -->

		<div class="col-md-2">
			<input type="submit" value="Search" class="btn btn-block btn-danger" style="background-color:#b08609; border-color:#916f10;" />
		</div>
		<!-- Col Md 2 -->
		</form>

		<div class="col-md-2">
			<button type="button" onClick="return showCanvas()" class="btn btn-block btn-primary" style="background-color:#3b8087; border-color:#286a70;">Get Started</button>
		</div>
	</div>
	<!-- Row -->

	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div id="myCanvasContainer">
			 <canvas width="600" height="400" id="myCanvas">
			  <p>Anything in here will be replaced on browsers that support the canvas element</p>
			  <ul>
			   <?php if(isset($keywords) && count($keywords)>0){ foreach($keywords as $keyword){ ?>
                              
			   	<li><a href="<?php echo Request::$BASE_URL; ?>index.php/results?search=<?php echo $keyword->keyword; ?>"><?php echo $keyword->keyword; ?></a></li>
			   <?php }} ?>
			  </ul>
			 </canvas>
			</div>

		</div>
	</div>




    <br><br>
    
    
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div id="myCarousel" class=" col-md-7 carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <?php if(isset($advertisement)){
                        foreach ($advertisement as $ad){ ?>
                            <li data-target="#myCarousel" data-slide-to="<?php echo $ad->position  ?>" class="active"></li>
                        <?php    }
                    } ?>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <?php
                    $first = true;
                    ?>
                    <?php if(isset($advertisement)){
                        foreach ($advertisement as $ad){ ?>
                            <div class="item <?php echo ($first == true ? "active" : "") ?>">
                                <?php
                                $first = false;
                                if (isset($ad->link)&& !empty($ad->link)){ ?>
                                <a href="<?php echo $ad->link;?>" > <img  src="<?php echo $ad->path;?>" alt="Naisse.org"></a>
   
                               <?php }else{ ?>
                                 <img  src="<?php echo $ad->path;?>" alt="Naisse.org">  
                              <?php } ?>
                            </div>

                        <?php    }
                    } ?>

                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
    
    
    
    <br><br><br>






</div>
<!-- container fluid ends -->



<nav class="navbar navbar-fixed-bottom">
  <div class="container-fluid">
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<ul class="nav navbar-nav navbar-right">
	        <li><a href="<?php echo Request::$BASE_URL; ?>index.php/contact">Contact Us</a></li>
      	</ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>