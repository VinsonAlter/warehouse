<?php
    require_once '../../function.php';
    $res = [];
    if(isset($_POST['update_terima'])){
        $batch = $_POST['batch'];
        $arr = explode(' ; ', $batch);
        foreach($arr as $val){
            $arr = explode(' , ', $val);
            $noTransaksi = $arr[0];
            $tglTransaksi = date_to_str($arr[1]);
            $customer = $arr[2];
            // $tglTerima = $arr[3];
        }
        $insert = "INSERT INTO [WMS-System].[dbo].[TB_Delivery]
                    ([NoTransaksi]
                    ,[TglTransaksi]
                    ,[Nama])
                    VALUES
                    ('$noTransaksi',
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
    }
?>