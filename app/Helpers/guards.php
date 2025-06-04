<?php
if (!function_exists('get_current_guard')) {
    /**
     * Get the name of the currently authenticated guard
     *
     * @return string|null
     */
    function get_current_guard(): ?string
    {

        $activeGuard = session('active_guard');

        if ($activeGuard && auth($activeGuard)->check()) {
            return $activeGuard;
        }

        return null;
    }
    function get_all_guards(): ?array
    {
        $configured = array_keys(config('auth.guards', []));
        $guards = [];
        for ($i = 0; $i<count($configured); $i++) {
            if( $configured[$i] === "web" || $configured[$i] === "sanctum" ) continue;
            array_push($guards,$configured[$i]);
        }

        return $guards;
    }
}
