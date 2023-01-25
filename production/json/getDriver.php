<?php

    require_once '../../function.php';

    if($_POST['nama']) {

        $res = [];

        $nama = $_POST['nama'];

        $query = "SELECT * FROM [WMS-System].[dbo].[TB_Driver] 
                    
                  WHERE NamaDriver = :nama";

        $stmt = $conn->prepare($query, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);

        $stmt->bindParam(":nama", $nama, PDO::PARAM_STR);

        $stmt->execute();

        if($stmt->rowCount() > 0) {

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $data = array(

                    'kode' => $row['DriverID'],

                    'nama' => $row['NamaDriver'],

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