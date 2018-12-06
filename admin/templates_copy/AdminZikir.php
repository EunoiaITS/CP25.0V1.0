
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
                <h1 class="page-header">Manage Zikir</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- Page Header -->

        <form action="<?php echo Request::$BASE_URL; ?>index.php/post" method="POST">
            <input type="hidden" name="table" value="zikir">
            <div class="row">
                <div class="col-md-6">
                    <label> Zikir
                        <textarea class="form-control" name="zikir" rows="5"></textarea>
                    </label>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <input type="submit" name="submit" class="btn btn-success btn-block" value="Add Zikir">
                </div>
            </div>
        </form>

        <br><br>
        <div class="row">
            <div class="col-md-12"><h3>Zikir List</h3></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form action="<?php echo Request::$BASE_URL; ?>index.php/post" method="POST">
                    <table class="table table-bordered table-striped ">
                        <tr>
                            <th>#</th>
                            <th>Zikir</th>

                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        <?php if(isset($zikir)){ $x=1; foreach ($zikir as $q): ?>
                        <tr <?php if(!$q->is_approved){ ?>class="danger"<?php } ?> data-id="<?php echo $q->id; ?>">
                            <td><?php echo $x; $x++; ?></td>
                            <td class="zikir"><?php echo $q->zikir; ?></td>

                            <td class="edit_button"><button type="button" onClick="return editZikir(this)" class="btn btn-success btn-block">Edit</button></td>
                </form>

                <?php if(!$q->is_approved && $_SESSION['user_permission']==1){ ?>
                    <form onSubmit="return confirm('Are you sure you want to approve this?')" method="POST" action="<?php echo Request::$BASE_URL; ?>index.php/post">
                        <input type="hidden" name="table" value="zikir" />
                        <input type="hidden" name="id" value="<?php echo $q->id; ?>" />
                        <input type="hidden" name="is_approved" value="1" />
                        <td>
                            <input type="submit" value="APPROVE" class="btn btn-block btn-success" />
                        </td>
                    </form>
                <?php } ?>
                <form onSubmit="return confirm('Are you sure you want to make this zikir of the day?')" method="POST" action="<?php echo Request::$BASE_URL; ?>index.php/zikir_of_the_day">
                    <input type="hidden" name="table" value="zikir" />
                    <input type="hidden" name="id" value="<?php echo $q->id; ?>" />
                    <input type="hidden" name="zikir_of_the_day" value="1" />
                    <td>
                        <input type="submit" value="Zikir" class="btn btn-block btn-success" />
                    </td>
                </form>
                </tr>
                <?php endforeach; } ?>
                </table>
            </div>
        </div>
        <?php Pagination::pagesBlock("zikir",30,Request::$BASE_URL."index.php/adminZikir"); ?>
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->