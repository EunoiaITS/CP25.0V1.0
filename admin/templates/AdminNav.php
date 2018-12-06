<!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">LOGO</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?php echo Request::$BASE_URL; ?>index.php/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="<?php echo Request::$BASE_URL; ?>index.php/adminHome"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                       <!--  <li>
                            <a href="tables.html"><i class="fa fa-table fa-fw"></i> Results</a>
                        </li>
                        <li>
                            <a href="tables.html"><i class="fa fa-flag fa-fw"></i> Story Board</a>
                        </li> -->
                        <?php if($_SESSION["user_permission"] == "1"){ ?>
                        <li>
                            <a href="<?php echo Request::$BASE_URL; ?>index.php/adminUsers">
                                <i class="fa fa-user fa-fw"></i> Manage Users</a>
                        </li>

                        <li>
                            <a <?php if(isset($approval_no) && $approval_no>0){echo 'style="color:red;"';} ?> href="<?php echo Request::$BASE_URL; ?>index.php/adminApproval">
                                <i class="fa fa-check fa-fw"></i> Approvals <?php if(isset($approval_no) && $approval_no>0){echo "(".$approval_no.")";} ?></a>
                        </li>
                        <li>
                            <a href="<?php echo Request::$BASE_URL; ?>index.php/adminTransactions">
                                <i class="fa fa-edit fa-fw"></i> Payment Transactions</a>
                        </li>
                        <?php } ?>

                        <li>
                            <a href="<?php echo Request::$BASE_URL; ?>index.php/adminPropheticFood">
                                <i class="fa fa-edit fa-fw"></i> Prophetic Food</a>
                        </li>
                        <li>
                            <a href="<?php echo Request::$BASE_URL; ?>index.php/adminQuran">
                                <i class="fa fa-edit fa-fw"></i> Quran</a>
                        </li>
                        <li>
                            <a href="<?php echo Request::$BASE_URL; ?>index.php/adminHadith">
                                <i class="fa fa-edit fa-fw"></i> Hadith</a>
                        </li>
                        <li>
                            <a href="<?php echo Request::$BASE_URL; ?>index.php/adminZikir">
                                <i class="fa fa-edit fa-fw"></i> Zikir</a>
                        </li>
                        <li>
                            <a href="<?php echo Request::$BASE_URL; ?>index.php/adminManuscript">
                                <i class="fa fa-edit fa-fw"></i> Manuscript</a>
                        </li>
                        <li>
                            <a href="<?php echo Request::$BASE_URL; ?>index.php/adminArticle">
                                <i class="fa fa-edit fa-fw"></i> Scientific Articles</a>
                        </li>
                        <li>
                            <a href="<?php echo Request::$BASE_URL; ?>index.php/adminKeywords">
                                <i class="fa fa-edit fa-fw"></i> Keywords</a>
                        </li>
                        <li>
                            <a href="<?php echo Request::$BASE_URL; ?>index.php/adminForum">
                                <i class="fa fa-edit fa-fw"></i> Forum</a>
                        </li>
                        <li>
                            <a href="<?php echo Request::$BASE_URL; ?>index.php/adminEvents">
                                <i class="fa fa-edit fa-fw"></i> Events</a>
                        </li>
                        <li>
                            <a href="<?php echo Request::$BASE_URL; ?>index.php/adminAdvertisements">
                                <i class="fa fa-edit fa-fw"></i> Advertisements</a>
                        </li>
                        
<!--                        <li>-->
<!--                            <a href="#"><i class="fa fa-edit fa-fw"></i>Forum<span class="fa arrow"></span></a>-->
<!--                            <ul class="nav nav-second-level">-->
<!--                                <li>-->
<!--                                    <a href="--><?php //echo Request::$BASE_URL; ?><!--index.php/adminCreateTopic">Add Topic</a>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="--><?php //echo Request::$BASE_URL; ?><!--index.php/adminReadTopic">Read Topic</a>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="--><?php //echo Request::$BASE_URL; ?><!--index.php/adminUpdateTopic">Update Topic</a>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="--><?php //echo Request::$BASE_URL; ?><!--index.php/adminDeleteTopic">Delete Topic</a>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </li>-->
                            <!-- /.nav-second-level --
                        </li>

                       <!--  <li>
                            <a href="#"><i class="fa fa-edit fa-fw"></i> Manage Surveys<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo Request::$BASE_URL; ?>index.php/adminCreateSurvey">Create Survey</a>
                                </li>
                                <li>
                                    <a href="#">Edit Survey</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level --
                        </li> -->
                       
                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>