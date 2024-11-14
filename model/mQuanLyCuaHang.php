<?php
    require_once __DIR__ . '/../config.php';

//insert, update , delete -> su dung function
function execute($sql) {
    $conn = mysqli_connect(HOST,USERNAME,PASSWORD,DATABASE);

    //querry
    mysqli_query($conn, $sql);

    //dong connect
    mysqli_close($conn);
}
// su dung cho lech select va tra ve ket qua
function executeResult($sql) {
    $conn = mysqli_connect(HOST,USERNAME,PASSWORD,DATABASE);

    $resultset = mysqli_query($conn , $sql);
    $list = [];
    while ($row = mysqli_fetch_array($resultset, 1)) { 
        $list[] = $row ;
    }

    mysqli_close($conn);
    return $list;
}
