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
}
