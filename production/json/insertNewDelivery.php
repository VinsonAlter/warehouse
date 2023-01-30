<?php 

    require_once '../../function.php';

    $res = [];

    $no_transaksi = [];

    $tgl_transaksi = [];

    $nama_owner = [];

    date_default_timezone_set('Asia/Jakarta');

    if(isset($_POST['transaksi'])) {

        $transaksi = $_POST['transaksi'];

        $date = date('Y-m-d');

        // looping through transaksi

        foreach($transaksi as $key => $val) {

            [$no_transaksi, $tgl_transaksi, $nama_owner] = explode(",", $val);

            $insert = "INSERT INTO [WMS-System].[dbo].[TB_Delivery] 
                
                            ([NoTransaksi], [Customer], [TglTransaksi], [TglTerima], [Status])
                                        
                            VALUES ('".$no_transaksi."', '".$nama_owner."', '$tgl_transaksi', '$date', 1)";

            $stmt = $conn->prepare($insert, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);

            $stmt->execute();

            if($stmt->rowCount() > 0) {

                $res['success'] = 1;

                $res['message'] = 'Data berhasil disimpan!';

            } else {

                $res['success'] = 0;

                $res['message'] = 'Data gagal disimpan, mohon dicoba lagi';

            }
        
        }
                
        $conn = null;

    }

    echo json_encode($res);

?>