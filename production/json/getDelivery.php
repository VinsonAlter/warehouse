<?php
    require_once '../../function.php';
    if($_POST['transaksi']) {
        $res = [];
        $id = $_POST['id'];
        $transaksi = $_POST['transaksi'];
        $query = "SELECT [NoTransaksi]
                          ,[NamaPicker]
                          ,[Status]
                          ,[Customer]
                          ,[TglTransaksi]
                          ,[TglTerima]
                          ,[TglKirim]
                          ,[TglSelesai]
                          ,[JenisPengiriman]
                          ,[Wilayah]
                          ,[NamaEkspedisi]
                          ,[NamaDriver]
                          ,[NoPlat]
                  FROM [WMS].[dbo].[TB_Delivery] WHERE
                       NoTransaksi = :transaksi AND IDTransaksi = :idTransaksi";
        $stmt = $conn->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
        $stmt->bindParam(":transaksi", $transaksi, PDO::PARAM_STR);
        $stmt->bindParam(":idTransaksi", $id, PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->rowCount() > 0) {
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
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
                    // 'status' => $row['Status'],
                    // 'picker' => $row['PickerID'],
                    // 'nama' => $row['Nama'],
                    // 'namaPicker' => $row['NamaPicker'],
                    // 'tgltransaksi' => date('d-m-Y', strtotime($row['TglTransaksi'])),
                    // 'tglterima' => date('d-m-Y', strtotime($row['TglTerima'])),
                    // 'tglkirim' => $row['TglKirim'],
                    // 'tglselesai' => $row['TglSelesai'],
                    'ekspedisi' => $row['NamaEkspedisi'],
                    'namaDriver' => $row['NamaDriver'],
                    'platDriver' => $row['NoPlat'],
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