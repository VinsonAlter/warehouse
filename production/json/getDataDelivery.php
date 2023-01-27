<?php
    session_start();
    require_once '../../function.php';
    $data = $result = array();
    $user_data = $_SESSION['user_server'];
    try {
        if($pdo) {
            $tgl_condition = '';
            $urut = $total_record = 0;
            $tgl_transaksi = isset($_SESSION['FilterTanggalTransaksi']) ? $_SESSION['FilterTanggalTransaksi'] : date('d-m-Y');
            $tgl_terima = isset($_SESSION['FilterTanggalTerima']) ? $_SESSION['FilterTanggalTerima'] : '';
            if($tgl_terima != '') {
                $tgl_condition = " WHERE P.[Tgl] = '".date_to_str($tgl_transaksi)."' ";
            } else {
                $tgl_condition = " WHERE D.[TglTerima] = '".date_to_str($tgl_terima)."' ";
            }
            foreach($user_data as $key => $value) {
                $filter[] = "
                    SELECT P.[NoTransaksi], P.[Tgl], P.[Nama], P.[Owner], D.[Status], D.[TglTerima]
                    FROM $value P 
                    LEFT JOIN [WMS-System].[dbo].[TB_Delivery] D 
                    ON P.NoTransaksi = D.NoTransaksi " . $tgl_condition . " AND
                    P.[Segmen] IN ($user_segmen) AND
                    P.[Status] = '1' AND
                    isnull(P.[NoTransaksiOriginal], '') = ''
                ";
                $filters = implode("UNION ALL", $filter);
            }
            $order_tgl = " ORDER BY [Tgl] DESC, [Status], [NoTransaksi] ";
            $query = "SELECT * FROM ($filters) temp" . $order_tgl;
            $stmt = $pdo->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
            $stmt->execute();
            $total_record += $stmt->rowCount();
            if($stmt->rowCount() > 0) {
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $urut++;
                    $transaksi = $row['NoTransaksi'];
                    $tglTransaksi = $row['Tgl'];
                    $nama = $row['Nama'];
                    $owner = $row['Owner'];
                    $status = $row['Status'];
                    $tglTerima = $row['TglTerima'];

                    $data[] = array(
                        $urut,
                        $transaksi,
                        $tglTransaksi,
                        $nama,
                        $owner,
                        $status,
                        $tglTerima
                    );
                }
                $pdo = null;
            }
            if(!empty($data)){
                $sort1 = $sort2 = $sort3 = $sort4 = $sort5 = $sort6 = array();
            }
            foreach($data as $key => $value) {
                $sort1[$key] = $value[1];
                $sort2[$key] = $value[2];
                $sort3[$key] = $value[3];
                $sort4[$key] = $value[4];
                $sort5[$key] = $value[5];
                $sort6[$key] = $value[6];
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
                            case 4:
                                array_multisort($sort4, $dir, $data);
                            case 5:
                                array_multisort($sort5, $dir, $data);
                            case 6:
                                array_multisort($sort6, $dir, $data);
                            default:
                                array_multisort($sort1, $dir, $data);
                        }
                    }
                }
            }

            if(isset($_REQUEST['start']) && $_REQUEST['length'] != -1) {
                $data = array_slice($data, intval($_REQUEST['start']), intval($_REQUEST['length']));
            }

            // Datetime Formatting
            for ($i=0;$i<count($data);$i++) {
                $data[$i][3] = strtotime('d-m-Y', $data[$i][3]);
                if (strtotime($data[$i][6]) != '') {
                    $data[$i][6] = date('d-m-Y', strtotime($data[$i][6]));
                } else {
                    $data[$i][6] = '';
                } 
            }

            $result = array(
                'draw' => isset($_REQUEST['draw']) ? intval($_REQUEST['draw']): 0,
                'recordsTotal' => $total_record,
                'recordsFiltered' => $urut,
                "data" => $data
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