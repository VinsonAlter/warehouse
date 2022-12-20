<?php

    require_once '../../function.php';

    $data = $result = array();

    try {

        if ($conn) {

            $urut = $total_record = 0;

            $search_query = '';

            $search = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';

            if($search) {

                $search_query = "WHERE NoPlat LIKE '%$search%' OR Jenis LIKE '%$search%'";

            }


            // get the TotalRecords

            $table = "SELECT [NoPlat],[Jenis],[Aktif] FROM [WMS-System].[dbo].[TB_Mobil]";
            
            $stmt = $conn->prepare($table, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);

            $stmt->execute();

            $total_record += $stmt->rowCount();

            
            // Fill the table with records

            $query = $table . ' ' . $search_query;

            $stmt = $conn->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);

            $stmt->execute();

            if($stmt->rowCount() > 0) {

                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    $urut++;

                    $plat = $row['NoPlat'];

                    $jenis = $row['Jenis'];

                    $aktif = $row['Aktif'];

                    $aksi = '<a href="#" data-bs-toggle="modal" data-bs-target="#masterModalEdit" 
                    
                               onclick="getMobil(\''.$plat.'\')" ><i class="fa fa-edit"></i></a>';

                    $data[] = array(

                        $urut,

                        $plat,

                        $jenis,

                        $aktif,

                        $aksi

                    );

                }

            }

            $conn = null;

        }

        // Sorting Data 

        if(!empty($data)) {

            $sort1 = $sort2 = array();


            // Multi Dimensional Sorting

            foreach($data as $key => $value) {

                $sort1[$key] = $value[1];

                $sort2[$key] = $value[2];

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
