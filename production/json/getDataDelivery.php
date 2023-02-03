<?php
    session_start();
    require_once '../../function.php';
    $data = $result = array();
    $user_data = $_SESSION['user_server'];
    $user_segmen = $_SESSION['segmen_user'];
    $sales_data = $_SESSION['sales_force'];
    try {
        if($pdo) {
            $search_query = '';
            $search = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
            if($search) {
                $search_query = " WHERE [NoTransaksi] LIKE '%$search%' 
                                    OR [Tgl] LIKE '%$search%'
                                    OR [Nama] LIKE '%$search%'
                                    OR [Owner] LIKE '%$search%'
                                    OR [Status] LIKE '%$search%'
                                    OR [TglTerima] LIKE '%$search%'
                                    OR [NamaPicker] LIKE '%$search%'
                                    OR [TglKirim] LIKE '%$search%'
                                    "; 
            }
            // $tgl_transaksi = $_SESSION['FilterTglTransaksi'] != date('d-m-Y') ? $_SESSION['FilterTglTransaksi'] : date('d-m-Y');
            // $tgl_terima = $_SESSION['FilterTglTerima'] != date('d-m-Y') ? $_SESSION['FilterTglTerima'] : date('d-m-Y');
            $tgl_condition = '';
            $urut = $total_record = 0;
            // $tgl_transaksi = $_SESSION['FilterTglTransaksi'] != date('d-m-Y') ? $_SESSION['FilterTglTransaksi'] : date('d-m-Y');
            // $tgl_terima = $_SESSION['FilterTglTerima'] != date('d-m-Y') ? $_SESSION['FilterTglTerima'] : date('d-m-Y');
            $tgl_transaksi = date('d-m-Y');
            $akhir_transaksi = date('d-m-Y');
            $tgl_terima = date('d-m-Y');
            $akhir_terima = date('d-m-Y');
            $end_day = ' 23:59:59';
            if (isset($_SESSION['FilterTglTransaksi'])) $tgl_transaksi = $_SESSION['FilterTglTransaksi'];
            if (isset($_SESSION['FilterAkhirTransaksi'])) $akhir_transaksi = $_SESSION['FilterAkhirTransaksi'];
            if (isset($_SESSION['FilterTglTerima'])) $tgl_terima = $_SESSION['FilterTglTerima'];
            if (isset($_SESSION['FilterAkhirTerima'])) $akhir_terima = $_SESSION['FilterAkhirTerima'];
            $status = 'transaksi_on';
            if (isset($_SESSION['StatusFilter'])) $status = $_SESSION['StatusFilter'];
            if($status == 'transaksi_on') {
                $tgl_condition = " WHERE P.[Tgl] BETWEEN '".date_to_str($tgl_transaksi)."' 
                                    AND '".date_to_str($akhir_transaksi). $end_day ."'";
            } else {
                $tgl_condition = " WHERE D.[TglTerima] BETWEEN '".date_to_str($tgl_terima)."' AND 
                                    '".date_to_str($akhir_terima). $end_day ."' ";
            }
            foreach($user_data as $key => $value) {
                // foreach($sales_data as $key_2 => $value_2) {
                    $filter[] = "
                    SELECT P.[NoTransaksi], P.[Tgl], P.[Nama], P.[Owner], S.[Nama] AS NamaSales,D.[Status], D.[TglTerima], D.[TglKirim], D.[NamaPicker]
                    FROM $value P LEFT JOIN $sales_data[$key] S ON P.SalesID = S.SalesID
                    LEFT JOIN [WMS].[dbo].[TB_Delivery] D 
                    ON P.NoTransaksi = D.NoTransaksi " . $tgl_condition . " AND
                    P.[Segmen] IN ($user_segmen) AND
                    P.[Status] = '1' AND
                    isnull(P.[NoTransaksiOriginal], '') = ''
                    ";
                    $filters = implode("UNION ALL", $filter);
                // }
            }
            $stmt = $conn->prepare($filters, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
            $stmt->execute();
            $total_record += $stmt->rowCount();
            $order_tgl = " ORDER BY [Status], [Tgl] DESC, [NoTransaksi] ";
            $query = "SELECT * FROM ($filters) temp" . $search_query . $order_tgl;
            $stmt = $pdo->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $urut++;
                    $transaksi = $row['NoTransaksi'];
                    $tglTransaksi = $row['Tgl'];
                    $nama = $row['Nama'];
                    $owner = $row['Owner'];
                    $status = $row['Status'];
                    $picker = $row['NamaPicker'];
                    $sales = $row['NamaSales'];
                    $customer = $owner == '' ? $nama : $nama . ' (' . $owner . ')';
                    $tglTerima = $row['TglTerima'];
                    $tglKirim = $row['TglKirim'];
                    $accept = $tglTerima == '' ? '' : ' ,' . $tglTerima;
                    $convert_tglTransaksi = date('d-m-Y', strtotime($tglTransaksi));
                    $checkbox = '<input type="checkbox" value="' . $transaksi .  " , "  . $convert_tglTransaksi . " , " . $customer . " , " . $status . " , " . $sales . $accept . '" id="checkbox_val" name="checkboxes[]" class="cp">';
                    $data[] = array(
                        $checkbox,
                        $transaksi,
                        $tglTransaksi,
                        $customer,
                        $status,
                        $tglTerima,
                        $picker,
                        $tglKirim
                    );
                }
                $pdo = null;
            }
            if(!empty($data)){
                $sort1 = $sort2 = $sort3 = $sort4 = $sort5 = $sort6 = $sort7 = array();
            }
            foreach($data as $key => $value) {
                $sort1[$key] = $value[1];
                $sort2[$key] = $value[2];
                $sort3[$key] = $value[3];
                $sort4[$key] = $value[4];
                $sort5[$key] = $value[5];
                $sort6[$key] = $value[6];
                $sort7[$key] = $value[7];
            }
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
                            default:
                                array_multisort($sort1, $dir, $data);
                                break;
                        }
                    }
                }
            }

            if(isset($_REQUEST['start']) && $_REQUEST['length'] != -1) {
                $data = array_slice($data, intval($_REQUEST['start']), intval($_REQUEST['length']));
            }

            // Datetime Formatting
            for ($i=0;$i<count($data);$i++) {
                $data[$i][2] = date('d-m-Y', strtotime($data[$i][2]));
                if (strtotime($data[$i][5]) != '') {
                    $data[$i][5] = date('d-m-Y H:i:s', strtotime($data[$i][5]));
                } else {
                    $data[$i][5] = '';
                } 
                if (strtotime($data[$i][7]) != ''){
                    $data[$i][7] = date('d-m-Y H:i:s', strtotime($data[$i][7]));
                } else {
                    $data[$i][7] = '';
                }
            }

            $result = array(
                'draw' => isset($_REQUEST['draw']) ? intval($_REQUEST['draw']): 0,
                'recordsTotal' => $total_record,
                'recordsFiltered' => $urut,
                'data' => $data,
                'query' => $query
            );

        }
        
    } catch (Exception $e) {
        $result = array(
            "draw" => isset($_REQUEST['draw']) ? intval($_REQUEST['draw']) : 0,
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => $data,
            "error" => $e->getMessage(),
            "error2" => $e->getLine()
        );
    }
    echo json_encode($result);
?>