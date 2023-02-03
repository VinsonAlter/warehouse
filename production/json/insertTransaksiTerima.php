<?php
    require_once '../../function.php';
    date_default_timezone_set('Asia/Jakarta');
    $res = [];
    try {
        if($_POST['batch'] != '') {
            if($_POST['picker'] != '') {
                $batch = $_POST['batch'];
                $picker = $_POST['picker'];
                $arr = explode(' ; ', $batch);
                $tglTerima = date_hour_to_str(date('d-m-Y H:i:s'));
                foreach($arr as $val){
                    $array = explode(' , ', $val);
                    $noTransaksi = $array[0];
                    $tglTransaksi = date_to_str($array[1]);
                    $customer = $array[2];
                    $status = $array[3];
                    $sales = $array[4];
                    if($status == "") {
                        $insert = "INSERT INTO [WMS].[dbo].[TB_Delivery] 
                            ([NoTransaksi], [Customer], [TglTransaksi], [Status], [NamaPicker], [TglTerima], [NamaSales])
                            VALUES ('$noTransaksi', '$customer', '$tglTransaksi', 1, '$picker', '$tglTerima', '$sales')";
                        $stmt = $pdo->prepare($insert, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                        $stmt->execute();
                        if($stmt->rowCount() > 0){
                            $res['success'] = 1;
                            $res['insert'] = $insert;
                            $res['message'] = 'Status transaksi berhasil diupdate!';
                        } else {
                            $res['success'] = 0;
                            $res['message'] = 'Status transaksi gagal diupdate, mohon periksa koneksi anda!';
                        }
                    } else {
                        $res['success'] = 0;
                        $res['message'] = 'Status transaksi yang anda pilih sudah diterima!';
                    }
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