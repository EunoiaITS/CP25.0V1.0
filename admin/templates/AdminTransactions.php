
<body>
<style type="text/css">
    label{
        width:100%;
    }
</style>
    <div id="wrapper">

        <?php include_once("AdminNav.php"); ?>

        <div id="page-wrapper">
            <!-- Page Header -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">User Transactions</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- Page Header -->

            
            
            <br><br>
            <div class="row">
                <div class="col-md-12"><h3>Transactions</h3></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo Request::$BASE_URL; ?>index.php/post" method="POST">
                    <table class="table table-bordered table-striped ">
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Transaction</th>
                            <th>Package</th>
                        </tr>
                       <?php if($transactions){ $x=1; foreach ($transactions as $q): ?>
                       <tr >
                            <td><?php echo $q->id; ?></td>
                            <td><?php echo $q->user->username; ?></td>
                            <td><?php if($q->typ==1){echo "Package";}elseif($q->typ==2){echo "Donation";}; ?></td>
                            <td><?php if($q->active){echo "Active";}else{echo "INACTIVE";}; ?></td>
                            <td><?php if($q->payment!=""){ ?>
                            <li>Amount: <?php echo $q->payment->Amount; ?></li>
                            <li>Status: <?php if($q->payment->Status){echo "Recieved";}else{echo "FAILED";}; ?></li>
                            <li>Name: <?php echo $q->payment->CCName; ?></li>
                            <li>Payment ID: <?php echo $q->payment->PaymentId; ?></li>
                            <li>Transaction ID: <?php echo $q->payment->TransId; ?></li>
                            <li>Bank: <?php echo $q->payment->S_bankname; ?></li>
                            <li>BankMID: <?php echo $q->payment->BankMID; ?></li>
                            <li>Date: <?php echo $q->payment->TranDate; ?></li>
                            <?php }?>
                            </td>
                            <td><?php if($q->package!=""){ ?><?php echo $q->package->category; ?> - <?php echo $q->package->duration; ?> Months<?php }?></td>
                       </tr>    
                       <?php endforeach; } ?>
                    </table>
                    </form>
                </div>
            </div>
            <?php Pagination::pagesBlock("user_wallet_transaction",30,Request::$BASE_URL."index.php/adminTransactions"); ?>
        </div>
        <!-- /#page-wrapper -->

        <!-- Modal --
        <div class="modal fade" id="addSyn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Synonym</h4>
              </div>
              <form action="<?php echo Request::$BASE_URL ?>index.php/addSynonym" method="POST">
              <div class="modal-body">
                <input type="hidden" name="table" value="keyword_index" />
                <input type="hidden" name="linked_to" id="linked_to" value="" />
                <input type="text" name="keyword" class="form-control" placeholder="Synonym">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add</button>
              </div>
              </form>
            </div>
          </div>
        </div>-->

    </div>
    <!-- /#wrapper -->