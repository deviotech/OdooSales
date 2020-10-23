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
    Product List | Odoo Sales | Dashboard
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

</head>
<body class="">
  <div class="wrapper">
    <div class="main-panel ml-0 w-100">
      <nav class="navbar navbar-expand-lg navbar-default p-0 navbar-absolute fixed-top ">
        <div class="container-fluid">
            <div class="navbar-wrapper">
                <a class="navbar-brand text-site" href="dashboard.php">
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
                    <li class="nav-item">
                        <a class="btn btn-success text-white btn-sm" id="updateData">Update Sales Data</a>
                    </li>
                </ul>
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
          
          <div class="row ">
            <div class="col-md-12 card">
                    <div class="card-header p-0 text-info">
                      <h3 class="mt-1 mb-0 p-0 text-site">Odoo Sales Product List</h3><hr class="m-0" />
                    </div>
                    <div class="row mt-2">

                      <div class="col-sm-5">
                        
                        <small>From Date</small>
                        <input type="text" id="dateFrom" class="form-control date" placeholder="01/01/2001">
                      </div>
                      <div class="col-sm-5">
                        
                        <small>To Date</small>
                        <input type="text" id="dateTo" class="form-control date" placeholder="01/01/2020">
                      </div>
                      <div class="col-sm-2">
                        
                        <small>Filter by Year</small>
                        <select class="form-control" id="year">
                          <option hidden="" selected="" value="n/a">Choose year</option>
                          <option value="2020">2020</option>
                          <option value="2019">2019</option>
                          <option value="2018">2018</option>
                          <option value="2017">2017</option>
                          <option value="2016">2016</option>
                          <option value="2015">2015</option>
                          <option value="2014">2014</option>
                          <option value="2013">2013</option>
                          <option value="2012">2012</option>
                        </select>
                      </div>
                      <div class="col-sm-5">
                        <small>Product Name</small>
                        <input type="text" id="product" placeholder="Product Name" class="form-control">
                      </div>
                      <div class="col-sm-5">
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
                <table  id='empTable' class='table display table-hover dataTable'>
                  <thead>
                    <tr>
                      <th>Product</th>
                      <th>Qty Invoiced</th>
                      <th>Sub. Total Price</th>
                      <th>Qty Invoice</th>
                      <th>Qty Delivered</th>
                      <th>Price Total</th>
                      <th>Date</th>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
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
                    'url':'ajaxfile.php',
                    'data': function(data){
                        // Read values
                        var product = $('#product').val();
                        var price = $('#price').val();
                        var to = $('#dateTo').val();
                        var from = $('#dateFrom').val();
                        var year = $('#year').val();

                        // Append to data
                        data.searchByProduct = product;
                        data.searchByPrice = price;
                        data.searchByFrom = from;
                        data.searchByTo = to;
                        data.searchByYear = year;
                    }
                },
                'columns': [
                    { data: 'product' },
                    { data: 'qty_invoiced' },
                    { data: 'price_subtotal' },
                    { data: 'qty_to_invoice' },
                    { data: 'qty_delivered' },
                    { data: 'price_total' },
                    { data: 'date' }
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


        <!-- update data call to ajax cron -->
        <script>
          $("#updateData").on("click", function(){
            $(this).text('Updating...');
              $.ajax({
              type: "GET",
              url: "croncall.php",
              success:function(response)
              {
                console.log(response);
                $('#updateData').text('Update Sales Data');
              }
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