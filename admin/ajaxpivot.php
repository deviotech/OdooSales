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
    $numbers = explode('-', $searchByPrice);
    $searchQuery .= " and (price_total between '".$numbers[0]."' AND '".$numbers[1]."') ";
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
// $sel = mysqli_query($conn,"select count(*) as allcount,  from sales WHERE 1 ".$searchQuery);
// $records = mysqli_fetch_assoc($sel);
// $totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "select *,COUNT(*) AS count , 
             SUM(price_total) as total, 
             AVG(qty_invoiced) as qty_invoiced_avg, 
             AVG(qty_delivered) as qty_delivered, 
             AVG(qty_to_invoice) as qty_to_invoice_avg, 
             AVG(price_total) as average, 
             Sum(price_subtotal) as subtotal 
             FROM Sales 
             where 1 ".$searchQuery." 
             group by product 
             limit ".$row.",".$rowperpage;

$empRecords = mysqli_query($conn, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
    		"product"=>$row['product'],
            "count"=>$row['count'],
            "total"=>round($row['total']),
            "subtotal"=>round($row['subtotal']),
            "qty_invoiced_avg"=>round($row['qty_invoiced_avg']),
            "qty_delivered"=>round($row['qty_delivered']),
            "qty_to_invoice_avg"=>round($row['qty_to_invoice_avg']),
            "average"=>round($row['average'])
    	);
}

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "aaData" => $data
);

echo json_encode($response);
