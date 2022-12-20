<?php

    require_once '../../function.php';

    $data = $result = array();

    try {

        if ($conn) {

            $urut = $total_record = 0;

            // $search_query = '';

            // $search = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';

            // if($search) {

            //     $search_query = "WHERE DriverID LIKE '%$search%' OR Nama LIKE '%$search%'";

            // }

            // get the TotalRecords

            $table = "SELECT * FROM [WMS-System].[dbo].[TB_Delivery]";
            
            $stmt = $conn->prepare($table, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);

            $stmt->execute();

            $total_record += $stmt->rowCount();

            
            // Fill the table with records
            
            // only add the search_query when you get the idea of what to search for

            // $query = $table . ' ' . $search_query;

            $query = $table;

            $stmt = $conn->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);

            $stmt->execute();

            if($stmt->rowCount() > 0) {

                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    $urut++;

                    $transaksi = $row['NoTransaksi'];

                    $status = $row['Status'];

                    $tglTerima = $row['TglTerima'];

                    $tglKirim = $row['TglKirim'];

                    $tglSelesai = $row['TglSelesai'];

                    $driver = $row['DriverID'];

                    $platDriver = $row['NoPlat'];

                    $custDriver = $row['DriverCust'];

                    $platCustomer = $row['PlatCust'];

                    $sales = $row['NamaSales'];

                    // comment this part because it's not needed yet

                    // $aksi = '<a href="#" data-bs-toggle="modal" data-bs-target="#masterModalEdit" 
                    
                    //            onclick="getDriver(\''.$nama.'\')" ><i class="fa fa-edit"></i></a>';

                    $data[] = array(

                        $urut,

                        $transaksi,

                        $status,

                        $tglTerima,

                        $tglKirim,

                        $tglSelesai,

                        $driver,

                        $platDriver,

                        $custDriver,

                        $platCustomer,

                        $sales

                    );

                }

            }

            $conn = null;

        }

        // Sorting Data 

        if(!empty($data)) {

            $sort1 = $sort2 = $sort3 = $sort4 = $sort5 = $sort6 = $sort7 = $sort8 = $sort9 = $sort10 = array();


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

                            default:

                                array_multisort($sort1, $dir, $data);

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
			$data[$i][3] = date('d-m-Y', strtotime($data[$i][3])); // Date formatting
		}

        $result = array(

            'draw' => isset($_REQUEST['draw']) ? intval($_REQUEST['draw']): 0,

            'recordsTotal' => $total_record,

            'recordsFiltered' => $urut,

            "data" => $data,

        );


    } catch (Exception $e) {

        $result = array(

            "draw" => isset($_REQUEST['draw']) ? intval($_REQUEST['draw']) : 0,

            "recordsTotal" => 0,

            "recordsFiltered" => 0,

            "data" => $data,

            "error" => $e -> getMessage(),

            "error2" => $e -> getLine(),

        );

    }

    echo json_encode($result);

    

?>
