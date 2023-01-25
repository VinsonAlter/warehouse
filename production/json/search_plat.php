<?php
    require_once '../../function.php';
    $res = [];
    $query = "SELECT [NoPlat] FROM [WMS-System].[dbo].[TB_Mobil] WHERE Aktif = 1";
    $stmt = $conn->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
    $stmt->execute();
    if($stmt->rowCount() > 0) {
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
           $rows[] = $row['NoPlat'];
        }
        $res['success'] = 1;
        $res['data'] = $rows;
    } else {
        $res['success'] = 0;
        $res['message'] = 'Data not found';
    }
    $conn = null;
    echo json_encode($res);
?>