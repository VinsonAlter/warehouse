<?php

    require_once '../../function.php';

    if($_POST['plat']) {

        $res = [];

        $plat = $_POST['plat'];

        $query = "SELECT * FROM [WMS].[dbo].[TB_Mobil] 
                    
                  WHERE NoPlat = :plat";

        $stmt = $conn->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);

        $stmt->bindParam(":plat", $plat, PDO::PARAM_STR);

        $stmt->execute();

        if($stmt->rowCount() > 0) {

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $data = array(

                    'plat' => $row['NoPlat'],

                    'jenis' => $row['Jenis'],

                    'aktif' => $row['Aktif']

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