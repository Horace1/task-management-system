<?php

if (!function_exists('getGreeting')) {
    function getGreeting()
    {
        $hour = now()->format('H');
        if ($hour < 12) {
            return 'Good Morning';
        } elseif ($hour < 18) {
            return 'Good Afternoon';
        }
        return 'Good Evening';
    }
}

