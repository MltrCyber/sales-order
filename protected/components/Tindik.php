<?php

class Tindik extends CApplicationComponent {

    public function tgl_indo($tgl, $is_time = false) {
        if ($is_time == FALSE) {
            $t = explode("-", $tgl);
            $b = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
            $tgl = $t[2] . " " . $b[$t[1] - 1] . " " . $t[0];
        } else {
            $pecah = explode(" ", $tgl);
            $t = explode("-", $pecah[0]);
            $b = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
            $tgl = "<i>" . $t[2] . " " . $b[$t[1] - 1] . " " . $t[0] . "</i>  at <i>" . $pecah[1] . "</i>";
        }
        return $tgl;
    }

    public function rupiah($data) {
        $rupiah = "";
        $jml = strlen($data);
        while ($jml > 3) {
            $rupiah = "." . substr($data, -3) . $rupiah;
            $l = strlen($data) - 3;
            $data = substr($data, 0, $l);
            $jml = strlen($data);
        }
        $rupiah = "Rp " . $data . $rupiah . ",-";
        return $rupiah;
    }

    function tgldd($tgl) {
        if ($tgl == "0000-00-00") {
            return "";
        } else {
            $a = explode("-", $tgl);
            $b = $a[2] . "-" . $a[1] . "-" . $a[0];
            return $b;
        }
    }

    function tglyy($tgl) {
        $a = explode("-", $tgl);
        $b = $a[2] . "-" . $a[1] . "-" . $a[0];
        return $b;
    }

    function umur($tgl, $showTahun = true, $showBulan = true) {
        $tg = explode("-", $tgl);
        $tgl_lahir = $tg[2];
        $bln_lahir = $tg[1];
        $thn_lahir = $tg[0];

        $tanggal_today = date('d');
        $bulan_today = date('m');
        $tahun_today = date('Y');

        $harilahir = gregoriantojd($bln_lahir, $tgl_lahir, $thn_lahir);
        $hariini = gregoriantojd($bulan_today, $tanggal_today, $tahun_today);
        $umur = $hariini - $harilahir;

        $tahun = $umur / 365;
        $sisa = $umur % 365;
        $bulan = $sisa / 30;
        $hari = $sisa % 30;
        $lahir = $tgl_lahir - $bln_lahir - $thn_lahir;

        $today = $tanggal_today - $bulan_today - $tahun_today;
        $thn = floor($tahun);
        $bln = floor($bulan);

        $show = '';
        if ($showTahun == true) {
            $show .= $thn . ' Tahun ';
        }
        if ($showBulan == true) {
            $show .= $bln . ' Bulan';
        }

        return $show;
    }

    function listbulan() {
        $b = array("01" => "Januari", "02" => "Februari", "03" => "Maret", "04" => "April", "05" => "Mei", "06" => "Juni", "07" => "Juli", "08" => "Agustus", "09" => "September", "10" => "Oktober", "11" => "November", "12" => "Desember");
        return $b;
    }

}
