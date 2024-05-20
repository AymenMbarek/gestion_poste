<?php 
ob_start();
require_once '../library/lib.php';
require_once '../classes/crud.php';

$lib = new Lib;
$crud = new Crud;

$lib->check_login2();

if (isset($_POST['submit'])) {
    $crud->insertChat3($_POST);
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Gestion de Colis</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="../font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="../plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="../plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="../dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <link href="../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
</head>
<body class="skin-blue">
<div class="wrapper">

    <?php
    include 'header.php';
    include 'sidebar.php';
    ?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>Complain/Request</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Complain/Request</li>
            </ol>
        </section>

        <section class="content">
            <?php
            $user = $crud->displayUser3($_GET['id']);
            $qt = $crud->displayAllWithOr($user['id']);
            $qc = $crud->countAllById('chat', $user['id']);
            $c = 1;
            ?>
            <div class='row'>
                <div class='col-md-10 col-md-push-1'>
                    <div id="myDirectChat" class="box box-warning direct-chat direct-chat-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Direct Chat</h3>
                            <div class="box-tools pull-right">
                                <span data-toggle="tooltip" title=" <?php echo $qc; ?> New Messages" class='badge bg-yellow'><?php echo $qc; ?></span>
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>

                        <div class="box-body">
                            <div class="direct-chat-messages">
                                <?php
                                if (is_array($qt) || is_object($qt)) {
                                    foreach ($qt as $dy) {
                                        if ($dy['sender'] == 'admin') {
                                            ?>
                                            <div class="direct-chat-msg">
                                                <div class='direct-chat-info clearfix'>
                                                    <span class='direct-chat-name pull-left'> Admin </span>
                                                    <span class='direct-chat-timestamp pull-right'><?php echo $dy['date_created']; ?>|<a href="del-c.php?id=<?php echo $dy['id']; ?>" onClick="return confirm('Are you sure you want to delete this record?')"><i class="fa fa-trash"></i></a></span>
                                                </div>
                                                <img class="direct-chat-img" src="../dist/img/user1-128x128.jpg" alt="message user image" />
                                                <div class="direct-chat-text">
                                                    <?php echo $dy['message']; ?>
                                                </div>
                                            </div>
                                            <?php
                                        } else {
                                            $user = $crud->displayUser3($_GET['id']);
                                            ?>
                                            <div class="direct-chat-msg right">
                                                <div class='direct-chat-info clearfix'>
                                                    <span class='direct-chat-name pull-right'><?php echo $user['fullname']; ?></span>
                                                    <span class='direct-chat-timestamp pull-left'><?php echo $dy['date_created']; ?>|<a href="del-c.php?id=<?php echo $dy['id']; ?>" onClick="return confirm('Are you sure you want to delete this record?')"><i class="fa fa-trash"></i></a></span>
                                                </div>
                                                <?php
                                                if ($user['gender'] == 'male') {
                                                    ?>
                                                    <img class="direct-chat-img" src="../dist/img/avatar5.png" alt="message user image" />
                                                    <?php
                                                } else {
                                                    ?>
                                                    <img class="direct-chat-img" src="../dist/img/avatar2.png" alt="message user image" />
                                                    <?php
                                                }
                                                ?>
                                                <div class="direct-chat-text">
                                                    <?php echo $dy['message']; ?>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                } else {
                                    echo "<center>No Chat at the moment</center>";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="box-footer">
                            <form action="reply.php" method="post">
                                <div class="input-group">
                                    <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                                    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                                    <span class="input-group-btn">
                                        <button type="submit" name="submit" class="btn btn-warning btn-flat">Send</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php include 'footer.php'; ?>
</div>

</body>
</html>
