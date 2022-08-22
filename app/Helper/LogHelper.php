<?php

namespace App\Helper;

use App\Models\User\User;

class LogHelper
{
    /**
     * @param $type
     * @param $message
     * @return void
     */
    public static function notify($type, $message)
    {
        \Log::$type($message);
    }

    public static function getTypeTitle($type)
    {
        return match ($type) {
            'emergency' => 'Urgence',
            'alert' => 'Alerte',
            'critical' => 'Critique',
            'error' => 'Erreur',
            'warning' => 'Avertissement',
            'notice' => 'Notice',
            'info' => 'Information',
            default => 'Debug',
        };
    }
}
