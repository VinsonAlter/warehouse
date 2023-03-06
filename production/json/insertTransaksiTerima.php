<?php
    require_once '../../function.php';
    date_default_timezone_set('Asia/Jakarta');
    $res = [];
    try {
        // not using batch anymore, since using submit forms 
        // if($_POST['batch'] != '') {
        //     if($_POST['picker'] != '') {
        //         $batch = $_POST['batch'];
        //         $picker = $_POST['picker'];
        //         $arr = explode(' ; ', $batch);
        //         // count sepparated value inside array
        //         $total = substr_count($batch, ' ; ') + 1;
        if(isset($_POST['NomorTransaksi']) != '') {
            if(isset($_POST['picker']) != '') {
                $noTransaksi = $_POST['NomorTransaksi'];
                $picker = $_POST['picker'];
                $tglTerima = date_hour_to_str($_POST['waktu_terima'] . ':00');
                $total = substr_count($noTransaksi, ' ; ') + 1;
                $arr = explode(' ; ', $noTransaksi);
                if($tglTerima == false) {
                    $res['success'] = 0;
                    $res['message'] = 'Pastikan anda memasukkan format tanggal yang benar';
                } else {
                    foreach($arr as $val){
                        $array = explode(' , ', $val);
                        $idTransaksi = $array[0];
                        $noTransaksi = $array[1];
                        $tglTransaksi = date_to_str($array[2]);
                        $customer = $array[3];
                        $status = $array[4];
                        $sales = $array[5];
                        if($status == "") {
                            $status_terima = 1;
                            $insert = "INSERT INTO [WMS].[dbo].[TB_Delivery] 
                                ([IDTransaksi], [NoTransaksi], [Customer], [TglTransaksi], [Status], [NamaPicker], [TglTerima], [NamaSales])
                                VALUES (:id, :no, :cust, :tgltransaksi, :status, :picker, :terima, :sales)";
                            $stmt = $pdo->prepare($insert, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                            $stmt->bindParam(":id", $idTransaksi, PDO::PARAM_STR);
                            $stmt->bindParam(":no", $noTransaksi, PDO::PARAM_STR);
                            $stmt->bindParam(":cust", $customer, PDO::PARAM_STR);
                            $stmt->bindParam(":status", $status_terima, PDO::PARAM_INT);
                            $stmt->bindParam(":tgltransaksi", $tglTransaksi, PDO::PARAM_STR);
                            $stmt->bindParam(":picker", $picker, PDO::PARAM_STR);
                            $stmt->bindParam(":terima", $tglTerima, PDO::PARAM_STR);
                            $stmt->bindParam(":sales", $sales, PDO::PARAM_STR);
                            $stmt->execute();
                            if($stmt->rowCount() > 0){
                                $res['success'] = 1;
                                // $res['insert'] = $insert;
                                $res['message'] = $total . ' transaksi berhasil diupdate!';
                            } else {
                                $res['success'] = 0;
                                $res['message'] = 'Status transaksi gagal diupdate, mohon periksa koneksi anda!';
                            }
                        } else {
                            $res['success'] = 0;
                            $res['message'] = 'Status transaksi yang anda pilih sudah diterima!';
                        }
                    }
                }
            } else {
                $res['success'] = 0;
                $res['message'] = 'Mohon tentukan picker untuk transaksi pengiriman yang diterima!';
            }
        } else {
            $res['success'] = 0;
            $res['message'] = 'Mohon pastikan Anda sudah checklist nomor Transaksi yang diterima!';
            // $res['batch'] = $_POST['batch'];
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