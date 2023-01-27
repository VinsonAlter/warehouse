<?php
    session_start();
    require_once '../../function.php';
    $data = $result = array();
    $user_data = $_SESSION['user_server'];
    try {
        if($pdo) {
            $urut = $total_record = 0;
            $tgl_transaksi = isset($_SESSION['FilterTanggalTransaksi']) ? $_SESSION['FilterTanggalTransaksi'] : date('d-m-Y');
            $tgl_terima = isset($_SESSION['FilterTanggalTerima']) ? $_SESSION['FilterTanggalTerima'] : '';
            foreach($user_data as $key => $value) {

                $table[] = "

                    SELECT P.[NoTransaksi], P.[Tgl], P.[Nama], P.[Owner], D.[Status], D.[TglTerima]
                    
                    FROM $value P 

                    LEFT JOIN [WMS-System].[dbo].[TB_Delivery] D 
                    
                    ON P.NoTransaksi = D.NoTransaksi 

                    WHERE D.NoTransaksi IS NULL
    
                    AND [Tgl] BETWEEN 

                    '".date_to_str($awalTanggal)."' AND  

                    '".date_to_str($akhirTanggal)."' AND

                    P.[Segmen] IN ($user_segmen) AND

                    P.[Status] = '1' AND

                    isnull(P.[NoTransaksiOriginal], '') = ''
                ";
            }
        }
    } catch (Exception $e) {

    }
?>