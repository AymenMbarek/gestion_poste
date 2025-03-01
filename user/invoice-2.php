            <?php 
            ob_start();
            require_once '../library/lib.php';
            require_once '../classes/crud.php';

            $lib=new Lib;
            $crud=new Crud;

            $lib->check_login2();

            $parcel=$crud->displayOne('parcel',$_GET['id']);

            ?>      

            <!DOCTYPE html>
            <html>
            <head>
              <meta charset="UTF-8">
              <title>Parcel Tracking System | Dashboard</title>
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
              <!-- DATA TABLES -->
              <link href="../plugins/style.css" rel="stylesheet" type="text/css" />

              <!-- Daterange picker -->
              <link href="../plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
              <!-- Theme style -->
              <link href="../dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
     folder instead of downloading all of them to reduce the load. -->
     <link href="../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />

     <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
     <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
      <![endif]-->
    </head>
    <body onload="window.print();">
      <div class="wrapper">
        <!-- Main content -->
        <section class="invoice">
          <!-- title row -->
          <div class="row">
              <div class="col-xs-12">
                <h2 class="page-header">
                  <i class="fa fa-globe"></i> Parcel Tracking System.
                  <small class="pull-right"><?=$parcel['date_created']?></small>
                </h2>
              </div><!-- /.col -->
            </div>
          <!-- info row -->
         
                      <!-- Table row -->
            <div class="row">
              <div class="col-xs-12 table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Qty</th>
                      <th>Type</th>
                      <th>Payment Status</th>
                      <th>Delivery Status</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><?=$parcel['qty']?></td>
                      <td><?=$parcel['type']?></td>
                      <td><?php
                             if ($parcel['payment_status'] == '0') {
                              echo "Not Paid";
                            } else {
                             echo "Paid";
                           }

                           ?>
                         </td>
                      <td><?php
                           if ($parcel['delivery_status'] == '0') {
                            echo "Not Delivered";
                          } else {
                           echo "Delivered";
                         }

                         ?></td>
                      <td><?php echo $lib->money('naira',$parcel['charge']); ?></td>
                    </tr>
                    
                  </tbody>
                </table>
              </div><!-- /.col -->
            </div><!-- /.row -->


        </section><!-- /.content -->
      </div><!-- ./wrapper -->
      <!-- AdminLTE App -->

<!-- <script type="text/javascript">
  window.location="view-p.php";
</script> -->
      <?php
      include 'footer.php';
      ?>
    </body>
    </html>