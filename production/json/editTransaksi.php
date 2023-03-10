<?php
    session_start();
    require_once '../../function.php';
    date_default_timezone_set('Asia/Jakarta');
    $res = [];
    $noTransaksi = $_POST['no_transaksi'];
    if(isset($_POST['tanggal_terima']) && isset($_POST['select_status']) && isset($_POST['select_picker'])) {
        $jadwalTerima = date_hour_to_str($_POST['tanggal_terima'] . ':00');
        $status = $_POST['select_status'];
        $picker = $_POST['select_picker'];
        $check = "SELECT * FROM [WMS].[dbo].[TB_Delivery]
                    WHERE NoTransaksi = :noTransaksi";
        $stmt = $pdo->prepare($check, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
        $stmt->bindParam(":noTransaksi", $noTransaksi, PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->rowCount() > 0) {
            switch($status) {
                case 2:
                    if(isset($_POST['tanggal_kirim'])) {
                        $jadwalKirim = date_hour_to_str($_POST['tanggal_kirim'] . ':00');
                        if($jadwalKirim >= $jadwalTerima) {
                            if(isset($_POST['select_pengiriman'])) {
                                $jenisPengiriman = $_POST['select_pengiriman'];
                                $jadwalSelesai = null;
                                switch($jenisPengiriman) {
                                    case 'Kirim Customer':
                                        if(isset($_POST['wilayah_pengiriman'])) {
                                            $wilayahPengiriman = $_POST['wilayah_pengiriman'];
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
                                                    } else {
                                                        $res['success'] = 0;
                                                        $res['message'] = 'Status Transaksi gagal diganti, mohon periksa koneksi anda!';
                                                        }
                                                } else {
                                                    $res['success'] = 0;
                                                    $res['message'] = 'Mohon tentukan nama ekspedisi untuk transaksi ini';
                                                }
                                            }
                                        } else {
                                            $res['success'] = 0;
                                            $res['message'] = 'Mohon tentukan wilayah pengiriman untuk transaksi ini!';
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
                                $res['message'] = 'Mohon tentukan jenis pengiriman barang yang hendak dikirim';
                            }
                        } else {
                            $res['success'] = 0;
                            $res['message'] = 'Jadwal Pengiriman tidak boleh ditentukan sebelum Jadwal Penerimaan Transaksi';
                        }
                    } else {
                        $res['success'] = 0;
                        $res['message'] = 'Mohon tentukan jadwal pengiriman untuk transaksi ini';
                    }
                    break;
                case 3:
                    // $picker = $_POST['select_picker'];
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
                    $jadwalKirim = null;
                    $jenisPengiriman = "";
                    $wilayahPengiriman = "";
                    $ekspedisi = "";
                    $driver = "";
                    $plat = "";
                    $jadwalSelesai = null;
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
            // for insertion only, if no transaksi isn't present at TB_Delivery
            switch($status) {
                case 2:
                    if(isset($_POST['tanggal_kirim'])) {
                        $jadwalKirim = date_hour_to_str($_POST['tanggal_kirim'] . ':00');
                        if($jadwalKirim >= $jadwalTerima) {
                            if(isset($_POST['select_pengiriman'])) {
                                $jenisPengiriman = $_POST['select_pengiriman'];
                                switch($jenisPengiriman) {
                                    case 'Kirim Customer':
                                        if(isset($_POST['wilayah_pengiriman'])) {
                                            $wilayahPengiriman = $_POST['wilayah_pengiriman'];
                                            if($wilayahPengiriman == 'Dalam Kota') {
                                                if($_POST['nama_driver'] != '' && $_POST['no_plat'] != '') {
                                                    $driver = $_POST['nama_driver'];
                                                    $plat = $_POST['no_plat'];
                                                    $ekspedisi = '';
                                                    $idTransaksi = $_POST['id_transaksi'];
                                                    $customer = $_POST['nama_customer'];
                                                    $sales = $_POST['nama_sales'];
                                                    $tglTransaksi = date_hour_to_str($_POST['tgl_transaksi'] . ':00');
                                                    $insert = "INSERT INTO [WMS].[dbo].[TB_Delivery] 
                                                            ([IDTransaksi], [NoTransaksi], [Customer], 
                                                             [TglTransaksi], [Status], [NamaPicker], 
                                                             [TglTerima], [NamaSales], [TglKirim], 
                                                             [JenisPengiriman], [Wilayah], [NamaEkspedisi],
                                                             [NamaDriver], [NoPlat])
                                                            VALUES (:id, :no, :cust, :tgltransaksi, :status, :picker, 
                                                                    :terima, :sales, :kirim, :pengiriman, :wilayah, :ekspedisi, 
                                                                    :driver, :plat)";
                                                    $stmt3 = $pdo->prepare($insert, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                                                    $stmt3->bindParam(":id", $idTransaksi, PDO::PARAM_STR);
                                                    $stmt3->bindParam(":no", $noTransaksi, PDO::PARAM_STR);
                                                    $stmt3->bindParam(":cust", $customer, PDO::PARAM_STR);
                                                    $stmt3->bindParam(":status", $status, PDO::PARAM_INT);
                                                    $stmt3->bindParam(":tgltransaksi", $tglTransaksi, PDO::PARAM_STR);
                                                    $stmt3->bindParam(":picker", $picker, PDO::PARAM_STR);
                                                    $stmt3->bindParam(":terima", $jadwalTerima, PDO::PARAM_STR);
                                                    $stmt3->bindParam(":sales", $sales, PDO::PARAM_STR);
                                                    $stmt3->bindParam(":kirim", $jadwalKirim, PDO::PARAM_STR);
                                                    $stmt3->bindParam(":pengiriman", $jenisPengiriman, PDO::PARAM_STR);
                                                    $stmt3->bindParam(":wilayah", $wilayahPengiriman, PDO::PARAM_STR);
                                                    $stmt3->bindParam(":ekspedisi", $ekspedisi, PDO::PARAM_STR);
                                                    $stmt3->bindParam(":driver", $driver, PDO::PARAM_STR);
                                                    $stmt3->bindParam(":plat", $plat, PDO::PARAM_STR);
                                                    $stmt3->execute();
                                                    if($stmt3->rowCount() > 0) {
                                                        $res['success'] = 1;
                                                        $res['message'] = 'Transaksi Berhasil Dimasukkan!';
                                                    } else {
                                                        $res['success'] = 0;
                                                        $res['message'] = 'Transaksi gagal dimasukkan, mohon periksa koneksi anda!';
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
                                                    $idTransaksi = $_POST['id_transaksi'];
                                                    $customer = $_POST['nama_customer'];
                                                    $sales = $_POST['nama_sales'];
                                                    $tglTransaksi = date_hour_to_str($_POST['tgl_transaksi'] . ':00');
                                                    $insert = "INSERT INTO [WMS].[dbo].[TB_Delivery] 
                                                                ([IDTransaksi], [NoTransaksi], [Customer], 
                                                                [TglTransaksi], [Status], [NamaPicker], 
                                                                [TglTerima], [NamaSales], [TglKirim], 
                                                                [JenisPengiriman], [Wilayah], [NamaEkspedisi],
                                                                [NamaDriver], [NoPlat])
                                                                VALUES (:id, :no, :cust, :tgltransaksi, :status, :picker, 
                                                                        :terima, :sales, :kirim, :pengiriman, :wilayah, :ekspedisi, 
                                                                        :driver, :plat)";
                                                    $stmt3 = $pdo->prepare($insert, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                                                    $stmt3->bindParam(":id", $idTransaksi, PDO::PARAM_STR);
                                                    $stmt3->bindParam(":no", $noTransaksi, PDO::PARAM_STR);
                                                    $stmt3->bindParam(":cust", $customer, PDO::PARAM_STR);
                                                    $stmt3->bindParam(":status", $status, PDO::PARAM_INT);
                                                    $stmt3->bindParam(":tgltransaksi", $tglTransaksi, PDO::PARAM_STR);
                                                    $stmt3->bindParam(":picker", $picker, PDO::PARAM_STR);
                                                    $stmt3->bindParam(":terima", $jadwalTerima, PDO::PARAM_STR);
                                                    $stmt3->bindParam(":sales", $sales, PDO::PARAM_STR);
                                                    $stmt3->bindParam(":kirim", $jadwalKirim, PDO::PARAM_STR);
                                                    $stmt3->bindParam(":pengiriman", $jenisPengiriman, PDO::PARAM_STR);
                                                    $stmt3->bindParam(":wilayah", $wilayahPengiriman, PDO::PARAM_STR);
                                                    $stmt3->bindParam(":ekspedisi", $ekspedisi, PDO::PARAM_STR);
                                                    $stmt3->bindParam(":driver", $driver, PDO::PARAM_STR);
                                                    $stmt3->bindParam(":plat", $plat, PDO::PARAM_STR);
                                                    $stmt3->execute();
                                                    if($stmt3->rowCount() > 0) {
                                                        $res['success'] = 1;
                                                        $res['message'] = 'Transaksi Berhasil Disimpan!';
                                                    } else {
                                                        $res['success'] = 0;
                                                        $res['message'] = 'Transaksi gagal disimpan, mohon periksa koneksi anda!';
                                                    }
                                                } else {
                                                    $res['success'] = 0;
                                                    $res['message'] = 'Mohon tentukan nama ekspedisi untuk transaksi ini';
                                                }
                                            }
                                        } else {
                                            $res['success'] = 0;
                                            $res['message'] = 'Mohon tentukan wilayah pengiriman untuk transaksi ini!';
                                        }
                                        break;
                                    case 'Ambil Sendiri':
                                        $driver = $_POST['nama_driver'];
                                        $plat = $_POST['no_plat'];
                                        $ekspedisi = $_POST['nama_ekspedisi'];
                                        $wilayahPengiriman = '';
                                        $idTransaksi = $_POST['id_transaksi'];
                                        $customer = $_POST['nama_customer'];
                                        $sales = $_POST['nama_sales'];
                                        $tglTransaksi = date_hour_to_str($_POST['tgl_transaksi'] . ':00');
                                        $insert = "INSERT INTO [WMS].[dbo].[TB_Delivery] 
                                                    ([IDTransaksi], [NoTransaksi], [Customer], 
                                                     [TglTransaksi], [Status], [NamaPicker], 
                                                     [TglTerima], [NamaSales], [TglKirim], 
                                                     [JenisPengiriman], [Wilayah], [NamaEkspedisi],
                                                     [NamaDriver], [NoPlat])
                                                    VALUES (:id, :no, :cust, :tgltransaksi, :status, :picker, 
                                                            :terima, :sales, :kirim, :pengiriman, :wilayah, :ekspedisi, 
                                                            :driver, :plat)";
                                        $stmt3 = $pdo->prepare($insert, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                                        $stmt3->bindParam(":id", $idTransaksi, PDO::PARAM_STR);
                                        $stmt3->bindParam(":no", $noTransaksi, PDO::PARAM_STR);
                                        $stmt3->bindParam(":cust", $customer, PDO::PARAM_STR);
                                        $stmt3->bindParam(":status", $status, PDO::PARAM_INT);
                                        $stmt3->bindParam(":tgltransaksi", $tglTransaksi, PDO::PARAM_STR);
                                        $stmt3->bindParam(":picker", $picker, PDO::PARAM_STR);
                                        $stmt3->bindParam(":terima", $jadwalTerima, PDO::PARAM_STR);
                                        $stmt3->bindParam(":sales", $sales, PDO::PARAM_STR);
                                        $stmt3->bindParam(":kirim", $jadwalKirim, PDO::PARAM_STR);
                                        $stmt3->bindParam(":pengiriman", $jenisPengiriman, PDO::PARAM_STR);
                                        $stmt3->bindParam(":wilayah", $wilayahPengiriman, PDO::PARAM_STR);
                                        $stmt3->bindParam(":ekspedisi", $ekspedisi, PDO::PARAM_STR);
                                        $stmt3->bindParam(":driver", $driver, PDO::PARAM_STR);
                                        $stmt3->bindParam(":plat", $plat, PDO::PARAM_STR);
                                        $stmt3->execute();
                                        if($stmt3->rowCount() > 0) {
                                            $res['success'] = 1;
                                            $res['message'] = 'Transaksi Berhasil Disimpan!';
                                        } else {
                                            $res['success'] = 0;
                                            $res['message'] = 'Transaksi gagal disimpan, mohon periksa koneksi anda!';
                                        }
                                        break;
                                    default:
                                        $driver = $_POST['nama_driver'];
                                        $plat = $_POST['no_plat'];
                                        $ekspedisi = $_POST['nama_ekspedisi'];
                                        $wilayahPengiriman = '';
                                        $idTransaksi = $_POST['id_transaksi'];
                                        $customer = $_POST['nama_customer'];
                                        $sales = $_POST['nama_sales'];
                                        $tglTransaksi = date_hour_to_str($_POST['tgl_transaksi'] . ':00');
                                        $insert = "INSERT INTO [WMS].[dbo].[TB_Delivery] 
                                                    ([IDTransaksi], [NoTransaksi], [Customer], 
                                                     [TglTransaksi], [Status], [NamaPicker], 
                                                     [TglTerima], [NamaSales], [TglKirim], 
                                                     [JenisPengiriman], [Wilayah], [NamaEkspedisi],
                                                     [NamaDriver], [NoPlat])
                                                    VALUES (:id, :no, :cust, :tgltransaksi, :status, :picker, 
                                                            :terima, :sales, :kirim, :pengiriman, :wilayah, :ekspedisi, 
                                                            :driver, :plat)";
                                        $stmt3 = $pdo->prepare($insert, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                                        $stmt3->bindParam(":id", $idTransaksi, PDO::PARAM_STR);
                                        $stmt3->bindParam(":no", $noTransaksi, PDO::PARAM_STR);
                                        $stmt3->bindParam(":cust", $customer, PDO::PARAM_STR);
                                        $stmt3->bindParam(":status", $status, PDO::PARAM_INT);
                                        $stmt3->bindParam(":tgltransaksi", $tglTransaksi, PDO::PARAM_STR);
                                        $stmt3->bindParam(":picker", $picker, PDO::PARAM_STR);
                                        $stmt3->bindParam(":terima", $jadwalTerima, PDO::PARAM_STR);
                                        $stmt3->bindParam(":sales", $sales, PDO::PARAM_STR);
                                        $stmt3->bindParam(":kirim", $jadwalKirim, PDO::PARAM_STR);
                                        $stmt3->bindParam(":pengiriman", $jenisPengiriman, PDO::PARAM_STR);
                                        $stmt3->bindParam(":wilayah", $wilayahPengiriman, PDO::PARAM_STR);
                                        $stmt3->bindParam(":ekspedisi", $ekspedisi, PDO::PARAM_STR);
                                        $stmt3->bindParam(":driver", $driver, PDO::PARAM_STR);
                                        $stmt3->bindParam(":plat", $plat, PDO::PARAM_STR);
                                        $stmt3->execute();
                                        if($stmt3->rowCount() > 0) {
                                            $res['success'] = 1;
                                            $res['message'] = 'Transaksi Berhasil Disimpan!';
                                        } else {
                                            $res['success'] = 0;
                                            $res['message'] = 'Transaksi gagal disimpan, mohon periksa koneksi anda!';
                                        }
                                        break;
                                }
                            } else {
                                $res['success'] = 0;
                                $res['message'] = 'Mohon tentukan jenis pengiriman barang yang hendak dikirim';
                            }
                        } else {
                            $res['success'] = 0;
                            $res['message'] = 'Jadwal Pengiriman tidak boleh ditentukan sebelum Jadwal Penerimaan Transaksi';
                        }
                        
                    } else {
                        $res['success'] = 0;
                        $res['message'] = 'Mohon tentukan jadwal pengiriman untuk transaksi ini';
                    }
                    break;
                case 3:
                    if(isset($_POST['tanggal_kirim']) && isset($_POST['tanggal_selesai'])) {
                        $jadwalKirim = date_hour_to_str($_POST['tanggal_kirim'] . ':00');
                        $jadwalSelesai = date_hour_to_str($_POST['tanggal_selesai'] . ':00');
                        if($jadwalKirim >= $jadwalTerima) {
                            if($jadwalSelesai >= $jadwalKirim && $jadwalSelesai > $jadwalTerima) {
                                $jenisPengiriman = $_POST['select_pengiriman'];
                                switch($jenisPengiriman) {
                                    case 'Kirim Customer':
                                        $wilayahPengiriman = $_POST['wilayah_pengiriman'];
                                        if($wilayahPengiriman == 'Dalam Kota') {
                                            if($_POST['nama_driver'] != '' && $_POST['no_plat'] != '') {
                                                $driver = $_POST['nama_driver'];
                                                $plat = $_POST['no_plat'];
                                                $ekspedisi = '';
                                                $idTransaksi = $_POST['id_transaksi'];
                                                $customer = $_POST['nama_customer'];
                                                $sales = $_POST['nama_sales'];
                                                $tglTransaksi = date_hour_to_str($_POST['tgl_transaksi'] . ':00');
                                                $insert = "INSERT INTO [WMS].[dbo].[TB_Delivery] 
                                                            ([IDTransaksi], [NoTransaksi], [Customer], 
                                                             [TglTransaksi], [Status], [NamaPicker], 
                                                             [TglTerima], [NamaSales], [TglKirim],
                                                             [TglSelesai], [JenisPengiriman], [Wilayah], 
                                                             [NamaEkspedisi], [NamaDriver], [NoPlat])
                                                            VALUES (:id, :no, :cust, :tgltransaksi, :status, :picker, 
                                                                    :terima, :sales, :kirim, :selesai, :pengiriman, :wilayah, :ekspedisi, 
                                                                    :driver, :plat)";
                                                $stmt3 = $pdo->prepare($insert, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                                                $stmt3->bindParam(":id", $idTransaksi, PDO::PARAM_STR);
                                                $stmt3->bindParam(":no", $noTransaksi, PDO::PARAM_STR);
                                                $stmt3->bindParam(":cust", $customer, PDO::PARAM_STR);
                                                $stmt3->bindParam(":status", $status, PDO::PARAM_INT);
                                                $stmt3->bindParam(":tgltransaksi", $tglTransaksi, PDO::PARAM_STR);
                                                $stmt3->bindParam(":picker", $picker, PDO::PARAM_STR);
                                                $stmt3->bindParam(":terima", $jadwalTerima, PDO::PARAM_STR);
                                                $stmt3->bindParam(":sales", $sales, PDO::PARAM_STR);
                                                $stmt3->bindParam(":kirim", $jadwalKirim, PDO::PARAM_STR);
                                                $stmt3->bindParam(":selesai", $jadwalSelesai, PDO::PARAM_STR);
                                                $stmt3->bindParam(":pengiriman", $jenisPengiriman, PDO::PARAM_STR);
                                                $stmt3->bindParam(":wilayah", $wilayahPengiriman, PDO::PARAM_STR);
                                                $stmt3->bindParam(":ekspedisi", $ekspedisi, PDO::PARAM_STR);
                                                $stmt3->bindParam(":driver", $driver, PDO::PARAM_STR);
                                                $stmt3->bindParam(":plat", $plat, PDO::PARAM_STR);
                                                $stmt3->execute();
                                                if($stmt3->rowCount() > 0) {
                                                    $res['success'] = 1;
                                                    $res['message'] = 'Transaksi berhasil disimpan!';
                                                } else {
                                                    $res['success'] = 0;
                                                    $res['message'] = 'Transaksi gagal disimpan, mohon periksa koneksi anda!';
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
                                                $idTransaksi = $_POST['id_transaksi'];
                                                $customer = $_POST['nama_customer'];
                                                $sales = $_POST['nama_sales'];
                                                $tglTransaksi = date_hour_to_str($_POST['tgl_transaksi'] . ':00');
                                                $insert = "INSERT INTO [WMS].[dbo].[TB_Delivery] 
                                                            ([IDTransaksi], [NoTransaksi], [Customer], 
                                                             [TglTransaksi], [Status], [NamaPicker], 
                                                             [TglTerima], [NamaSales], [TglKirim],
                                                             [TglSelesai], [JenisPengiriman], [Wilayah], 
                                                             [NamaEkspedisi], [NamaDriver], [NoPlat])
                                                            VALUES (:id, :no, :cust, :tgltransaksi, :status, :picker, 
                                                                    :terima, :sales, :kirim, :selesai, :pengiriman, :wilayah, :ekspedisi, 
                                                                    :driver, :plat)";
                                                $stmt3 = $pdo->prepare($insert, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                                                $stmt3->bindParam(":id", $idTransaksi, PDO::PARAM_STR);
                                                $stmt3->bindParam(":no", $noTransaksi, PDO::PARAM_STR);
                                                $stmt3->bindParam(":cust", $customer, PDO::PARAM_STR);
                                                $stmt3->bindParam(":status", $status, PDO::PARAM_INT);
                                                $stmt3->bindParam(":tgltransaksi", $tglTransaksi, PDO::PARAM_STR);
                                                $stmt3->bindParam(":picker", $picker, PDO::PARAM_STR);
                                                $stmt3->bindParam(":terima", $jadwalTerima, PDO::PARAM_STR);
                                                $stmt3->bindParam(":sales", $sales, PDO::PARAM_STR);
                                                $stmt3->bindParam(":kirim", $jadwalKirim, PDO::PARAM_STR);
                                                $stmt3->bindParam(":selesai", $jadwalSelesai, PDO::PARAM_STR);
                                                $stmt3->bindParam(":pengiriman", $jenisPengiriman, PDO::PARAM_STR);
                                                $stmt3->bindParam(":wilayah", $wilayahPengiriman, PDO::PARAM_STR);
                                                $stmt3->bindParam(":ekspedisi", $ekspedisi, PDO::PARAM_STR);
                                                $stmt3->bindParam(":driver", $driver, PDO::PARAM_STR);
                                                $stmt3->bindParam(":plat", $plat, PDO::PARAM_STR);
                                                $stmt3->execute();
                                                if($stmt3->rowCount() > 0) {
                                                    $res['success'] = 1;
                                                    $res['message'] = 'Transaksi berhasil disimpan!';
                                                } else {
                                                    $res['success'] = 0;
                                                    $res['message'] = 'Transaksi gagal disimpan, mohon periksa koneksi anda!';
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
                                        $idTransaksi = $_POST['id_transaksi'];
                                        $customer = $_POST['nama_customer'];
                                        $sales = $_POST['nama_sales'];
                                        $tglTransaksi = date_hour_to_str($_POST['tgl_transaksi'] . ':00');
                                        $insert = "INSERT INTO [WMS].[dbo].[TB_Delivery] 
                                                            ([IDTransaksi], [NoTransaksi], [Customer], 
                                                             [TglTransaksi], [Status], [NamaPicker], 
                                                             [TglTerima], [NamaSales], [TglKirim],
                                                             [TglSelesai], [JenisPengiriman], [Wilayah], 
                                                             [NamaEkspedisi], [NamaDriver], [NoPlat])
                                                            VALUES (:id, :no, :cust, :tgltransaksi, :status, :picker, 
                                                                    :terima, :sales, :kirim, :selesai, :pengiriman, :wilayah, :ekspedisi, 
                                                                    :driver, :plat)";
                                        $stmt3 = $pdo->prepare($insert, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                                        $stmt3->bindParam(":id", $idTransaksi, PDO::PARAM_STR);
                                        $stmt3->bindParam(":no", $noTransaksi, PDO::PARAM_STR);
                                        $stmt3->bindParam(":cust", $customer, PDO::PARAM_STR);
                                        $stmt3->bindParam(":status", $status, PDO::PARAM_INT);
                                        $stmt3->bindParam(":tgltransaksi", $tglTransaksi, PDO::PARAM_STR);
                                        $stmt3->bindParam(":picker", $picker, PDO::PARAM_STR);
                                        $stmt3->bindParam(":terima", $jadwalTerima, PDO::PARAM_STR);
                                        $stmt3->bindParam(":sales", $sales, PDO::PARAM_STR);
                                        $stmt3->bindParam(":kirim", $jadwalKirim, PDO::PARAM_STR);
                                        $stmt3->bindParam(":selesai", $jadwalSelesai, PDO::PARAM_STR);
                                        $stmt3->bindParam(":pengiriman", $jenisPengiriman, PDO::PARAM_STR);
                                        $stmt3->bindParam(":wilayah", $wilayahPengiriman, PDO::PARAM_STR);
                                        $stmt3->bindParam(":ekspedisi", $ekspedisi, PDO::PARAM_STR);
                                        $stmt3->bindParam(":driver", $driver, PDO::PARAM_STR);
                                        $stmt3->bindParam(":plat", $plat, PDO::PARAM_STR);
                                        $stmt3->execute();
                                        if($stmt3->rowCount() > 0) {
                                            $res['success'] = 1;
                                            $res['message'] = 'Transaksi Berhasil Disimpan!';
                                        } else {
                                            $res['success'] = 0;
                                            $res['message'] = 'Transaksi gagal disimpan, mohon periksa koneksi anda!';
                                        }
                                        break;
                                    default:
                                        $driver = $_POST['nama_driver'];
                                        $plat = $_POST['no_plat'];
                                        $ekspedisi = $_POST['nama_ekspedisi'];
                                        $wilayahPengiriman = '';
                                        $idTransaksi = $_POST['id_transaksi'];
                                        $customer = $_POST['nama_customer'];
                                        $sales = $_POST['nama_sales'];
                                        $tglTransaksi = date_hour_to_str($_POST['tgl_transaksi'] . ':00');
                                        $insert = "INSERT INTO [WMS].[dbo].[TB_Delivery] 
                                                            ([IDTransaksi], [NoTransaksi], [Customer], 
                                                             [TglTransaksi], [Status], [NamaPicker], 
                                                             [TglTerima], [NamaSales], [TglKirim],
                                                             [TglSelesai], [JenisPengiriman], [Wilayah], 
                                                             [NamaEkspedisi], [NamaDriver], [NoPlat])
                                                            VALUES (:id, :no, :cust, :tgltransaksi, :status, :picker, 
                                                                    :terima, :sales, :kirim, :selesai, :pengiriman, :wilayah, :ekspedisi, 
                                                                    :driver, :plat)";
                                        $stmt3 = $pdo->prepare($insert, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                                        $stmt3->bindParam(":id", $idTransaksi, PDO::PARAM_STR);
                                        $stmt3->bindParam(":no", $noTransaksi, PDO::PARAM_STR);
                                        $stmt3->bindParam(":cust", $customer, PDO::PARAM_STR);
                                        $stmt3->bindParam(":status", $status, PDO::PARAM_INT);
                                        $stmt3->bindParam(":tgltransaksi", $tglTransaksi, PDO::PARAM_STR);
                                        $stmt3->bindParam(":picker", $picker, PDO::PARAM_STR);
                                        $stmt3->bindParam(":terima", $jadwalTerima, PDO::PARAM_STR);
                                        $stmt3->bindParam(":sales", $sales, PDO::PARAM_STR);
                                        $stmt3->bindParam(":kirim", $jadwalKirim, PDO::PARAM_STR);
                                        $stmt3->bindParam(":selesai", $jadwalSelesai, PDO::PARAM_STR);
                                        $stmt3->bindParam(":pengiriman", $jenisPengiriman, PDO::PARAM_STR);
                                        $stmt3->bindParam(":wilayah", $wilayahPengiriman, PDO::PARAM_STR);
                                        $stmt3->bindParam(":ekspedisi", $ekspedisi, PDO::PARAM_STR);
                                        $stmt3->bindParam(":driver", $driver, PDO::PARAM_STR);
                                        $stmt3->bindParam(":plat", $plat, PDO::PARAM_STR);
                                        $stmt3->execute();
                                        if($stmt3->rowCount() > 0) {
                                            $res['success'] = 1;
                                            $res['message'] = 'Transaksi Berhasil Disimpan!';
                                        } else {
                                            $res['success'] = 0;
                                            $res['message'] = 'Transaksi gagal disimpan, mohon periksa koneksi anda!';
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
                    break;
                default:
                    $idTransaksi = $_POST['id_transaksi'];
                    $customer = $_POST['nama_customer'];
                    $sales = $_POST['nama_sales'];
                    $tglTransaksi = date_hour_to_str($_POST['tgl_transaksi'] . ':00');
                    $insert = "INSERT INTO [WMS].[dbo].[TB_Delivery] 
                            ([IDTransaksi], [NoTransaksi], [Customer], [TglTransaksi], [Status], [NamaPicker], [TglTerima], [NamaSales])
                            VALUES (:id, :no, :cust, :tgltransaksi, :status, :picker, :terima, :sales)";
                    $stmt3 = $pdo->prepare($insert, [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
                    $stmt3->bindParam(":id", $idTransaksi, PDO::PARAM_STR);
                    $stmt3->bindParam(":no", $noTransaksi, PDO::PARAM_STR);
                    $stmt3->bindParam(":cust", $customer, PDO::PARAM_STR);
                    $stmt3->bindParam(":status", $status, PDO::PARAM_INT);
                    $stmt3->bindParam(":tgltransaksi", $tglTransaksi, PDO::PARAM_STR);
                    $stmt3->bindParam(":picker", $picker, PDO::PARAM_STR);
                    $stmt3->bindParam(":terima", $jadwalTerima, PDO::PARAM_STR);
                    $stmt3->bindParam(":sales", $sales, PDO::PARAM_STR);
                    $stmt3->execute();
                    if($stmt3->rowCount() > 0){
                        $res['success'] = 1;
                        $res['message'] = 'Transaksi Berhasil Disimpan!';
                    } else {
                        $res['success'] = 0;
                        $res['message'] = 'Transaksi gagal disimpan, mohon periksa koneksi anda!';
                    }
                    break;
            }
        } 
            // $picker = $_POST['select_picker'];
            // if(isset($_POST['tanggal_kirim']) ? $jadwalKirim = date_hour_to_str($_POST['tanggal_kirim']) . ':00' : '');
            // if(isset($_POST['select_pengiriman']) ? $jenisPengiriman = $_POST['select_pengiriman'] : '');
            // if(isset($_POST['wilayah_pengiriman']) ? $wilayahPengiriman = $_POST['wilayah_pengiriman'] : '');
            // if(isset($_POST['nama_ekspedisi']) ? $ekspedisi = $_POST['nama_ekspedisi'] : '');
            // if(isset($_POST['nama_driver']) ? $driver = $_POST['nama_driver'] : '');
            // if(isset($_POST['no_plat']) ? $plat = $_POST['no_plat'] : '');
            // if(isset($_POST['tanggal_selesai']) ? $jadwalSelesai = date_hour_to_str($_POST['tanggal_selesai'] . ':00') : '');
        // } else {
        //     $res['success'] = 0;
        //     $res['message'] = 'Maaf, no transaksi ini tidak terdaftar';
        // }
    } else {
        $res['success'] = 0;
        $res['message'] = 'Mohon tentukan jenis pengiriman, nama picker, dan tanggal penerimaan untuk transaksi ini';
    }
    $pdo = null;
    echo json_encode($res);
?>