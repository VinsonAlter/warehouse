<?php
    session_start();
    require_once '../../function.php';
    $data = $result = array();
    $user_data = $_SESSION['user_server'];
    $user_segmen = $_SESSION['segmen_user'];
    $sales_data = $_SESSION['sales_force'];
    try {
        if ($pdo) {
            $urut = $total_record = 0;
            $search_query = '';
            $search = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
            $table = '';
            if($search) {
                $search_query = "AND NoTransaksi LIKE '%$search%' 
                                    OR Status LIKE '%$search%'
                                    OR NamaPicker LIKE '%$search%'
                                    OR Customer LIKE '%$search%'
                                    OR TglTransaksi LIKE '%$search%'
                                    OR TglTerima LIKE '%$search%'
                                    OR TglKirim LIKE '%$search%'
                                    OR TglSelesai LIKE '%$search%'
                                    OR JenisPengiriman LIKE '%$search%'
                                    OR Wilayah LIKE '%$search%'
                                    OR NamaEkspedisi LIKE '%$search%'
                                    OR NamaDriver LIKE '%$search%'
                                    OR NoPlat LIKE '%$search%'
                                    OR NamaSales LIKE '%$search%'
                                    OR Cabang LIKE '%$search%'";
            }
            $tgl_condition = '';
            $tglAwal = date('d-m-Y');
            $tglAkhir = date('d-m-Y');
            // $awal_transaksi = date('d-m-Y');
            // $akhir_transaksi = date('d-m-Y');
            // $awal_terima = date('d-m-Y');
            // $akhir_terima = date('d-m-Y');
            // $awal_kirim = date('d-m-Y');
            // $akhir_kirim = date('d-m-Y');
            // $awal_selesai = date('d-m-Y');
            // $akhir_selesai = date('d-m-Y');
            $end_day = ' 23:59:59';
            $order_tanggal = '';
            if(isset($_SESSION['FilterTglAwal'])) $tglAwal = $_SESSION['FilterTglAwal'];
            if(isset($_SESSION['FilterTglAkhir'])) $tglAkhir = $_SESSION['FilterTglAkhir'];
            // if(isset($_SESSION['FilterStatusAwalTransaksi'])) $awal_transaksi = $_SESSION['FilterStatusAwalTransaksi'];
            // if(isset($_SESSION['FilterStatusAkhirTransaksi'])) $akhir_transaksi = $_SESSION['FilterStatusAkhirTransaksi'];
            // if(isset($_SESSION['FilterStatusAwalTerima'])) $awal_terima = $_SESSION['FilterStatusAwalTerima'];
            // if(isset($_SESSION['FilterStatusAkhirTerima'])) $akhir_terima = $_SESSION['FilterStatusAkhirTerima'];
            // if(isset($_SESSION['FilterStatusAwalKirim'])) $awal_kirim = $_SESSION['FilterStatusAwalKirim'];
            // if(isset($_SESSION['FilterStatusAkhirKirim'])) $akhir_kirim = $_SESSION['FilterStatusAkhirKirim'];
            // if(isset($_SESSION['FilterStatusAwalSelesai'])) $awal_selesai = $_SESSION['FilterStatusAwalSelesai'];
            // if(isset($_SESSION['FilterStatusAkhirSelesai'])) $akhir_selesai = $_SESSION['FilterStatusAkhirSelesai'];
            $status = 'transaksi_on';
            if (isset($_SESSION['status'])) $status = $_SESSION['status'];
            switch($status) {
                case 'terima':
                    $tgl_condition = " WHERE W.[TglTerima] BETWEEN '".date_to_str($tglAwal)."' AND 
                                    '".date_to_str($tglAkhir). $end_day ."'";
                    $order_tgl = " ORDER BY [Status], [Tgl], [TglTerima] DESC, Customer, [NoTransaksi]";
                    break;
                case 'kirim':
                    $tgl_condition = " WHERE W.[TglKirim] BETWEEN '".date_to_str($tglAwal)."' AND 
                                    '".date_to_str($tglAkhir). $end_day ."'";
                    $order_tgl = " ORDER BY [Status], [Tgl], [TglKirim] DESC, Customer, [NoTransaksi]";                
                    break;
                case 'selesai':
                    $tgl_condition = " WHERE W.[TglSelesai] BETWEEN '".date_to_str($tglAwal)."' AND 
                                    '".date_to_str($tglAkhir). $end_day ."'";
                    $order_tgl = " ORDER BY [Status], [Tgl], [TglSelesai] DESC, Customer, [NoTransaksi]";
                    break;
                default:
                    $tgl_condition = " WHERE P.[Tgl] BETWEEN '".date_to_str($tglAwal)."' 
                                        AND '".date_to_str($tglAkhir). $end_day ."'";
                    $order_tgl = " ORDER BY [Status], [Tgl] DESC, Customer, [NoTransaksi]";
                    break;
                // default:
                //     $tgl_condition = "";
                //     $order_tgl = "";
                //     break;
            }
            // if (isset($_SESSION['StatusFilterTransaksi'])) $status = $_SESSION['StatusFilterTransaksi'];
            // switch($status){   
            //     case 'terima_on':
            //         $tgl_condition = "WHERE W.[TglTerima] BETWEEN '".date_to_str($awal_terima)."'
            //             AND '".date_to_str($akhir_terima) . $end_day . "'";
            //         $order_tanggal = " ORDER BY [Status], [Tgl], [TglTerima] DESC, Customer, [NoTransaksi]";
            //         break;
            //     case 'kirim_on':
            //         $tgl_condition = "WHERE W.[TglKirim] BETWEEN '".date_to_str($awal_kirim)."'
            //             AND '".date_to_str($akhir_kirim) . $end_day . "'";
            //         $order_tanggal = " ORDER BY [Status], [Tgl], [TglKirim] DESC, Customer, [NoTransaksi]";
            //         break;
            //     case 'selesai_on':
            //         $tgl_condition = "WHERE W.[TglSelesai] BETWEEN '".date_to_str($awal_selesai)."'
            //             AND '".date_to_str($akhir_selesai) . $end_day . "'";
            //         $order_tanggal = " ORDER BY [Status], [Tgl], [TglSelesai] DESC, Customer, [NoTransaksi]";
            //         break;
            //     default:
            //         $tgl_condition = "WHERE P.[Tgl] BETWEEN '".date_to_str($awal_transaksi)."'
            //             AND '".date_to_str($akhir_transaksi) . $end_day . "'";
            //         $order_tanggal = " ORDER BY [Status], [Tgl] DESC, Customer, [NoTransaksi]";
            //         break;
            // }
            // get the TotalRecords
            foreach($user_data as $key => $value) {
                $filter[] = "
                    SELECT P.[ID], P.[NoTransaksi], P.[Tgl], W.[Status],
                           CASE WHEN ISNULL(P.[Owner], '') <> '' THEN P.[Nama] + ' ( ' + P.[Owner] + ' ) '
                                ELSE P.[Nama]
                           END AS Customer, 
                           W.[NamaDriver], W.[NamaPicker], W.[TglTerima], W.[TglKirim], 
                           W.[TglSelesai], W.[Wilayah], W.[JenisPengiriman], W.[NamaEkspedisi],
                           W.[NoPlat], S.[Nama]
                    FROM [WMS].[dbo].[TB_Delivery] W RIGHT JOIN $value P
                    ON W.NoTransaksi = P.NoTransaksi LEFT JOIN $sales_data[$key] S ON P.SalesID = S.SalesID
                    " . ' ' . $tgl_condition . " AND
                    P.[Segmen] IN ($user_segmen) AND
                    P.[Status] = 1 AND P.[NoTransaksi] <> 'J' AND 
                    isnull(P.[NoTransaksiOriginal], '') = ''
                ";
                $table = implode("UNION ALL", $filter);
            }
            // $table = "SELECT [IDTransaksi]
            //                 ,[NoTransaksi]
            //                 ,[Status]
            //                 ,[Customer]
            //                 ,[NamaDriver]
            //                 ,[NamaPicker]
            //                 ,[TglTransaksi]
            //                 ,[TglTerima]
            //                 ,[TglKirim]
            //                 ,[TglSelesai]
            //                 ,[Wilayah]
            //                 ,[JenisPengiriman]
            //                 ,[NamaEkspedisi]
            //                 ,[NoPlat]
            //                 ,[NamaSales]
            //                 ,[Cabang]
            //             FROM [WMS].[dbo].[TB_Delivery]";
        }

        $stmt = $pdo->prepare($table, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
        $stmt->execute();
        $total_record += $stmt->rowCount();

        // Fill the table with records
        
        // $query = "SELECT * FROM (".$table . ' ' . $status_tanggal . $search_query.") temp" . ' ' . $order_tanggal;
        $query = "SELECT * FROM ($table) temp" . $search_query .  $order_tgl; 
        // var_dump($query);
        $stmt = $pdo->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
        $stmt->execute();
        if($stmt->rowCount() > 0) {
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $urut++;
                $id = $row['ID'];
                $transaksi = $row['NoTransaksi'];
                $nama = $row['Customer'];
                $status = $row['Status'];
                $tglTransaksi = $row['Tgl'];
                $tglTerima = $row['TglTerima'];
                $tglKirim = $row['TglKirim'];
                $tglSelesai = $row['TglSelesai'];
                $jenis = $row['JenisPengiriman'];
                $wilayah = $row['Wilayah'];
                $ekspedisi = $row['NamaEkspedisi'];
                $namaPicker = $row['NamaPicker'];
                $namaDriver = $row['NamaDriver'];
                $platDriver = $row['NoPlat'];
                $wilayah = $row['Wilayah'];
                $sales = $row['Nama'];
                // comment this part because it's not needed yet
                $aksi = '<a href="#" data-bs-toggle="modal" data-bs-target="#masterModalEdit" 
                    onclick="getDelivery(\''.$transaksi.'\', \''.$id.'\')"><i class="fa fa-edit"></i></a>';
                $data[] = array(
                    $urut,
                    $transaksi, 
                    $nama, 
                    $status,
                    $tglTransaksi, 
                    $tglTerima,
                    $namaPicker,
                    $tglKirim, 
                    $tglSelesai,
                    $jenis,
                    $wilayah,
                    $ekspedisi,
                    $namaDriver,
                    $platDriver,
                    $sales,
                    $aksi
                );
            }
            $pdo = null;
        }
        // Sorting Data 
        if(!empty($data)) {
            $sort1 = $sort2 = $sort3 = $sort4 = $sort5 = $sort6 = $sort7 = $sort8 = $sort9 = $sort10 = $sort11 = $sort12 = $sort13 = $sort14 = array();
            // Multi Dimensional Sorting
            foreach($data as $key => $value) {
                $sort1[$key] = $value[1];
                $sort2[$key] = $value[2];
                $sort3[$key] = $value[3];
                $sort4[$key] = $value[4];
                $sort5[$key] = $value[5];
                $sort6[$key] = $value[6];
                $sort7[$key] = $value[7];
                $sort8[$key] = $value[8];
                $sort9[$key] = $value[9];
                $sort10[$key] = $value[10];
                $sort11[$key] = $value[11];
                $sort12[$key] = $value[12];
                $sort13[$key] = $value[13];
                $sort14[$key] = $value[14];
            }

            // Sorting ASC or DESC 

            if(isset($_REQUEST['order']) && count($_REQUEST['order'])) {
                for($i = 0, $ien = count($_REQUEST['order']); $i < $ien; $i++) {
                    $columnIdx = intval($_REQUEST['order'][$i]['column']);
                    $requestColumn = $_REQUEST['columns'][$columnIdx];
                    if($requestColumn['orderable'] == 'true') {
                        $dir = $_REQUEST['order'][$i]['dir'] === 'asc' ? SORT_ASC : SORT_DESC;
                        switch($columnIdx) {
                            case 2:
                                array_multisort($sort2, $dir, $data);
                                break;
                            case 3:
                                array_multisort($sort3, $dir, $data);
                                break;
                            case 4:
                                array_multisort($sort4, $dir, $data);
                                break;
                            case 5:
                                array_multisort($sort5, $dir, $data);
                                break;
                            case 6:
                                array_multisort($sort6, $dir, $data);
                                break;
                            case 7:
                                array_multisort($sort7, $dir, $data);
                                break;
                            case 8:
                                array_multisort($sort8, $dir, $data);
                                break;
                            case 9:
                                array_multisort($sort9, $dir, $data);
                                break;
                            case 10:
                                array_multisort($sort10, $dir, $data);
                                break;
                            case 11:
                                array_multisort($sort11, $dir, $data);
                                break;
                            case 12:
                                array_multisort($sort12, $dir, $data);
                                break;
                            case 13:
                                array_multisort($sort13, $dir, $data);
                                break;
                            case 14:
                                array_multisort($sort14, $dir, $data);
                                break;
                            default:
                                array_multisort($sort1, $dir, $data);
                                break;
                        }
                    }
                }
            }
        }
        // slicing $data, from start to designated length 
        if(isset($_REQUEST['start']) && $_REQUEST['length'] != -1) {
            $data = array_slice($data, intval($_REQUEST['start']), intval($_REQUEST['length']));
        }

        // Format datetime to d-m-Y
        for ($i=0;$i<count($data);$i++)
		{	
            $data[$i][4] = date('d-m-Y', strtotime($data[$i][4]));
			if (strtotime($data[$i][4]) != '') {
                $data[$i][4] = date('d-m-Y H:i', strtotime($data[$i][4]));
            } else {
                $data[$i][4] = '';
            } 

            if (strtotime($data[$i][5]) != '') {
                $data[$i][5] = date('d-m-Y H:i', strtotime($data[$i][5]));
            } else {
                $data[$i][5] = '';
            } 

            if (strtotime($data[$i][7]) != '') {
                $data[$i][7] = date('d-m-Y H:i', strtotime($data[$i][7]));
            } else {
                $data[$i][7] = '';
            } 

            if (strtotime($data[$i][8]) != '') {
                $data[$i][8] = date('d-m-Y H:i', strtotime($data[$i][8]));
            } else {
                $data[$i][8] = '';
            } 
		}
		

        $result = array(
            'draw' => isset($_REQUEST['draw']) ? intval($_REQUEST['draw']): 0,
            'recordsTotal' => $total_record,
            'recordsFiltered' => $urut,
            "data" => $data,
            "query" => $query
        );


    } catch (Exception $e) {
        $result = array(
            "draw" => isset($_REQUEST['draw']) ? intval($_REQUEST['draw']) : 0,
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => $data,
            // "table" => $table,
            "query" => $query,
            "error" => $e -> getMessage(),
            "error2" => $e -> getLine(),
        );
    }

    echo json_encode($result);
?>
