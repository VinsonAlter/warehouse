<?php
    require_once '../../function.php';
    date_default_timezone_set('Asia/Jakarta');
    $res = [];
    try {
        if($_POST['batch'] != '') {
            $noTransaksi = $_POST['batch'];
            $total = substr_count($noTransaksi, ' ; ') + 1;
            $arr = explode(' ; ', $noTransaksi);
            $tglSelesai = date_hour_to_str(date('d-m-Y H:i:00'));
            foreach($arr as $val) {
                $array = explode(' , ', $val);
                $noTransaksi = $array[1];
                $status = $array[4];
                if($status == 2) {
                    $selesai = "UPDATE [WMS].[dbo].[TB_Delivery]
                                    SET [Status] = 3,
                                        [TglSelesai] = '$tglSelesai'
                                    WHERE [NoTransaksi] = '$noTransaksi'
                                ";
                    $stmt = $pdo->prepare($selesai, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                    $stmt->execute();
                    if($stmt->rowCount() > 0) {
                        $res['success'] = 1;
                        $res['selesai'] = $selesai;
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