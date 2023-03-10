<?php
    session_start();
    require_once '../../function.php';
    $user_data = $_SESSION['user_server'];
    $user_segmen = $_SESSION['segmen_user'];
    $sales_data = $_SESSION['sales_force'];
    if($_POST['transaksi']) {
        $res = [];
        $id = $_POST['id'];
        $transaksi = $_POST['transaksi'];
        foreach($user_data as $key => $value) {
            $filter[] = "
                        SELECT 
                         P.[ID]
                        ,P.[NoTransaksi]
                        ,P.[Tgl]
                        ,CASE WHEN ISNULL (P.[Owner], '') <> '' THEN
                            P.[Nama] + ' ( ' + P.[Owner] + ' ) '
                            ELSE
                            P.[Nama]
                            END AS Customer
                        ,D.[NamaPicker]
                        ,D.[Status]
                        ,D.[TglTransaksi]
                        ,D.[TglTerima]
                        ,D.[TglKirim]
                        ,D.[TglSelesai]
                        ,D.[JenisPengiriman]
                        ,D.[Wilayah]
                        ,D.[NamaEkspedisi]
                        ,D.[NamaDriver]
                        ,D.[NoPlat]
                        ,S.[Nama]
                        FROM [WMS].[dbo].[TB_Delivery] D RIGHT JOIN $value P
                        ON D.NoTransaksi = P.NoTransaksi 
                        LEFT JOIN $sales_data[$key] S ON P.SalesID = S.SalesID
                        WHERE
                        P.NoTransaksi = '$transaksi'
            ";
            $query = implode("UNION ALL", $filter);
        }
        // $query = "SELECT [NoTransaksi]
        //                   ,[NamaPicker]
        //                   ,[Status]
        //                   ,[Customer]
        //                   ,[TglTransaksi]
        //                   ,[TglTerima]
        //                   ,[TglKirim]
        //                   ,[TglSelesai]
        //                   ,[JenisPengiriman]
        //                   ,[Wilayah]
        //                   ,[NamaEkspedisi]
        //                   ,[NamaDriver]
        //                   ,[NoPlat] 
        //           FROM [WMS].[dbo].[TB_Delivery]
        //                 ON D.NoTransaksi = P.NoTransaksi
        //                 WHERE
        //                NoTransaksi = :transaksi AND IDTransaksi = :idTransaksi";
        $stmt = $conn->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
        // var_dump($query);
        // $stmt->bindParam(":transaksi", $transaksi, PDO::PARAM_STR);
        // $stmt->bindParam(":idTransaksi", $id, PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->rowCount() > 0) {
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                if(($row['Nama']) != '') {
                    $row['Nama'] = $row['Nama'];
                } else {
                    $row['Nama'] = '';
                }

                if(($row['Status']) != '') {
                    $row['Status'] = $row['Status'];
                } else {
                    $row['Status'] = '';
                }

                if(($row['NamaPicker']) != '') {
                    $row['NamaPicker'] = $row['NamaPicker'];
                } else {
                    $row['NamaPicker'] = '';
                }

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

                if(strtotime($row['TglTerima']) != '') {
                    $tglTerima = date('d-m-Y H:i', strtotime($row['TglTerima']));
                } else {
                    $tglTerima = "";
                }

                if(strtotime($row['TglKirim']) != '') {
                    $tglKirim = date('d-m-Y H:i', strtotime($row['TglKirim']));
                } else {
                    $tglKirim = "";
                }

                if(strtotime($row['TglSelesai']) != '') {
                    $tglSelesai = date('d-m-Y H:i', strtotime($row['TglSelesai']));
                } else {
                    $tglSelesai = '';
                }

                $data = array(
                    'idTransaksi' => $row['ID'],
                    'tglTransaksi' => date('d-m-Y H:i', strtotime($row['Tgl'])),
                    'customer' => $row['Customer'],
                    'transaksi' => $row['NoTransaksi'],
                    'sales' => $row['Nama'],
                    'status' => $row['Status'],
                    'picker' => $row['NamaPicker'],
                    'kirim' => $row['TglKirim'],
                    // 'tgltransaksi' => date('d-m-Y', strtotime($row['TglTransaksi'])),
                    'tglTerima' => $tglTerima,
                    'tglKirim' => $tglKirim,
                    // 'waktuKirim' => $waktuKirim,
                    'tglSelesai' => $tglSelesai,
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
        } else {
            $res['success'] = 0;
            $res['message'] = "Gagal menampilkan data, mohon dicoba lagi";
        }
    $conn = null;
    echo json_encode($res);
?>