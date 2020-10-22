<?php
include '../config.php';

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

## Custom Field value
// $searchByName = $_POST['searchByName'];
$searchByFrom    = $_POST['searchByFrom'];
$searchByTo      = $_POST['searchByTo'];
$searchByProduct = $_POST['searchByProduct'];
$searchByPrice   = $_POST['searchByPrice'];

## Search 
$searchQuery = " ";
if($searchByProduct != ''){
    $searchQuery .= " and (product like '%".$searchByProduct."%' ) ";
}
if($searchByPrice != ''){
    $searchQuery .= " and (price_total >='".$searchByPrice."') ";
}
if($searchByFrom != ''){

    $dateFrom=date_create($searchByFrom);
    $date_time_from = date_format($dateFrom,"d/m/y H:i:s");

    $dateTo=date_create($searchByTo);
    $date_time_to = date_format($dateTo,"d/m/y H:i:s");

    $searchQuery .= " and (date between '".$date_time_from."' AND '".$date_time_to."' ) ";
}

## Total number of records without filtering
$sel = mysqli_query($conn,"select count(*) as allcount from sales");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($conn,"select count(*) as allcount from sales WHERE 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "select * from sales WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($conn, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
    		"product"=>$row['product'],
            "qty_invoiced"=>$row['qty_invoiced'],
            "price_subtotal"=>$row['price_subtotal'],
            "qty_to_invoice"=>$row['qty_to_invoice'],
            "qty_delivered"=>$row['qty_delivered'],
            "price_total"=>$row['price_total'],
    		"date"=>$row['date']
    	);
}

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
);

echo json_encode($response);
