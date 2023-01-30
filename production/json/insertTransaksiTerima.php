<?php
    require_once '../../function.php';
    $res = [];
    try {
        if($_POST['batch'] != '') {
            if($_POST['picker'] != '') {
                $batch = $_POST['batch'];
                $arr = explode(' ; ', $batch);
                foreach($arr as $val){
                    $arr = explode(' , ', $val);
                    $noTransaksi = $arr[0];
                    $tglTransaksi = date_to_str($arr[1]);
                    $customer = $arr[2];
                    $status = $arr[3];
                }
                $insert = "INSERT INTO [WMS-System].[dbo].[TB_Delivery]
                            ([NoTransaksi]
                            ,[Status]
                            ,[TglTransaksi]
                            ,[Customer])
                            VALUES
                            ('$noTransaksi',
                            '$status',
                            '$tglTransaksi',
                            '$customer')";
                $stmt = $pdo->prepare($insert, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                $stmt->execute();
                if($stmt->rowCount() > 0){
                    $res['success'] = 1;
                    $res['message'] = 'Transaksi berhasil diupdate!';
                } else {
                    $res['success'] = 0;
                    $res['message'] = 'Transaksi gagal diupdate, mohon periksa koneksi anda!';
                }
            } else {
                $res['success'] = 0;
                $res['message'] = 'Mohon tentukan picker untuk transaksi pengiriman yang diterima!';
            }
        } else {
            $res['success'] = 0;
            $res['message'] = 'Mohon pastikan Anda sudah checklist nomor Transaksi yang diterima!';
        }
        $pdo = null;
    } catch (Exception $e) {
        $res['success'] = 0;
        $res['message'] = 'ada Error';
        $res['error'] = $e->getLine();
        $res['error_2'] = $e->getMessage();
    }
    echo json_encode($res);
?>