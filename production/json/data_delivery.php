<?php
    session_start();
    require_once '../../function.php';
    $data = $result = array();
    try {
        if ($conn) {
            $urut = $total_record = 0;
            $search_query = '';
            $search = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';
            $table = '';
            if($search) {
                $search_query = "AND NoTransaksi LIKE '%$search%' 
                                    OR Status LIKE '%$search%'
                                    OR Nama LIKE '%$search%'
                                    OR NamaDriver LIKE '%$search%'
                                    OR NamaPicker LIKE '%$search%'
                                    OR TglTransaksi LIKE '%$search%'
                                    OR TglTerima LIKE '%$search%'
                                    OR TglKirim LIKE '%$search%'
                                    OR NoPlat LIKE '%$search%'
                                    OR PlatCust LIKE '%$search%'
                                    OR DriverCust LIKE '%$search%'
                                    OR NamaSales LIKE '%$search%'
                                    OR Cabang LIKE '%$search%'";
            }
            $start_date = date('01-m-Y');
            $end_date = date('d-m-Y');
            $status_tanggal = '';
            $order_tanggal = '';
            if (isset($_SESSION['FilterStatusFrom'])) $start_date = $_SESSION['FilterStatusFrom'];
  	        if (isset($_SESSION['FilterStatusTo'])) $end_date = $_SESSION['FilterStatusTo'];
            // $status = isset($_SESSION['FilterStatus']) ? $_SESSION['FilterStatus'] : '';
            // switch($status) {
            //     case 'Diterima':
            //         $status_tanggal = "WHERE Status = 'Diterima' AND TglTerima BETWEEN '" .date_to_str($start_date)."' AND '" .date_to_str($end_date)."'";
            //         $order_tanggal = "ORDER BY TglTerima ASC";
            //         break;
            //     case 'Dikirim':
            //         $status_tanggal = "WHERE Status = 'Dikirim' AND TglKirim BETWEEN '" .date_to_str($start_date)."' AND '" .date_to_str($end_date)."'";
            //         $order_tanggal = "ORDER BY TglKirim ASC";
            //         break;
            //     case 'Selesai':
            //         $status_tanggal = "WHERE Status = 'Selesai' AND TglSelesai BETWEEN '" .date_to_str($start_date)."' AND '" .date_to_str($end_date)."'";
            //         $order_tanggal = "ORDER BY TglSelesai ASC";
            //         break;
            //     default:
            //         $status_tanggal = "WHERE TglTerima BETWEEN '" .date_to_str($start_date)."' AND '" .date_to_str($end_date)."'";
            //         $order_tanggal = "ORDER BY TglTerima ASC";
            // }

            // if($status == 'Diterima') {

            //     $status_tanggal = "WHERE Status = 'Diterima' AND TglTerima BETWEEN '" .date_to_str($start_date)."' AND '" .date_to_str($end_date)."'";

            //     $order_tanggal = "ORDER BY TglTerima ASC";

            // } else if($status == 'Dikirim') {

            //     $status_tanggal = "WHERE Status = 'Dikirim' AND TglKirim BETWEEN '" .date_to_str($start_date)."' AND '" .date_to_str($end_date)."'";

            //     $order_tanggal = "ORDER BY TglKirim ASC";
            
            // } else if($status == 'Selesai') {

            //     $status_tanggal = "WHERE Status = 'Selesai' AND TglSelesai BETWEEN '" .date_to_str($start_date)."' AND '" .date_to_str($end_date)."'";

            //     $order_tanggal = "ORDER BY TglSelesai ASC";                    
                
            // } else {

            //     $status_tanggal = "WHERE TglTerima BETWEEN '" .date_to_str($start_date)."' AND '" .date_to_str($end_date)."'";

            //     $order_tanggal = "ORDER BY TglTerima ASC";
            // }   
            
            // get the TotalRecords

            $table = "SELECT [NoTransaksi]
                            ,[Status]
                            ,[Customer]
                            ,[NamaDriver]
                            ,[NamaPicker]
                            ,[TglTransaksi]
                            ,[TglTerima]
                            ,[TglKirim]
                            ,[TglSelesai]
                            ,[Wilayah]
                            ,[JenisPengiriman]
                            ,[NamaEkspedisi]
                            ,[NoPlat]
                            ,[NamaSales]
                            ,[Cabang]
                        FROM [WMS-System].[dbo].[TB_Delivery]";
        }

        $stmt = $conn->prepare($table, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
        $stmt->execute();
        $total_record += $stmt->rowCount();

        // Fill the table with records
            
        // only add the search_query when you get the idea of what to search for
        $query = "SELECT * FROM (".$table . ' ' . $status_tanggal . $search_query.") temp" . ' ' . $order_tanggal;
        $stmt = $conn->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
        $stmt->execute();
        if($stmt->rowCount() > 0) {
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $urut++;
                $transaksi = $row['NoTransaksi'];
                $nama = $row['Customer'];
                $status = $row['Status'];
                $tglTransaksi = $row['TglTransaksi'];
                $tglTerima = $row['TglTerima'];
                $tglKirim = $row['TglKirim'];
                $tglSelesai = $row['TglSelesai'];
                $wilayah = $row['Wilayah'];
                $ekspedisi = $row['NamaEkspedisi'];
                $namaPicker = $row['NamaPicker'];
                $namaDriver = $row['NamaDriver'];
                $platDriver = $row['NoPlat'];
                $wilayah = $row['Wilayah'];
                $sales = $row['NamaSales'];
                // comment this part because it's not needed yet
                $aksi = '<a href="#" data-bs-toggle="modal" data-bs-target="#masterModalEdit" 
                    onclick="getDelivery(\''.$transaksi.'\')"><i class="fa fa-edit"></i></a>';
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
                    $wilayah,
                    $ekspedisi,
                    $namaDriver,
                    $platDriver,
                    $sales,
                    $aksi
                );
            }
            $conn = null;
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
                $data[$i][4] = date('d-m-Y', strtotime($data[$i][4]));
            } else {
                $data[$i][4] = '';
            } 

            if (strtotime($data[$i][5]) != '') {
                $data[$i][5] = date('d-m-Y', strtotime($data[$i][5]));
            } else {
                $data[$i][5] = '';
            } 

            if (strtotime($data[$i][7]) != '') {
                $data[$i][7] = date('d-m-Y', strtotime($data[$i][7]));
            } else {
                $data[$i][7] = '';
            } 

            if (strtotime($data[$i][8]) != '') {
                $data[$i][8] = date('d-m-Y', strtotime($data[$i][8]));
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
            "query" => $query,
            "error" => $e -> getMessage(),
            "error2" => $e -> getLine(),
        );
    }

    echo json_encode($result);
?>
