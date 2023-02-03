<?php
    require_once '../../function.php';
    if($_POST['transaksi']) {
        $res = [];
        $transaksi = $_POST['transaksi'];
        $query = "SELECT [NoTransaksi]
                          ,do.[PickerID]
                          ,[Status]
                          ,[Nama]
                          ,[TglTransaksi]
                          ,[NamaPicker]
                          ,[NamaDriver]
                          ,[TglTerima]
                          ,[TglKirim]
                          ,[TglSelesai]
                          ,do.[DriverID]
                          ,[NoPlat]
                          ,[PlatCust]
                          ,[DriverCust]
                          ,[NamaSales]
                          ,[Cabang]
                  FROM [WMS].[dbo].[TB_Delivery] do LEFT JOIN 
                       [WMS].[dbo].[TB_Picker] pic 
                       ON pic.PickerID = do.PickerID LEFT JOIN
                       [WMS].[dbo].[TB_Driver] d ON d.DriverID = do.DriverID WHERE
                       NoTransaksi = :transaksi";
        $stmt = $conn->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
        $stmt->bindParam(":transaksi", $transaksi, PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->rowCount() > 0) {
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                if(($row['PickerID']) != '') {
                    $row['PickerID'] = $row['PickerID'];
                } else {
                    $row['PickerID'] = '';
                }

                if(($row['NamaPicker']) != '') {
                    $row['NamaPicker'] = $row['NamaPicker'];
                } else {
                    $row['NamaPicker'] = '';
                }

                if(($row['DriverID']) != '') {
                    $row['DriverID'] = $row['DriverID'];
                } else {
                    $row['DriverID'] = '';
                }

                if(($row['NamaDriver']) != '') {
                    $row['NamaDriver'] = $row['NamaDriver'];
                } else {
                    $row['NamaDriver'] = '';
                }

                if(($row['NoPlat']) != '') {
                    $row['NoPlat'] = $row['NoPlat'];
                } else {
                    $row['NoPlat'] = '';
                }

                if(($row['PlatCust']) != '') {
                    $row['PlatCust'] = $row['PlatCust'];
                } else {
                    $row['PlatCust'] = '';
                }

                if(($row['DriverCust']) != '') {
                    $row['DriverCust'] = $row['DriverCust'];
                } else {
                    $row['DriverCust'] = '';
                }

                if(($row['NamaSales']) != '') {
                    $row['NamaSales'] = $row['NamaSales'];
                } else {
                    $row['NamaSales'] = '';
                }

                if(strtotime($row['TglKirim']) != '') {
                    $row['TglKirim'] = date('d-m-Y', strtotime($row['TglKirim']));
                } else {
                    $row['TglKirim'] = '';
                }

                if(strtotime($row['TglSelesai']) != '') {
                    $row['TglSelesai'] = date('d-m-Y', strtotime($row['TglSelesai']));
                } else {
                    $row['TglSelesai'] = '';
                }

                $data = array(
                    'transaksi' => $row['NoTransaksi'],
                    'status' => $row['Status'],
                    'picker' => $row['PickerID'],
                    'nama' => $row['Nama'],
                    'namaPicker' => $row['NamaPicker'],
                    'tgltransaksi' => date('d-m-Y', strtotime($row['TglTransaksi'])),
                    'tglterima' => date('d-m-Y', strtotime($row['TglTerima'])),
                    'tglkirim' => $row['TglKirim'],
                    'tglselesai' => $row['TglSelesai'],
                    'driver' => $row['DriverID'],
                    'namaDriver' => $row['NamaDriver'],
                    'platDriver' => $row['NoPlat'],
                    'platCust' => $row['PlatCust'],
                    'driverCust' => $row['DriverCust'],
                    'sales' => $row['NamaSales']
                );
            }
                
        }
            $res['success'] = 1;
            $res['data'] = $data;
        } else {
            $res['success'] = 0;
            $res['message'] = "Gagal menampilkan data, mohon dicoba lagi";
        }
    $conn = null;
    echo json_encode($res);
?>