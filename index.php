<!DOCTYPE html>
<html lang="en">
<?php include('config.php'); ?>
<?php include('helpers.php'); ?>
<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url() ?>/assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?php echo base_url() ?>/assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Odoo Sales | Admin | Login
  </title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- CSS Files -->
  <link href="<?php echo base_url() ?>/assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
  <style type="text/css">
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
  </style>
</head>
<body class="">
  <div class="wrapper">
    <div class="main-panel ml-0 w-100">
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
              <h3 class="bold text-center mb-5">Odoo Sales Report</h3>
              <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Enter your Login Details</h4>
                </div>
                <div class="card-body">
                  <form method="post" action="login.php">
                    <?php if(session('error')): ?>
                    <div class="alert alert-danger">
                      <?php echo session('error'); ?>
                    </div>
                    <?php endif; ?>
                    <div class="form-group">
                      <label>Enter Email</label>
                      <input type="email" name="email" class="form-control" required="">
                    </div>
                    <div class="form-group">
                      <label>Enter Password</label>
                      <input type="password" name="password" class="form-control" required="">
                    </div>
                    <button class="btn btn-primary btn-block bold">Sign In</button>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-4"></div>
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
<script src="<?php echo base_url() ?>/assets/js/material-dashboard.js?v=2.1.2" type="text/javascript"></script>
<script>
 $(document).ready(function() {
   $('.bmd-form-group').each(function(){
    $(this).find('label').removeClass('bmd-label-floating');
    $(this).removeClass('bmd-form-group');
   });
 });
</script>
<?php session(['error' => '']); ?>
</body>

</html>