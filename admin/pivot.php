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



  $sql = "SELECT * FROM sales";
  $result = $conn->query($sql);
  
?>

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url() ?>/assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?php echo base_url() ?>/assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Sale Group | Odoo Sales | Dashboard
  </title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
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
      padding: 8px 20px;
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
      .dataTables_info{display: none;}
  </style>
</head>
<body class="">
  <div class="wrapper">
    <div class="main-panel ml-0 w-100">
      <nav class="navbar navbar-expand-lg navbar-default p-0 navbar-absolute fixed-top ">
        <div class="container-fluid">
            <div class="navbar-wrapper">
                <a class="navbar-brand" href="dashboard.php" style="font-weight: bold; color: #2196F3;">
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
          <div class="row">
            <div class="col-md-12 card">
                    <div class="row mt-2">

                      <div class="col-sm-6">
                        
                        <small>From Date</small>
                        <input type="date" id="dateFrom" class="form-control">
                      </div>
                      <div class="col-sm-6">
                        
                        <small>To Date</small>
                        <input type="date" id="dateTo" class="form-control">
                      </div>
                      <div class="col-sm-6">
                        <small>Product Name</small>
                        <input type="text" id="product" placeholder="Product Name" class="form-control">
                      </div>
                      <div class="col-sm-4">
                        <small>Price</small>
                        <input type="number" min="0" id="price" placeholder="Price" class="form-control">
                      </div>

                      
                      <div class="col-sm-2 mt-4">
                        <button type="button" id="btnDateSearch" class=" btn-primary btn-sm btn-block">Filter Sales</button>
                      </div>
                    </div>
                    <hr class="p-0 mb-0" />
                      
              <div class="table-responsive card-body">
                <table  id='empTable' class='table display table-hover dataTable'>
                  <thead>
                    <tr>
                      <th>Product</th>
                      <th>Total Count</th>
                      <th>Sub Total</th>
                      <th>Total Price</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
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


<script>
        $(document).ready(function(){
            var dataTable = $('#empTable').DataTable({
                'processing': true,
                'serverSide': true,
                "lengthChange": false,
                'serverMethod': 'post',
                'searching': false, // Remove default Search Control
                'ajax': {
                    'url':'ajaxpivot.php',
                    'data': function(data){
                        // Read values
                        var product = $('#product').val();
                        var price = $('#price').val();
                        var to = $('#dateTo').val();
                        var from = $('#dateFrom').val();

                        // Append to data
                        data.searchByProduct = product;
                        data.searchByPrice = price;
                        data.searchByFrom = from;
                        data.searchByTo = to;
                    }
                },
                'columns': [
                    { data: 'product' },
                    { data: 'count' },
                    { data: 'subtotal' },
                    { data: 'total' },
                ]
            });

            $('#searchByName').keyup(function(){
                dataTable.draw();
            });

            $('#btnDateSearch').click(function(){
              $(this).html('Filtering...');
                dataTable.draw();
                $(this).html('Filter Data');

            });
        });
        </script>
</body>

</html>