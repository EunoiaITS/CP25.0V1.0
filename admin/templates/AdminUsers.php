<?php if($_SESSION["user_permission"] == "2"){ header("Location: ".Request::$BASE_URL); }?>
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
                    <h1 class="page-header">Manage Users</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- Page Header -->

            <form action="<?php echo Request::$BASE_URL; ?>index.php/post" method="POST">
                <input type="hidden" name="table" value="user">
            <div class="row">
                <div class="col-md-6">
                    <label> Name
                    <input type="text" required name="name" class="form-control" placeholder="Name">
                    </label>

                    <label> Email
                    <input type="email" required name="email" class="form-control" placeholder="Email">
                    </label>

                    <label> Username
                    <input type="text" required name="username" class="form-control" placeholder="Username">
                    </label>

                </div>

                <div class="col-md-6">

                    <label> Permission
                    <select required name="type" class="form-control">
                        <option value="">--</option>
                        <option value="1">Super Admin</option>
                        <option value="2">Content Manager</option>
                    </select>
                    </label>

                    <label> Password
                    <input type="password" required name="password" class="form-control" placeholder="Password">
                    </label>

                    <label> Repeat Password
                    <input type="password" required name="password2" class="form-control" placeholder="Repeat Password">
                    </label>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <input type="submit" name="submit" class="btn btn-success btn-block" value="Create User">
                </div>
            </div>
            </form>
            
            <br><br>
            <div class="row">
                <div class="col-md-12"><h3>Users List</h3></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped ">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Permission</th>
                            <th></th>
                        </tr>
                       <?php if($users){ $x=1; foreach ($users as $user): ?>
                       <tr>
                            <td><?php echo $x; $x++; ?></td>
                            <td><?php echo $user->name; ?></td>
                            <td><?php echo $user->username; ?></td>
                            <td><?php echo $user->email; ?></td>
                            <td>
                                <?php 
                                switch($user->type){

                                    case 1:
                                        echo "Super Admin";
                                    break;

                                    case 2:
                                        echo "Content Manager";
                                    break;

                                }
                                 ?>
                            </td>
                            <td>
                                <?php if ($user->type!=1): ?>
                                <form action="<?php echo Request::$BASE_URL; ?>index.php/post" onsubmit="return confirm('Are you sure you want to delete this user?')" method="POST">
                                    <input type="hidden" name="table" value="user" />
                                    <input type="hidden" name="id" value="<?php echo $user->id; ?>">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="submit" name="submit" value="Delete User" class="btn btn-danger btn-block">
                                </form>
                                <?php endif ?>
                            </td>
                       </tr>    
                       <?php endforeach; } ?>
                    </table>
                </div>
            </div>

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->