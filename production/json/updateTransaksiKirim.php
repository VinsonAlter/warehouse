<?php
    session_start();
    require_once '../../function.php';
    date_default_timezone_set('Asia/Jakarta');
    $res = [];
    try {
        if($_POST['NomorTransaksi'] != '') {
            if(isset($_POST['tanggal_kirim']) && isset($_POST['select_pengiriman'])
                && isset($_POST['wilayah_pengiriman']) && isset($_POST['nama_ekspedisi'])
                && isset($_POST['nama_driver']) && isset($_POST['no_plate'])) {
                $noTransaksi = $_POST['NomorTransaksi'];
                $arr = explode(' ; ', $noTransaksi);
                $tanggal_kirim = $_POST['tanggal_kirim'];
                $tgl_kirim = date_to_str($tanggal_kirim);
                $jam_kirim = hour_to_str(date('H:i:s'));
                // $jam_kirim = date('H:i:s');
                $waktu_kirim = $tgl_kirim . ' ' . $jam_kirim;
                $jenis_pengiriman = $_POST['select_pengiriman'];
                $wilayah_pengiriman = $_POST['wilayah_pengiriman'];
                $ekspedisi = $_POST['nama_ekspedisi'];
                $driver = $_POST['nama_driver'];
                $plat = $_POST['no_plat'];
                foreach($arr as $val){
                    $array = explode(' , ', $val);
                    $Transaksi = $array[0];
                    $status = $array[3];
                    if($status == 1) {
                        $update_kirim = "UPDATE [WMS].[dbo].[TB_Delivery]
                                            SET [Status] = 2,
                                                [TglKirim] = '$waktu_kirim',
                                                [JenisPengiriman] = '$jenis_pengiriman',
                                                [Wilayah] = '$wilayah_pengiriman',
                                                [NamaEkspedisi] = '$ekspedisi',
                                                [NamaDriver] = '$driver',
                                                [NoPlat] = '$plat'
                                            WHERE [NoTransaksi] = '$Transaksi'
                                        ";
                        $stmt = $pdo->prepare($update_kirim, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                        $stmt->execute();
                        if($stmt->rowCount() > 0) {
                            $res['success'] = 1;
                            $res['kirim'] = $update_kirim;
                            $res['jam'] = $jam_kirim;
                            $res['message'] = 'Status transaksi berhasil diupdate!';
                        } else {
                            $res['success'] = 0;
                            $res['message'] = 'Status transaksi gagal diupdate, mohon periksa koneksi anda!';
                        }
                    } else {
                        $res['success'] = 0;
                        $res['message'] = 'No Transaksi yang dipilih masih belum diterima!';
                    }
                }        
            } else {
                $res['success'] = 0;
            $res['message'] = 'Mohon pastikan semua kolom sudah diisi dengan lengkap!';
            }
        } else {
            $res['success'] = 0;
            $res['message'] = 'Mohon pastikan Anda sudah checklist nomor Transaksi yang hendak dikirim!';
        }
    } catch (Exception $e) {
        $res['success'] = 0;
        $res['message'] = 'ada Error';
        $res['error'] = $e->getLine();
        $res['error_2'] = $e->getMessage();
    }
    echo json_encode($res);
?>