<?php
    require_once '../../function.php';
    date_default_timezone_set('Asia/Jakarta');
    $res = [];
    try {
        // not using batch anymore, since using submit forms
        // if($_POST['batch'] != '') {
        //     $noTransaksi = $_POST['batch'];
        //     $total = substr_count($noTransaksi, ' ; ') + 1;
        //     $arr = explode(' ; ', $noTransaksi);
        //     $tglSelesai = date_hour_to_str(date('d-m-Y H:i:00'));
        if(isset($_POST['NomorTransaksi']) != '') {
            $noTransaksi = $_POST['NomorTransaksi'];
            $total = substr_count($noTransaksi, ' ; ') + 1;
            $arr = explode(' ; ', $noTransaksi);
            $tglSelesai = date_hour_to_str($_POST['waktu_selesai'] . ':00');
            $keterangan = $_POST['keterangan'];
            foreach($arr as $val) {
                $array = explode(' , ', $val);
                $idTransaksi = $array[0];
                $noTransaksi = $array[1];
                $status = $array[4];
                // var_dump($status);
                if($status == 2) {
                    $status_selesai = 3;
                    $selesai = "UPDATE [WMS].[dbo].[TB_Delivery]
                                    SET [Status] = :status,
                                        [TglSelesai] = :selesai,
                                        [Keterangan] = :keterangan
                                    WHERE [NoTransaksi] = :no AND [IDTransaksi] = :id
                                ";
                    $stmt = $pdo->prepare($selesai, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                    $stmt->bindParam(":status", $status_selesai, PDO::PARAM_STR);
                    $stmt->bindParam(":selesai", $tglSelesai, PDO::PARAM_STR);
                    $stmt->bindParam(":keterangan", $keterangan, PDO::PARAM_STR);
                    $stmt->bindParam(":no", $noTransaksi, PDO::PARAM_STR);
                    $stmt->bindParam(":id", $idTransaksi, PDO::PARAM_STR);
                    $stmt->execute();
                    if($stmt->rowCount() > 0) {
                        $res['success'] = 1;
                        // $res['selesai'] = $selesai;
                        $res['message'] = $total . ' transaksi diconfirm selesai';
                    } else {
                        $res['success'] = 0;
                        $res['message'] = 'transaksi gagal diconfirm, mohon periksa koneksi anda!';
                    }
                } else {
                    $res['success'] = 0;
                    $res['message'] = 'Transaksi yang anda centang masih belum dikirim!';
                }
            }
        } else {
            $res['success'] = 0;
            $res['message'] = 'Mohon dicentang no transaksi yang hendak diconfirm selesai';
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