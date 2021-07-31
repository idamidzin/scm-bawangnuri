<?php

if (!function_exists('rupiah')) {

    /**
     * convert string date system to string date indo
     *
     * @param string
     * @return string
     */
    function rupiah($string)
    {
    	return number_format($string,2,",",".");
    }
}

if (!function_exists('tanggalIndo')) {

    /**
     * convert string date system to string date indo
     *
     * @param string
     * @return string
     */
    function tanggalIndo($date,$short_month = false)
    {
        $time = strtotime($date);

        return date('d',$time)." ".bulanIndo(date('m',$time),$short_month)." ".date('Y',$time);
    }
}
if (!function_exists('bulanIndo')) {

    /**
     * conver number of month to month name
     *
     * @param int
     * @return string
     */
    function bulanIndo($no,$short = false) {
        $no = (int) $no;
        switch ($no) {
            case 1:return $short ? 'Jan' : 'Januari';break;
            case 2:return $short ? 'Feb' : 'Februari';break;
            case 3:return $short ? 'Mar' : 'Maret';break;
            case 4:return $short ? 'Apr' : 'April';break;
            case 5:return $short ? 'Mei' : 'Mei';break;
            case 6:return $short ? 'Jun' : 'Juni';break;
            case 7:return $short ? 'Jul' : 'Juli';break;
            case 8:return $short ? 'Agu' : 'Agustus';break;
            case 9:return $short ? 'Sep' : 'September';break;
            case 10:return $short ? 'Okt' : 'Oktober';break;
            case 11:return $short ? 'Nov' : 'November';break;
            case 12:return $short ? 'Des' : 'Desember';break;
        }
        return '-';
    }
}

if (!function_exists('rangeDate')) {

    /**
     * conver number of month to month name
     *
     * @param int
     * @return string
     */
    function rangeDate($date_start,$date_end,$short_month = false, $separator = '-') {
        $start=strtotime($date_start);
        $end=strtotime($date_end);

        if ($date_start == $date_end) 
        {
            return date('d',$start).' '.bulanIndo(date('m',$start),$short_month).' '.date('Y',$start);
        }
        elseif (date('Y-m',$start) == date('Y-m',$end)) 
        {
            return date('d',$start)." {$separator} ".date('d',$end).' '.bulanIndo(date('m',$start),$short_month).' '.date('Y',$start);
        }
        elseif (date('Y',$start) == date('Y',$end))
        {
            return date('d',$start).' '.bulanIndo(date('m',$start),$short_month)." {$separator} ".date('d',$end).' '.bulanIndo(date('m',$end),$short_month).' '.date('Y',$end);
        }
        else
        {
            return date('d',$start).bulanIndo(date('m',$start),$short_month).' '.date('Y',$start)." {$separator} ".date('d',$end).' '.bulanIndo(date('m',$end),true).' '.date('Y',$end);
        }
    }
}

if (!function_exists('hashDecoded')) {

    /**
     * decode hashids
     *
     * @param string
     * @return string
     */
    function hashDecoded($hash) {
        $decode = \Hashids::decode($hash);
        return count($decode) > 0  ? $decode[0] : false;
    }
}

if (!function_exists('dayToNumber')) {

    /**
     * convert day to number
     *
     * @param string
     * @return int
     */
    function dayToNumber($day) {
        switch ($day) {
            case 'senin':return 1;break;
            case 'selasa':return 2;break;
            case 'rabu':return 3;break;
            case 'kamis':return 4;break;
            case 'jumat':return 5;break;
            case 'sabtu':return 6;break;
            case 'minggu':return 7;break;
        }
        return 0;
        
    }
}

if (!function_exists('numberToDay')) {

    /**
     * convert number to day
     *
     * @param string
     * @return int
     */
    function numberToDay($number) 
    {
        switch ($number) {
            case 1:return 'senin';break;
            case 2:return 'selasa';break;
            case 3:return 'rabu';break;
            case 4:return 'kamis';break;
            case 5:return 'jumat';break;
            case 6:return 'sabtu';break;
            case 7:return 'minggu';break;
        }
        return '';
        
    }
}

if (!function_exists('slug')) {

    /**
     * convert raw string to slug format
     *
     * @param string
     * @param string (nullable)
     * @return string
     */
    function slug($str,$delimiter = '-')
    {
        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace("/[']/", '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug;
    }
}

if (!function_exists('numberToNameColumn')) {

    /**
     * convert number to name column excel
     *
     * @param int
     * @return string
     */
    function numberToNameColumn($num) {
        $numeric = ($num - 1) % 26;
        $letter = chr(65 + $numeric);
        $num2 = intval(($num - 1) / 26);
        if ($num2 > 0) {
            return numberToNameColumn($num2) . $letter;
        } else {
            return $letter;
        }
    }
}

if (!function_exists('menitKeJam'))
{
    function menitKeJam($waktu){
        if(($waktu>0) and ($waktu<60)){
            $lama=0;
            return $lama;
        }
        if(($waktu>=60) and ($waktu<=3600)){
            $detik=fmod($waktu,60);
            $menit=$waktu-$detik;
            $menit=$menit/60;
            if ($menit >= 60) {
                $lama=1;
            }else{
                $lama=0;
            }
            return $lama;
        }
        elseif($waktu >3600){
            $detik=fmod($waktu,60);
            $tempmenit=($waktu-$detik)/60;
            $menit=fmod($tempmenit,60);
            $jam=($tempmenit-$menit)/60;
            $lama= $jam;
            return $lama;
        }
    }
}

if (!function_exists('hari'))
{
    function hari($tanggal){
        $hari = date("D", strtotime($tanggal));
        switch($hari){
            case 'Sun':
            $hari = "minggu";
            break;
            case 'Mon':         
            $hari = "menin";
            break;
            case 'Tue':
            $hari = "melasa";
            break;
            case 'Wed':
            $hari = "rabu";
            break;
            case 'Thu':
            $hari = "kamis";
            break;
            case 'Fri':
            $hari = "jumat";
            break;
            case 'Sat':
            $hari = "sabtu";
            break;
            default:
            $hari = "Tidak di ketahui";     
            break;
        }
        return $hari;
    }
}