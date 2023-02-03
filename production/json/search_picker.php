<?php
    require_once '../../function.php';
    $res = [];
    $query = "SELECT [PickerID], [NamaPicker] FROM [WMS].[dbo].[TB_Picker] WHERE Aktif = 1";
    $stmt = $conn->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
    $stmt->execute();
    if($stmt->rowCount() > 0) {
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
           $rows[] = $row['NamaPicker'];
           $rows2[] = $row['PickerID'];
        }
        $res['success'] = 1;
        $res['data'] = $rows;
        $res['id_data'] = $rows2;
    } else {
        $res['success'] = 0;
        $res['message'] = 'Data not found';
    }
    $conn = null;
    echo json_encode($res);
?>