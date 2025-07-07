<?php


if (!function_exists('trenYaPasoPorEstacionIndex')) {
    function trenYaPasoPorEstacionIndex($estacionOrigenID, $estacionActualID, $estaciones, $rutaID, $rutaActualID)
    {
        if ($rutaID != $rutaActualID) return true;

        $ids = array_column($estaciones, 'EstID');
        $idxOrigen = array_search($estacionOrigenID, $ids);
        $idxActual = array_search($estacionActualID, $ids);

        if ($idxOrigen === false || $idxActual === false) return false;

        if ($rutaID == 1) {
            return $idxActual > $idxOrigen;
        } else {
            return $idxActual < $idxOrigen;
        }
    }
}
