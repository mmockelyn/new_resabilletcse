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
        $users = User::where('group', 'admin')->orWhere('group', 'agent')->get();

        foreach ($users as $user) {
            \Log::$type($message);
        }
    }

    public static function getTypeTitle($type)
    {
        switch ($type) {
            case 'emergency': return 'Urgence';
            case 'alert': return 'Alerte';
            case 'critical': return 'Critique';
            case 'error': return 'Erreur';
            case 'warning': return 'Avertissement';
            case 'notice': return 'Notice';
            case 'info': return 'Information';
            default: return 'Debug';
        }
    }
}
