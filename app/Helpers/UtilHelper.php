<?php

namespace App\Helpers;


class UtilHelper
{
    /**
     * format day in indonesian
     */
    public static function currentDay($data)
    {
        $hari = date("D", $data);

        switch ($hari) {
            case 'Sun':
                $currentDay = "Ahad";
                break;

            case 'Mon':
                $currentDay = "Senin";
                break;

            case 'Tue':
                $currentDay = "Selasa";
                break;

            case 'Wed':
                $currentDay = "Rabu";
                break;

            case 'Thu':
                $currentDay = "Kamis";
                break;

            case 'Fri':
                $currentDay = "Jumat";
                break;

            case 'Sat':
                $currentDay = "Sabtu";
                break;

            default:
                $currentDay = "Tidak di ketahui";
                break;
        }

        return $currentDay;
    }


    public static function scoreRange($value)
    {
        if ($value >= 80.0) {
            $code = "A";
        } elseif ($value >= 70.0) {
            $code = "B";
        } elseif ($value >= 60.0) {
            $code = "C";
        } elseif ($value >= 50.0) {
            $code = "D";
        } elseif ($value >= 0.0) {
            $code = "E";
        } else {
            $code = "-";
        }
        return $code;
    }
}
