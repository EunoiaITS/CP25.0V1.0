<?php 
/**INFORMATION**\
Created: 22-07-2015 04:40:00
Author: M.Wasiq Ghaznavi

Last Modified: 22-27-2015 04:40:00
Modified By: M.Wasiq Ghaznavi
/**INFORMATION**/
?>
<body>

    <div id="wrapper">

        <?php include_once("AdminNav.php"); ?>

        <div id="page-wrapper">
            <!-- Page Header -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>

                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $queries; ?></div>
                                    <div>Queries!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $keywords; ?></div>
                                    <div>Keywords!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $users; ?></div>
                                    <div>Users!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-support fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $pfs; ?></div>
                                    <div>Prophetic Foods!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Page Header -->

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Latest User Queries</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-hover table-bordered table-striped table-responsive">
                        <tr>
                            <th>#</th>
                            <th>Query</th>
                            <th>IP Address</th>
                            <th>User</th>
                        </tr>
                        <?php if(count($queries_log)>0){ $x=0; foreach($queries_log as $q){ $x++; ?>
                        <tr>
                            <td><?php echo $x; ?></td>
                            <td><?php echo $q->query; ?></td>
                            <td><?php echo $q->ip_address; ?></td>
                            <td><?php echo $q->user_id; ?></td>
                        </tr>
                        <?php }} ?>
                    </table>
                </div>
            </div>

            <hr />
            <?php Pagination::pagesBlock("query_log",50,Request::$BASE_URL."index.php/adminHome"); ?>

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->