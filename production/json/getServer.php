<?php

    require_once '../../function.php';

    if($_POST['warehouse']) {

        $res = [];

        $warehouse = $_POST['warehouse'];

        $query = "SELECT * FROM [WMS].[dbo].[TB_Server] 
                    
                  WHERE warehouse = :warehouse";

        $stmt = $conn->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);

        $stmt->bindParam(":warehouse", $warehouse, PDO::PARAM_STR);

        $stmt->execute();

        if($stmt->rowCount() > 0) {

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $data = array(

                    'id' => $row['id'],

                    'warehouse' => $row['warehouse'],

                    'aktif' => $row['aktif']

                );

            }

            $res['success'] = 1;

            $res['data'] = $data;

            $conn = null;

        } else {

            $res['success'] = 0;

            $res['message'] = "Gagal menampilkan data, mohon dicoba lagi";

        }

        echo json_encode($res);

    }

?>