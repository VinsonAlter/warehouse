<?php
    require_once '../../function.php';

    $res = [];

    if(isset($_POST['picker']) ? $picker = $_POST['picker'] : $picker = '');

    $noTransaksi = $_POST['no_transaksi'];

    if(isset($_POST['tgl_kirim']) ? $tglKirim = date_to_str($_POST['tgl_kirim']) : $tglKirim = '');

    if(isset($_POST['select_driver']) ? $driverPickUp = $_POST['select_driver'] : $driverPickUp = '');

    if(isset($_POST['select_plat']) ? $platPickUp = $_POST['select_plat'] : $platPickUp = '');

    if(isset($_POST['driver_cust']) ? $driverCustPickUp = $_POST['driver_cust'] : $driverCustPickUp = '');

    if(isset($_POST['plat_cust']) ? $platCustPickUp = $_POST['plat_cust'] : $platCustPickUp = '');
    
    if(isset($_POST['nama_sales']) ? $namaSales = $_POST['nama_sales'] : $namaSales = '');

    if(isset($_POST['tgl_selesai']) ? $tglSelesai = date_to_str($_POST['tgl_selesai']) : $tglSelesai = '');

    $check = "SELECT * FROM [WMS-System].[dbo].[TB_Delivery]
                         WHERE NoTransaksi = :noTransaksi";

    $stmt = $conn->prepare($check, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);

    $stmt->bindParam(":noTransaksi", $noTransaksi, PDO::PARAM_STR);

    $stmt->execute();

    if($stmt->rowCount() > 0) {

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

            $tglTerima =  date('Y-m-d', strtotime($row['TglTerima']));

            $tgl_kirim = date('Y-m-d', strtotime($row['TglKirim']));

            $status = $row['Status'];

            if($status == 'Diterima') {

                if($tglKirim >= $tglTerima) {

                    $update = "UPDATE [WMS-System].[dbo].[TB_Delivery] 
                        SET TglKirim = :kirim , 
                            Status = 'Dikirim' , PickerID = :picker, DriverID = :driver, 
                            NoPlat = :plat, PlatCust = :platCust, DriverCust = :driverCust,
                            NamaSales = :namaSales 
                            WHERE NoTransaksi = :noTransaksi";

                    $stmt2 = $conn->prepare($update, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                    $stmt2->bindParam(":noTransaksi", $noTransaksi, PDO::PARAM_STR);
                    $stmt2->bindParam(":kirim", $tglKirim, PDO::PARAM_STR);
                    $stmt2->bindParam(":picker", $picker, PDO::PARAM_STR);
                    $stmt2->bindParam(":driver", $driverPickUp, PDO::PARAM_STR);
                    $stmt2->bindParam(":plat", $platPickUp, PDO::PARAM_STR);
                    $stmt2->bindParam(":platCust", $platCustPickUp, PDO::PARAM_STR);
                    $stmt2->bindParam(":driverCust", $driverCustPickUp, PDO::PARAM_STR);
                    $stmt2->bindParam(":namaSales", $namaSales, PDO::PARAM_STR);
                    $stmt2->execute();
                    if($stmt2->rowCount() > 0) {
                        $res['success'] = 1;
                        $res['message'] = 'Data berhasil diganti!';
                    } else {
                        $res['success'] = 0;
                        $res['message'] = 'Data gagal diganti, mohon dicoba kembali!';
                    }
                } else {
                    $res['success'] = 0;
                    $res['message'] = 'Tanggal Kirim tidak boleh ditentukan sebelum tanggal terima!';
                }

            } else if($status == 'Dikirim' || $status == 'Selesai') {

                if(!isset($_POST['jenis_pengiriman'])) {
                    $res['success'] = 0;
                    $res['message'] = 'Mohon dipilih jenis pengiriman anda!';
                }

                if($tglSelesai < $tgl_kirim) {
                    $res['success'] = 0;
                    $res['message'] = 'Tgl selesai tidak boleh ditentukan sebelum tanggal pengiriman!';
                }

                if(($tglSelesai >= $tgl_kirim) && (isset($_POST['jenis_pengiriman']))) {

                    $update = "UPDATE [WMS-System].[dbo].[TB_Delivery] 
                            SET TglSelesai = :selesai, 
                            Status = 'Selesai', DriverID = :driver, 
                            NoPlat = :plat, PlatCust = :platCust, DriverCust = :driverCust,
                            NamaSales = :namaSales 
                            WHERE NoTransaksi = :noTransaksi";
                
                    $stmt3 = $conn->prepare($update, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                    $stmt3->bindParam(":noTransaksi", $noTransaksi, PDO::PARAM_STR);
                    $stmt3->bindParam(":selesai", $tglSelesai, PDO::PARAM_STR);
                    $stmt3->bindParam(":driver", $driverPickUp, PDO::PARAM_STR);
                    $stmt3->bindParam(":plat", $platPickUp, PDO::PARAM_STR);
                    $stmt3->bindParam(":platCust", $platCustPickUp, PDO::PARAM_STR);
                    $stmt3->bindParam(":driverCust", $driverCustPickUp, PDO::PARAM_STR);
                    $stmt3->bindParam(":namaSales", $namaSales, PDO::PARAM_STR);
                    $stmt3->execute();
                    if($stmt3->rowCount() > 0) {
                        $res['success'] = 1;
                        $res['message'] = 'Data berhasil diganti!';
                    } else {
                        $res['success'] = 0;
                        $res['message'] = 'Data gagal diganti, mohon dicoba kembali!';
                    }
                } else {
                    $res['success'] = 0;
                    $res['message'] = 'Error!';
                    // $res['message'] = 'Tgl selesai tidak boleh ditentukan sebelum tanggal pengiriman!';
                }

            }
        }

    } else {
        $res['success'] = 0;
        $res['message'] = 'Anda belum menerima No Transaksi ini!';
    }

    $conn = null;
    echo json_encode($res);
?>