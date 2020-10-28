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
      
    $sql2 = "select MAX(price_total) AS MaxPrice FROM sales";
    $result2 = $conn->query($sql2);
    $min_count = mysqli_fetch_row($result2);

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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link href="<?php echo base_url() ?>/assets/css/custom.css" rel="stylesheet" />
  <style>
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
              <a href="index.php" class="nav-item p-2">Sales List</a>
              <a href="pivot.php" class="nav-item p-2">Pivot</a>
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

      


      <div class="content mt-3">

        <div class="container">
          <div class="row">
            <div class="col-md-12 card">
              <div class="card-header p-0 text-info">
                      <h3 class="mt-1 mb-0 p-0 text-site">Odoo Sales Pivot Sales</h3><hr class="m-0" />
                    </div>
                    <div class="row mt-2">

                      <div class="col-sm-6">
                        
                        <small>From Date</small>
                        <input type="text" id="dateFrom" class="form-control date" placeholder="01/01/2001">
                      </div>
                      <div class="col-sm-6">
                        
                        <small>To Date</small>
                        <input type="text" id="dateTo" class="form-control date" placeholder="01/01/2020">
                      </div>
                      <div class="col-sm-6">
                        <small>Product Name</small>
                        <input type="text" id="product" placeholder="Product Name" class="form-control">
                      </div>
                      <div class="col-sm-4">
                        <small>Price Range</small>
                          <div class="price-range-slider pl-2 pr-2 mt-2">
                          <div id="slider-range" class="range-bar"></div>
                          <p class="range-value text-center pl-5  pt-0 pb-0 font-weight-bold">
                            <input type="text" id="price" readonly style="border: 0;">
                          </p>
                        </div>
                      </div>

                      
                      <div class="col-sm-2 mt-4">
                        <button type="button" id="btnDateSearch" class=" btn-primary btn-sm btn-block">Filter Sales</button>
                      </div>
                    </div>
                    <hr class="p-0 mb-0" />
                      
              <div class="table-responsive card-body">
                <table  id='empTable' class='table display table-hover table-bordered dataTable'>
                  <thead>
                    <tr>
                      <th>Product</th>
                      <th>Total Count</th>
                      <th>Sub Total</th>
                      <th>Total Price</th>
                      <th>Invoiced Avg</th>
                      <th>To Invoice Avg</th>
                      <th>Delivered Avg</th>
                      <th>Total Avg</th>
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
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
    $( function() {
    $( ".date" ).datepicker();
  } );
</script>
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
                    { data: 'qty_invoiced_avg' },
                    { data: 'qty_to_invoice_avg' },
                    { data: 'qty_delivered' },
                    { data: 'average' },
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
                <script>
        $(function() {
          $( "#slider-range" ).slider({
            range: true,
            min: 0,
            max: <?php echo round($min_count['0']); ?>,
            values: [ 0, <?php echo round($min_count['0']); ?> ],
            slide: function( event, ui ) {
            $( "#price" ).val(  ui.values[ 0 ] + " - " + ui.values[ 1 ] );
            }
          });
          $( "#price" ).val( $( "#slider-range" ).slider( "values", 0 ) +
            " - " + $( "#slider-range" ).slider( "values", 1 ) );
        });
        </script>
</body>

</html>