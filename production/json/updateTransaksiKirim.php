<?php
    session_start();
    require_once '../../function.php';
    date_default_timezone_set('Asia/Jakarta');
    $res = [];
    try {
        if($_POST['NomorTransaksi'] != '') {
            if(isset($_POST['waktu_kirim'])) {
                $noTransaksi = $_POST['NomorTransaksi'];
                $arr = explode(' ; ', $noTransaksi);
                $tanggal_kirim = $_POST['waktu_kirim'] . ':00';
                // if(strlen($_POST['waktu_kirim']) < 5) {
                //     $waktu_kirim = '0' . $_POST['waktu_kirim'] . ':00';
                // } else {
                //     $waktu_kirim = $_POST['waktu_kirim'] . ':00';
                // }
                $tanggal_pengiriman = date_hour_to_str($tanggal_kirim);
                if($tanggal_pengiriman == false) {
                    $res['success'] = 0;
                    $res['message'] = 'Pastikan anda memasukkan format tanggal yang benar';
                    $res['tanggal'] = $tanggal_pengiriman;
                } 
                    else {
                    // $jam_kirim = date('H:i:s');
                    // $tanggal_pengiriman = $tgl_kirim . ' ' . $jam_kirim;
                    if(isset($_POST['select_pengiriman'])) {
                        $jenis_pengiriman = $_POST['select_pengiriman'];
                        switch($jenis_pengiriman) {
                            case 'Kirim Customer':
                                if(isset($_POST['wilayah_pengiriman'])) {
                                    $wilayah_pengiriman = $_POST['wilayah_pengiriman'];
                                    if($wilayah_pengiriman == 'Dalam Kota') {
                                        if(isset($_POST['nama_driver']) && isset($_POST['no_plat'])) {
                                            $driver = $_POST['nama_driver'];
                                            $plat = $_POST['no_plat'];
                                        } else {
                                            $res['success'] = 0;
                                            $res['message'] = 'Mohon ditentukan nama driver dan plat no mobil untuk pengiriman ini';
                                        }
                                    } else {
                                        if(isset($_POST['nama_ekspedisi'])) {
                                            $ekspedisi = $_POST['nama_ekspedisi'];
                                        } else {
                                            $res['success'] = 0;
                                            $res['message'] = 'Mohon tentukan nama ekspedisi untuk pengiriman ini';
                                        }
                                    }
                                }
                                break;
                            case 'Ambil Sendiri':
                                break;
                        }
                        $wilayah_pengiriman = $_POST['wilayah_pengiriman'];
                        $ekspedisi = $_POST['nama_ekspedisi'];
                        $driver = $_POST['nama_driver'];
                        $plat = $_POST['no_plat'];
                        foreach($arr as $val){
                            $array = explode(' , ', $val);
                            $idTransaksi = $array[0];
                            $Transaksi = $array[1];
                            $status = $array[4];
                            if($status == 1) {
                                $update_kirim = "UPDATE [WMS].[dbo].[TB_Delivery]
                                                    SET [Status] = 2,
                                                        [TglKirim] = '$tanggal_pengiriman',
                                                        [JenisPengiriman] = '$jenis_pengiriman',
                                                        [Wilayah] = '$wilayah_pengiriman',
                                                        [NamaEkspedisi] = '$ekspedisi',
                                                        [NamaDriver] = '$driver',
                                                        [NoPlat] = '$plat'
                                                    WHERE [NoTransaksi] = '$Transaksi' AND [IDTransaksi] = '$idTransaksi'
                                                ";
                                $stmt = $pdo->prepare($update_kirim, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                                $stmt->execute();
                                if($stmt->rowCount() > 0) {
                                    $res['success'] = 1;
                                    $res['kirim'] = $update_kirim;
                                    
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
                        $res['message'] = 'Mohon dipilih jenis pengiriman untuk no transaksi yang dikirim';
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
        $pdo = null;
    } catch (Exception $e) {
        $res['success'] = 0;
        $res['message'] = 'ada Error';
        $res['tanggal'] = $tanggal_pengiriman;
        $res['error'] = $e->getLine();
        $res['error_2'] = $e->getMessage();
    }
    echo json_encode($res);
?>