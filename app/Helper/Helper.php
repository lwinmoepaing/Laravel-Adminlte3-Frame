<?php

namespace App\Helper;

if (! function_exists('appointmentStatusBackground')) {
    function appointmentStatusBackground($status)
    {
        switch ($status) {
            case 1:
                return 'primiary';
            case 2:
                return 'success';
            case 3:
                return 'danger';
            default:
               return 'secondary';
        }
    }
}
