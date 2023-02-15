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
                if(($row['Wilayah']) != '') {
                    $row['Wilayah'] = $row['Wilayah'];
                } else {
                    $row['Wilayah'] = '';
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

                if(strtotime($row['TglKirim']) != '') {
                    $tglKirim = date('d-m-Y H:i', strtotime($row['TglKirim']));
                } else {
                    $tglKirim = "";
                }

                if(strtotime($row['TglSelesai']) != '') {
                    $row['TglSelesai'] = date('d-m-Y', strtotime($row['TglSelesai']));
                } else {
                    $row['TglSelesai'] = '';
                }

                $data = array(
                    'transaksi' => $row['NoTransaksi'],
                    'status' => $row['Status'],
                    'picker' => $row['NamaPicker'],
                    'kirim' => $row['TglKirim'],
                    // 'customer' => $row['Customer'],
                    // 'tgltransaksi' => date('d-m-Y', strtotime($row['TglTransaksi'])),
                    'tglTerima' => date('d-m-Y H:i', strtotime($row['TglTerima'])),
                    'tglKirim' => $tglKirim,
                    // 'waktuKirim' => $waktuKirim,
                    // 'tglselesai' => $row['TglSelesai'],
                    'jenisPengiriman' => $row['JenisPengiriman'],
                    'wilayah' => $row['Wilayah'],
                    'ekspedisi' => $row['NamaEkspedisi'],
                    'namaDriver' => $row['NamaDriver'],
                    'platDriver' => $row['NoPlat'],
                );
            }
                
        }
            $res['success'] = 1;
            $res['data'] = $data;
            $res['tgl'] = $data['kirim'];
        } else {
            $res['success'] = 0;
            $res['message'] = "Gagal menampilkan data, mohon dicoba lagi";
        }
    $conn = null;
    echo json_encode($res);
?>