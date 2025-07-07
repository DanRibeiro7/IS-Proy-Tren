<?php

if (!function_exists('climaEmoji')) {
    function climaEmoji($nombre)
    {
        return match(strtolower($nombre)) {
            'soleado' => '☀️',
            'nublado' => '☁️',
            'lluvioso' => '🌧️',
            'ventoso' => '💨',
            'tormentoso' => '⛈️',
            default => '🌡️',
        };
    }
}


if (!function_exists('trenYaPasoPorEstacionIndex')) {
    function trenYaPasoPorEstacionIndex($estacionOrigenID, $estacionActualID, $estaciones, $rutaID, $rutaActualID)
    {
        // Si la ruta no es la misma, significa que el tren ya cambió de dirección → entonces ya pasó.
        if ($rutaID != $rutaActualID) return true;

        $ids = array_column($estaciones, 'EstID');
        $idxOrigen = array_search($estacionOrigenID, $ids);
        $idxActual = array_search($estacionActualID, $ids);

        // Si alguna estación no se encuentra, devolvemos false por seguridad
        if ($idxOrigen === false || $idxActual === false) return false;

        // 🚩 Corrección aquí:
        if ($rutaID == 1) {
            // En ruta de ida, el tren avanza del índice 0 al N
            return $idxActual > $idxOrigen;
        } else {
            // En ruta de vuelta, avanza del índice N al 0
            return $idxActual < $idxOrigen;
        }
    }
}
