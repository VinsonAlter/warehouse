<?php 

    require_once '../../function.php';

    $res = [];

    date_default_timezone_set('Asia/Jakarta');

    if($_POST['transaksi']) {

        // $check = "SELECT * FROM [WMS-System].[dbo].[TB_User] WHERE username = :username";

        // $stmt = $conn->prepare($check, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);

        // $stmt->bindParam(':username', $username, PDO::PARAM_STR);

        // $stmt->execute();

        // if($stmt->rowCount() > 0) {

        //     $res['success'] = 0;

        //     $res['message'] = 'Username already exist in database!';

        // } else {

        $transaksi = $_POST['transaksi'];

        $date = date('Y-m-d H:i:s');

        // looping through transaksi

        for($i = 0; $i < count($transaksi); $i++) {
        
            $insert = "INSERT INTO [WMS-System].[dbo].[TB_Delivery] 
            
                        ([NoTransaksi], [TglTerima], [Status])
                                    
                        VALUES ('".$transaksi[$i]."', '$date', 'Diterima')";

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

        // $stmt->bindParam(':transaksi', $transaksi, PDO::PARAM_STR);
                
        // $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                
        $conn = null;

        }

    echo json_encode($res);

?>