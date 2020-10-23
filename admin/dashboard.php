<!DOCTYPE html>
<html lang="en">
<?php 
include('../config.php');
include('../helpers.php');
if(!auth_check())
{
  header('Location: ../index.php');
  exit();
}

  $sql = "select 
          COUNT(product) as p_total, 
          SUM(price_total) as t_price, 
          sum(qty_invoiced) as q_total, 
          SUM(qty_delivered) as t_delivered 
          from sales";
  $result = $conn->query($sql);
  $count = mysqli_fetch_row($result);


  $sql1 = "select * FROM sales ORDER BY id DESC LIMIT 10";
  $result_sales = $conn->query($sql1);


?>

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url() ?>/assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?php echo base_url() ?>/assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Odoo Sales | Dashboard
  </title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&subset=devanagari,latin-ext" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- CSS Files -->
  <link href="<?php echo base_url() ?>/assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

  <style type="text/css">
    body {
  background-color: #F4F7FD;
    font-family: 'Poppins', sans-serif;
  font-size: 16px;
  line-height: 24px;
  font-weight: 400;
  color: #212112;
  background-position: center;
  background-repeat: repeat;
  background-size: 7%;
  overflow-x: hidden;
    transition: all 200ms linear;
}
    .table thead th{
      border-top-width: 1px;
    }
    .bmd-form-group .bmd-label-floating, .bmd-form-group .bmd-label-placeholder{
      left: 10px;
    }
    .form-control{
      border: 2px solid #eee;
      border-radius: 8px;
      padding: 4px 10px;
    }
    input.form-control, textarea.form-control{
      background-image: none !important;
    }
    .form-group label{
      font-weight: bold;
      text-transform: capitalize;
      margin-bottom: 3px;
    }
    .card-title{
      font-weight: bold;
    }
    .navbar .navbar-brand{
      font-weight: bold;
    }
    .dataTables_filter{
      text-align: right;
    }
    .dataTables_paginate .pagination{
      justify-content: right;
    }
    .collapsein{
      margin-top: 20px;
      padding-left: 1.5rem;
      margin-bottom: 0;
      list-style: none;
    }
    select {
        background-image:
          linear-gradient(45deg, transparent 50%, gray 50%),
          linear-gradient(135deg, gray 50%, transparent 50%),
          linear-gradient(to right, #ccc, #ccc) !important;
        background-position:
          calc(100% - 20px) calc(1em + 2px),
          calc(100% - 15px) calc(1em + 2px),
          calc(100% - 2.5em) 0.5em !important;
        background-size:
          5px 5px,
          5px 5px,
          1px 1.5em !important;
        background-repeat: no-repeat !important;
      }

      select:focus {
        background-image:
          linear-gradient(45deg, green 50%, transparent 50%),
          linear-gradient(135deg, transparent 50%, green 50%),
          linear-gradient(to right, #ccc, #ccc) !important;
        background-position:
          calc(100% - 15px) 1em,
          calc(100% - 20px) 1em,
          calc(100% - 2.5em) 0.5em !important;
        background-size:
          5px 5px,
          5px 5px,
          1px 1.5em !important;
        background-repeat: no-repeat !important;
        outline: 0 !important;
      }
      select:-moz-focusring {
        color: transparent !important;
        text-shadow: 0 0 0 #000 !important;
      }
      .bootstrap-select > .dropdown-toggle,
      .bootstrap-select > .dropdown-toggle:hover,
      .bootstrap-select > .dropdown-toggle:active,
      .bootstrap-select > .dropdown-toggle:focus{
        padding: 7px 12px !important;
        margin: 0px !important;
        color: #0f0f0f;
        background: #fff;
        box-shadow: none;
        border: 2px solid #eee;
        border-radius: 8px;
      }
      .job-checks .form-check{
        padding-left: 18px;
        flex: 1;
      }
      .nav-tabs .nav-link.disabled{
        opacity: .6;
        cursor: not-allowed;
      }
      .bold{
        font-weight: bold !important;
      }
      .form-group .alert-danger{
        font-size: 12px;
        padding: 3px;
      }
      th{
        font-weight: bold !important;
        font-size: 15px !important;
      }
      .paging_simple_numbers{
        float: right;
      }
      #btnDateSearch{
        cursor: pointer;
      }
      .nav-link a{
        color: #000;
        font-size: 15px;
        font-weight: bold;
      }
      .text-site{
      font-weight: bold; color: #2196F3 !important;
    }
  </style>
</head>
<body class="">
  <div class="wrapper">
    <div class="main-panel ml-0 w-100">
      <nav class="navbar navbar-expand-lg navbar-default p-0 navbar-absolute fixed-top ">
        <div class="container-fluid">
            <div class="navbar-wrapper">
                <a class="navbar-brand" href="javascript:;" style="font-weight: bold; color: #2196F3;">
                    Odoo Sales Report
                </a>
            </div>
            <div class="nav-link text-right">
              <a href="index.php" class="nav-item p-2">Products List</a>
              <a href="pivot.php" class="nav-item p-2">Pivot Sales</a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                <span class="sr-only">Toggle navigation</span>
                <span class="navbar-toggler-icon icon-bar"></span>
                <span class="navbar-toggler-icon icon-bar"></span>
                <span class="navbar-toggler-icon icon-bar"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">person</i>
                            <p class="d-lg-none d-md-block">
                                Account
                            </p>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                            <a class="dropdown-item" href="<?php echo base_url('logout.php') ?>">Log out</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
      </nav>

      


      <div class="content mt-5">

        <div class="container">
          <div class="text-center">
            <h2 class="">Welcome to <strong>ODOO Sales</strong> Dashboard</h2><hr class="m-0" />
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6">
              <div class="card">
                  <div class="card-header text-center">
                    <span class="badge badge-info p-1" style="font-size: 40px;"><?php echo $count['0']; ?></span>
                  </div><hr class="m-0">
                  <div class="card-body text-center text-warning">
                    <h3 class="font-weight-bold"><i class="fab fa-product-hunt"></i> Total Products</h3>
                  </div>
              </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6">
              <div class="card">
                  <div class="card-header text-center">
                    <span class="badge badge-secondary p-1" style="font-size: 40px;"><?php echo round($count['2']); ?></span>
                  </div><hr class="m-0">
                  <div class="card-body text-center text-info">
                    <h3 class="font-weight-bold"><i class="fas fa-shopping-cart"></i> Sales Invoiced</h3>
                  </div>
              </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6">
              <div class="card">
                  <div class="card-header text-center">
                    <span class="badge badge-primary p-1" style="font-size: 40px;">$<?php echo round($count['1']); ?></span>
                  </div><hr class="m-0">
                  <div class="card-body text-center text-success">
                    <h3 class="font-weight-bold"><i class="fas fa-file-invoice-dollar"></i> Total Sales Price</h3>
                  </div>
              </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6">
              <div class="card">
                  <div class="card-header text-center">
                    <span class="badge badge-danger p-1" style="font-size: 40px;"><?php echo round($count['3']); ?></span>
                  </div><hr class="m-0">
                  <div class="card-body text-center text-danger">
                    <h3 class="font-weight-bold"><i class="fas fa-truck"></i> Sales Delivered</h3>
                  </div>
              </div>
            </div>

          </div>


          <div class="row">
            <div class="col-sm-12 card">
               <div class="card-header p-0 text-info">
                      <h3 class="mt-1 mb-0 p-0 text-site">Odoo latest Sales</h3><hr class="m-0" />
                    </div>
              <table class="table table-sm table-hover">
            <thead>
              <tr>
                <th scope="col">Product Name</th>
                <th scope="col">Qty. Invoiced</th>
                <th scope="col">Subtotal</th>
                <th scope="col">Qty Pending</th>
                <th scope="col">Qty. Delivered</th>
                <th scope="col">Total Price</th>
                <th scope="col">Date</th>
              </tr>
            </thead>
            <tbody>

              <?php

                  if ($result_sales->num_rows > 0) {
                    while($row = $result_sales->fetch_assoc()) {
                      echo "<tr>
                          <td>".$row["product"]."</td>
                          <td>".$row["qty_invoiced"]."</td>
                          <td>".$row["price_subtotal"]."</td>
                          <td>".$row["qty_to_invoice"]."</td>
                          <td>".$row["qty_delivered"]."</td>
                          <td>".$row["price_total"]."</td>
                          <td>".$row["date"]."</td>
                        </tr>";
                    }
                  } 

              ?>
                            
            </tbody>
          </table>

            </div>
          </div>



        
      </div>
    </div>
  </div>
<!--   Core JS Files   -->
<script src="<?php echo base_url() ?>/assets/js/core/jquery.min.js"></script>
<script src="<?php echo base_url() ?>/assets/js/core/popper.min.js"></script>
<script src="<?php echo base_url() ?>/assets/js/core/bootstrap-material-design.min.js"></script>
<script src="<?php echo base_url() ?>/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
<script src="<?php echo base_url() ?>/assets/js/plugins/moment.min.js"></script>
<script src="<?php echo base_url() ?>/assets/js/plugins/bootstrap-selectpicker.js"></script>
<script src="<?php echo base_url() ?>/assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo base_url() ?>/assets/js/plugins/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>/assets/js/material-dashboard.js?v=2.1.2" type="text/javascript"></script>
<script>
 $(document).ready(function() {
   $('.bmd-form-group').each(function(){
    $(this).find('label').removeClass('bmd-label-floating');
    $(this).removeClass('bmd-form-group');
   });
   $('.datatable').DataTable({
    ordering: false
   });
 });
</script>


</body>

</html>