<?php
    session_start();
    require_once '../../function.php';
    date_default_timezone_set('Asia/Jakarta');
    $res = [];
    $noTransaksi = $_POST['no_transaksi'];
    $status = $_POST['select_status'];
    $jadwalTerima = date_hour_to_str($_POST['tanggal_terima'] . ':00');
    if(isset($_POST['tanggal_terima'])) {
        $check = "SELECT * FROM [WMS].[dbo].[TB_Delivery]
                         WHERE NoTransaksi = :noTransaksi";
        $stmt = $pdo->prepare($check, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
        $stmt->bindParam(":noTransaksi", $noTransaksi, PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->rowCount() > 0) {
            $picker = $_POST['select_picker'];
            switch($status) {
                case 2:
                    if(isset($_POST['tanggal_kirim'])) {
                        $jadwalKirim = date_hour_to_str($_POST['tanggal_kirim'] . ':00');
                        if($jadwalKirim >= $jadwalTerima) {
                            $jenisPengiriman = $_POST['select_pengiriman'];
                            if(isset($_POST['wilayah_pengiriman'])) {
                                $wilayahPengiriman = $_POST['wilayah_pengiriman'];
                                switch($jenisPengiriman) {
                                    case 'Kirim Customer':
                                        if($wilayahPengiriman == 'Dalam Kota') {
                                            if($_POST['nama_driver'] != '' && $_POST['no_plat'] != '') {
                                                $driver = $_POST['nama_driver'];
                                                $plat = $_POST['no_plat'];
                                                $ekspedisi = '';
                                                $update = "UPDATE [WMS].[dbo].[TB_Delivery] SET
                                                Status = :status, TglTerima = :terima, NamaPicker = :picker,
                                                TglKirim = :kirim, TglSelesai = :selesai, JenisPengiriman = :pengiriman,
                                                Wilayah = :wilayah, NamaEkspedisi = :ekspedisi,
                                                NamaDriver = :driver, NoPlat = :plat
                                                WHERE NoTransaksi = :transaksi";
                                                $stmt2 = $pdo->prepare($update, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                                                $stmt2->bindParam(":status", $status, PDO::PARAM_INT);
                                                $stmt2->bindParam(":terima", $jadwalTerima, PDO::PARAM_STR);
                                                $stmt2->bindParam(":picker", $picker, PDO::PARAM_STR);
                                                $stmt2->bindParam(":kirim", $jadwalKirim, PDO::PARAM_STR);
                                                $stmt2->bindParam(":selesai", $jadwalSelesai, PDO::PARAM_STR);
                                                $stmt2->bindParam(":pengiriman", $jenisPengiriman, PDO::PARAM_STR);
                                                $stmt2->bindParam(":wilayah", $wilayahPengiriman, PDO::PARAM_STR);
                                                $stmt2->bindParam(":ekspedisi", $ekspedisi, PDO::PARAM_STR);
                                                $stmt2->bindParam(":driver", $driver, PDO::PARAM_STR);
                                                $stmt2->bindParam(":plat", $plat, PDO::PARAM_STR);
                                                $stmt2->bindParam(":transaksi", $noTransaksi, PDO::PARAM_STR);
                                                $stmt2->execute();
                                                if($stmt2->rowCount() > 0) {
                                                    $res['success'] = 1;
                                                    $res['message'] = 'Status Transaksi Berhasil Diganti!';
                                                    // var_dump($jadwalKirim);
                                                    // var_dump($jadwalSelesai);
                                                } else {
                                                    $res['success'] = 0;
                                                    $res['message'] = 'Status Transaksi gagal diganti, mohon periksa koneksi anda!';
                                                }
                                            } else {
                                                $res['success'] = 0;
                                                $res['message'] = 'Mohon tentukan nama driver & no plat untuk transaksi ini';
                                            }
                                        } else {
                                            if($_POST['nama_ekspedisi'] != '') {
                                                $ekspedisi = $_POST['nama_ekspedisi'];
                                                $driver = '';
                                                $plat = '';
                                                $update = "UPDATE [WMS].[dbo].[TB_Delivery] SET
                                                Status = :status, TglTerima = :terima, NamaPicker = :picker,
                                                TglKirim = :kirim, TglSelesai = :selesai, JenisPengiriman = :pengiriman,
                                                Wilayah = :wilayah, NamaEkspedisi = :ekspedisi,
                                                NamaDriver = :driver, NoPlat = :plat
                                                WHERE NoTransaksi = :transaksi";
                                                $stmt2 = $pdo->prepare($update, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                                                $stmt2->bindParam(":status", $status, PDO::PARAM_INT);
                                                $stmt2->bindParam(":terima", $jadwalTerima, PDO::PARAM_STR);
                                                $stmt2->bindParam(":picker", $picker, PDO::PARAM_STR);
                                                $stmt2->bindParam(":kirim", $jadwalKirim, PDO::PARAM_STR);
                                                $stmt2->bindParam(":selesai", $jadwalSelesai, PDO::PARAM_STR);
                                                $stmt2->bindParam(":pengiriman", $jenisPengiriman, PDO::PARAM_STR);
                                                $stmt2->bindParam(":wilayah", $wilayahPengiriman, PDO::PARAM_STR);
                                                $stmt2->bindParam(":ekspedisi", $ekspedisi, PDO::PARAM_STR);
                                                $stmt2->bindParam(":driver", $driver, PDO::PARAM_STR);
                                                $stmt2->bindParam(":plat", $plat, PDO::PARAM_STR);
                                                $stmt2->bindParam(":transaksi", $noTransaksi, PDO::PARAM_STR);
                                                $stmt2->execute();
                                                if($stmt2->rowCount() > 0) {
                                                    $res['success'] = 1;
                                                    $res['message'] = 'Status Transaksi Berhasil Diganti!';
                                                    // var_dump($jadwalKirim);
                                                    // var_dump($jadwalSelesai);
                                                } else {
                                                    $res['success'] = 0;
                                                    $res['message'] = 'Status Transaksi gagal diganti, mohon periksa koneksi anda!';
                                                }
                                            } else {
                                                $res['success'] = 0;
                                                $res['message'] = 'Mohon tentukan nama ekspedisi untuk transaksi ini';
                                            }
                                        }
                                        break;
                                    case 'Ambil Sendiri':
                                        $driver = $_POST['nama_driver'];
                                        $plat = $_POST['no_plat'];
                                        $ekspedisi = $_POST['nama_ekspedisi'];
                                        $wilayahPengiriman = '';
                                        $update = "UPDATE [WMS].[dbo].[TB_Delivery] SET
                                                Status = :status, TglTerima = :terima, NamaPicker = :picker,
                                                TglKirim = :kirim, TglSelesai = :selesai, JenisPengiriman = :pengiriman,
                                                Wilayah = :wilayah, NamaEkspedisi = :ekspedisi,
                                                NamaDriver = :driver, NoPlat = :plat
                                                WHERE NoTransaksi = :transaksi";
                                        $stmt2 = $pdo->prepare($update, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                                        $stmt2->bindParam(":status", $status, PDO::PARAM_INT);
                                        $stmt2->bindParam(":terima", $jadwalTerima, PDO::PARAM_STR);
                                        $stmt2->bindParam(":picker", $picker, PDO::PARAM_STR);
                                        $stmt2->bindParam(":kirim", $jadwalKirim, PDO::PARAM_STR);
                                        $stmt2->bindParam(":selesai", $jadwalSelesai, PDO::PARAM_STR);
                                        $stmt2->bindParam(":pengiriman", $jenisPengiriman, PDO::PARAM_STR);
                                        $stmt2->bindParam(":wilayah", $wilayahPengiriman, PDO::PARAM_STR);
                                        $stmt2->bindParam(":ekspedisi", $ekspedisi, PDO::PARAM_STR);
                                        $stmt2->bindParam(":driver", $driver, PDO::PARAM_STR);
                                        $stmt2->bindParam(":plat", $plat, PDO::PARAM_STR);
                                        $stmt2->bindParam(":transaksi", $noTransaksi, PDO::PARAM_STR);
                                        $stmt2->execute();
                                        if($stmt2->rowCount() > 0) {
                                            $res['success'] = 1;
                                            $res['message'] = 'Status Transaksi Berhasil Diganti!';
                                        } else {
                                            $res['success'] = 0;
                                            $res['message'] = 'Status Transaksi gagal diganti, mohon periksa koneksi anda!';
                                        }
                                        break;
                                    default:
                                        $driver = $_POST['nama_driver'];
                                        $plat = $_POST['no_plat'];
                                        $ekspedisi = $_POST['nama_ekspedisi'];
                                        $wilayahPengiriman = '';
                                        $update = "UPDATE [WMS].[dbo].[TB_Delivery] SET
                                                Status = :status, TglTerima = :terima, NamaPicker = :picker,
                                                TglKirim = :kirim, TglSelesai = :selesai, JenisPengiriman = :pengiriman,
                                                Wilayah = :wilayah, NamaEkspedisi = :ekspedisi,
                                                NamaDriver = :driver, NoPlat = :plat
                                                WHERE NoTransaksi = :transaksi";
                                        $stmt2 = $pdo->prepare($update, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                                        $stmt2->bindParam(":status", $status, PDO::PARAM_INT);
                                        $stmt2->bindParam(":terima", $jadwalTerima, PDO::PARAM_STR);
                                        $stmt2->bindParam(":picker", $picker, PDO::PARAM_STR);
                                        $stmt2->bindParam(":kirim", $jadwalKirim, PDO::PARAM_STR);
                                        $stmt2->bindParam(":selesai", $jadwalSelesai, PDO::PARAM_STR);
                                        $stmt2->bindParam(":pengiriman", $jenisPengiriman, PDO::PARAM_STR);
                                        $stmt2->bindParam(":wilayah", $wilayahPengiriman, PDO::PARAM_STR);
                                        $stmt2->bindParam(":ekspedisi", $ekspedisi, PDO::PARAM_STR);
                                        $stmt2->bindParam(":driver", $driver, PDO::PARAM_STR);
                                        $stmt2->bindParam(":plat", $plat, PDO::PARAM_STR);
                                        $stmt2->bindParam(":transaksi", $noTransaksi, PDO::PARAM_STR);
                                        $stmt2->execute();
                                        if($stmt2->rowCount() > 0) {
                                            $res['success'] = 1;
                                            $res['message'] = 'Status Transaksi Berhasil Diganti!';
                                        } else {
                                            $res['success'] = 0;
                                            $res['message'] = 'Status Transaksi gagal diganti, mohon periksa koneksi anda!';
                                        }
                                        break;
                                }
                            } else {
                                $res['success'] = 0;
                                $res['message'] = 'Mohon tentukan jenis lokasi pengiriman barang yang hendak dikirim';
                            }
                        } else {
                            $res['success'] = 0;
                            $res['message'] = 'Jadwal Pengiriman tidak boleh ditentukan sebelum Jadwal Penerimaan Transaksi';
                        }
                        break;
                    }
                case 3:
                    if(isset($_POST['tanggal_kirim']) && isset($_POST['tanggal_selesai'])) {
                        $jadwalKirim = date_hour_to_str($_POST['tanggal_kirim'] . ':00');
                        $jadwalSelesai = date_hour_to_str($_POST['tanggal_selesai'] . ':00');
                        if($jadwalKirim >= $jadwalTerima) {
                            if($jadwalSelesai >= $jadwalKirim && $jadwalSelesai > $jadwalTerima) {
                                $jenisPengiriman = $_POST['select_pengiriman'];
                                $wilayahPengiriman = $_POST['wilayah_pengiriman'];
                                switch($jenisPengiriman) {
                                    case 'Kirim Customer':
                                        if($wilayahPengiriman == 'Dalam Kota') {
                                            if($_POST['nama_driver'] != '' && $_POST['no_plat'] != '') {
                                                $driver = $_POST['nama_driver'];
                                                $plat = $_POST['no_plat'];
                                                $ekspedisi = '';
                                                $update = "UPDATE [WMS].[dbo].[TB_Delivery] SET
                                                Status = :status, TglTerima = :terima, NamaPicker = :picker,
                                                TglKirim = :kirim, TglSelesai = :selesai, JenisPengiriman = :pengiriman,
                                                Wilayah = :wilayah, NamaEkspedisi = :ekspedisi,
                                                NamaDriver = :driver, NoPlat = :plat
                                                WHERE NoTransaksi = :transaksi";
                                                $stmt2 = $pdo->prepare($update, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                                                $stmt2->bindParam(":status", $status, PDO::PARAM_INT);
                                                $stmt2->bindParam(":terima", $jadwalTerima, PDO::PARAM_STR);
                                                $stmt2->bindParam(":picker", $picker, PDO::PARAM_STR);
                                                $stmt2->bindParam(":kirim", $jadwalKirim, PDO::PARAM_STR);
                                                $stmt2->bindParam(":selesai", $jadwalSelesai, PDO::PARAM_STR);
                                                $stmt2->bindParam(":pengiriman", $jenisPengiriman, PDO::PARAM_STR);
                                                $stmt2->bindParam(":wilayah", $wilayahPengiriman, PDO::PARAM_STR);
                                                $stmt2->bindParam(":ekspedisi", $ekspedisi, PDO::PARAM_STR);
                                                $stmt2->bindParam(":driver", $driver, PDO::PARAM_STR);
                                                $stmt2->bindParam(":plat", $plat, PDO::PARAM_STR);
                                                $stmt2->bindParam(":transaksi", $noTransaksi, PDO::PARAM_STR);
                                                $stmt2->execute();
                                                if($stmt2->rowCount() > 0) {
                                                    $res['success'] = 1;
                                                    $res['message'] = 'Status Transaksi Berhasil Diganti!';
                                                    // var_dump($jadwalKirim);
                                                    // var_dump($jadwalSelesai);
                                                } else {
                                                    $res['success'] = 0;
                                                    $res['message'] = 'Status Transaksi gagal diganti, mohon periksa koneksi anda!';
                                                }
                                            } else {
                                                $res['success'] = 0;
                                                $res['message'] = 'Mohon tentukan nama driver & no plat untuk transaksi ini';
                                            }
                                        } else {
                                            if($_POST['nama_ekspedisi'] != '') {
                                                $ekspedisi = $_POST['nama_ekspedisi'];
                                                $driver = '';
                                                $plat = '';
                                                $update = "UPDATE [WMS].[dbo].[TB_Delivery] SET
                                                Status = :status, TglTerima = :terima, NamaPicker = :picker,
                                                TglKirim = :kirim, TglSelesai = :selesai, JenisPengiriman = :pengiriman,
                                                Wilayah = :wilayah, NamaEkspedisi = :ekspedisi,
                                                NamaDriver = :driver, NoPlat = :plat
                                                WHERE NoTransaksi = :transaksi";
                                                $stmt2 = $pdo->prepare($update, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                                                $stmt2->bindParam(":status", $status, PDO::PARAM_INT);
                                                $stmt2->bindParam(":terima", $jadwalTerima, PDO::PARAM_STR);
                                                $stmt2->bindParam(":picker", $picker, PDO::PARAM_STR);
                                                $stmt2->bindParam(":kirim", $jadwalKirim, PDO::PARAM_STR);
                                                $stmt2->bindParam(":selesai", $jadwalSelesai, PDO::PARAM_STR);
                                                $stmt2->bindParam(":pengiriman", $jenisPengiriman, PDO::PARAM_STR);
                                                $stmt2->bindParam(":wilayah", $wilayahPengiriman, PDO::PARAM_STR);
                                                $stmt2->bindParam(":ekspedisi", $ekspedisi, PDO::PARAM_STR);
                                                $stmt2->bindParam(":driver", $driver, PDO::PARAM_STR);
                                                $stmt2->bindParam(":plat", $plat, PDO::PARAM_STR);
                                                $stmt2->bindParam(":transaksi", $noTransaksi, PDO::PARAM_STR);
                                                $stmt2->execute();
                                                if($stmt2->rowCount() > 0) {
                                                    $res['success'] = 1;
                                                    $res['message'] = 'Status Transaksi Berhasil Diganti!';
                                                    // var_dump($jadwalKirim);
                                                    // var_dump($jadwalSelesai);
                                                } else {
                                                    $res['success'] = 0;
                                                    $res['message'] = 'Status Transaksi gagal diganti, mohon periksa koneksi anda!';
                                                }
                                            } else {
                                                $res['success'] = 0;
                                                $res['message'] = 'Mohon tentukan nama ekspedisi untuk transaksi ini';
                                            }
                                        }
                                        break;
                                    case 'Ambil Sendiri':
                                        $driver = $_POST['nama_driver'];
                                        $plat = $_POST['no_plat'];
                                        $ekspedisi = $_POST['nama_ekspedisi'];
                                        $wilayahPengiriman = '';
                                        $update = "UPDATE [WMS].[dbo].[TB_Delivery] SET
                                                Status = :status, TglTerima = :terima, NamaPicker = :picker,
                                                TglKirim = :kirim, TglSelesai = :selesai, JenisPengiriman = :pengiriman,
                                                Wilayah = :wilayah, NamaEkspedisi = :ekspedisi,
                                                NamaDriver = :driver, NoPlat = :plat
                                                WHERE NoTransaksi = :transaksi";
                                        $stmt2 = $pdo->prepare($update, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                                        $stmt2->bindParam(":status", $status, PDO::PARAM_INT);
                                        $stmt2->bindParam(":terima", $jadwalTerima, PDO::PARAM_STR);
                                        $stmt2->bindParam(":picker", $picker, PDO::PARAM_STR);
                                        $stmt2->bindParam(":kirim", $jadwalKirim, PDO::PARAM_STR);
                                        $stmt2->bindParam(":selesai", $jadwalSelesai, PDO::PARAM_STR);
                                        $stmt2->bindParam(":pengiriman", $jenisPengiriman, PDO::PARAM_STR);
                                        $stmt2->bindParam(":wilayah", $wilayahPengiriman, PDO::PARAM_STR);
                                        $stmt2->bindParam(":ekspedisi", $ekspedisi, PDO::PARAM_STR);
                                        $stmt2->bindParam(":driver", $driver, PDO::PARAM_STR);
                                        $stmt2->bindParam(":plat", $plat, PDO::PARAM_STR);
                                        $stmt2->bindParam(":transaksi", $noTransaksi, PDO::PARAM_STR);
                                        $stmt2->execute();
                                        if($stmt2->rowCount() > 0) {
                                            $res['success'] = 1;
                                            $res['message'] = 'Status Transaksi Berhasil Diganti!';
                                        } else {
                                            $res['success'] = 0;
                                            $res['message'] = 'Status Transaksi gagal diganti, mohon periksa koneksi anda!';
                                        }
                                        break;
                                    default:
                                        $driver = $_POST['nama_driver'];
                                        $plat = $_POST['no_plat'];
                                        $ekspedisi = $_POST['nama_ekspedisi'];
                                        $wilayahPengiriman = '';
                                        $update = "UPDATE [WMS].[dbo].[TB_Delivery] SET
                                                Status = :status, TglTerima = :terima, NamaPicker = :picker,
                                                TglKirim = :kirim, TglSelesai = :selesai, JenisPengiriman = :pengiriman,
                                                Wilayah = :wilayah, NamaEkspedisi = :ekspedisi,
                                                NamaDriver = :driver, NoPlat = :plat
                                                WHERE NoTransaksi = :transaksi";
                                        $stmt2 = $pdo->prepare($update, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                                        $stmt2->bindParam(":status", $status, PDO::PARAM_INT);
                                        $stmt2->bindParam(":terima", $jadwalTerima, PDO::PARAM_STR);
                                        $stmt2->bindParam(":picker", $picker, PDO::PARAM_STR);
                                        $stmt2->bindParam(":kirim", $jadwalKirim, PDO::PARAM_STR);
                                        $stmt2->bindParam(":selesai", $jadwalSelesai, PDO::PARAM_STR);
                                        $stmt2->bindParam(":pengiriman", $jenisPengiriman, PDO::PARAM_STR);
                                        $stmt2->bindParam(":wilayah", $wilayahPengiriman, PDO::PARAM_STR);
                                        $stmt2->bindParam(":ekspedisi", $ekspedisi, PDO::PARAM_STR);
                                        $stmt2->bindParam(":driver", $driver, PDO::PARAM_STR);
                                        $stmt2->bindParam(":plat", $plat, PDO::PARAM_STR);
                                        $stmt2->bindParam(":transaksi", $noTransaksi, PDO::PARAM_STR);
                                        $stmt2->execute();
                                        if($stmt2->rowCount() > 0) {
                                            $res['success'] = 1;
                                            $res['message'] = 'Status Transaksi Berhasil Diganti!';
                                        } else {
                                            $res['success'] = 0;
                                            $res['message'] = 'Status Transaksi gagal diganti, mohon periksa koneksi anda!';
                                        }
                                        break;
                                }
                            } else {
                                $res['success'] = 0;
                                $res['message'] = 'Jadwal Selesai tidak boleh ditentukan sebelum Jadwal Penerimaan dan Pengiriman Transaksi';
                            }
                        } else {
                            $res['success'] = 0;
                            $res['message'] = 'Jadwal Kirim tidak boleh ditentukan sebelum Jadwal Penerimaan Transaksi';
                        }
                        break;
                    }
                default:
                    $jadwalKirim = NULL;
                    $jenisPengiriman = NULL;
                    $wilayahPengiriman = NULL;
                    $ekspedisi = NULL;
                    $driver = NULL;
                    $plat = NULL;
                    $jadwalSelesai = NULL;
                    $update = "UPDATE [WMS].[dbo].[TB_Delivery] SET
                                        Status = :status, TglTerima = :terima, NamaPicker = :picker,
                                        TglKirim = :kirim, TglSelesai = :selesai, JenisPengiriman = :pengiriman,
                                        Wilayah = :wilayah, NamaEkspedisi = :ekspedisi,
                                        NamaDriver = :driver, NoPlat = :plat
                                        WHERE NoTransaksi = :transaksi";
                    $stmt2 = $pdo->prepare($update, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                    $stmt2->bindParam(":status", $status, PDO::PARAM_INT);
                    $stmt2->bindParam(":terima", $jadwalTerima, PDO::PARAM_STR);
                    $stmt2->bindParam(":picker", $picker, PDO::PARAM_STR);
                    $stmt2->bindParam(":kirim", $jadwalKirim, PDO::PARAM_STR);
                    $stmt2->bindParam(":selesai", $jadwalSelesai, PDO::PARAM_STR);
                    $stmt2->bindParam(":pengiriman", $jenisPengiriman, PDO::PARAM_STR);
                    $stmt2->bindParam(":wilayah", $wilayahPengiriman, PDO::PARAM_STR);
                    $stmt2->bindParam(":ekspedisi", $ekspedisi, PDO::PARAM_STR);
                    $stmt2->bindParam(":driver", $driver, PDO::PARAM_STR);
                    $stmt2->bindParam(":plat", $plat, PDO::PARAM_STR);
                    $stmt2->bindParam(":transaksi", $noTransaksi, PDO::PARAM_STR);
                    $stmt2->execute();
                    if($stmt2->rowCount() > 0) {
                        $res['success'] = 1;
                        $res['message'] = 'Status Transaksi Berhasil Diganti!';
                        // var_dump($jadwalKirim);
                        // var_dump($jadwalSelesai);
                    } else {
                        $res['success'] = 0;
                        $res['message'] = 'Status Transaksi gagal diganti, mohon periksa koneksi anda!';
                    }
                    break;
            }
            
            // $picker = $_POST['select_picker'];
            // if(isset($_POST['tanggal_kirim']) ? $jadwalKirim = date_hour_to_str($_POST['tanggal_kirim']) . ':00' : '');
            // if(isset($_POST['select_pengiriman']) ? $jenisPengiriman = $_POST['select_pengiriman'] : '');
            // if(isset($_POST['wilayah_pengiriman']) ? $wilayahPengiriman = $_POST['wilayah_pengiriman'] : '');
            // if(isset($_POST['nama_ekspedisi']) ? $ekspedisi = $_POST['nama_ekspedisi'] : '');
            // if(isset($_POST['nama_driver']) ? $driver = $_POST['nama_driver'] : '');
            // if(isset($_POST['no_plat']) ? $plat = $_POST['no_plat'] : '');
            // if(isset($_POST['tanggal_selesai']) ? $jadwalSelesai = date_hour_to_str($_POST['tanggal_selesai'] . ':00') : '');
        } else {
            $res['success'] = 0;
            $res['message'] = 'Maaf, no transaksi ini tidak terdaftar';
        }
    } else {
        $res['success'] = 0;
        $res['message'] = 'Mohon tentukan tanggal penerimaan No Transaksi ini';
    }
    $pdo = null;
    echo json_encode($res);
?>