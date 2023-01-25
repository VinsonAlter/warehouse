<?php
    session_start();
    require_once '../../function.php';
    $sales = $_SESSION['sales_force'];
    $res = [];
    foreach($sales as $key => $value) {
        $search[] = "SELECT [Nama] FROM $value P WHERE Aktif = 'Y'";
        $searching = implode(" UNION ALL ", $search);
    }
    $stmt = $pdo->prepare($searching, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
	$stmt->execute();	
	if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rows[] = $row['Nama'];
        }
        $res['success'] = 1;
        $res['data'] = $rows;
    } else {
        $res['success'] = 0;
        $res['message'] = 'Data not found';
    }
    $pdo = null;
    echo json_encode($res);
?>