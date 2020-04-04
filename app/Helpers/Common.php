<?php

use Illuminate\Support\Carbon;

function listYear()
{
    return range(
        (int) date('Y', strtotime('-5 years')),
        (int) date('Y')
    );
}

function listMonth()
{
    $month = [
        [
            'id' => 1,
            'month' => 'Januari'
        ],
        [
            'id' => 2,
            'month' => 'Februari'
        ],
        [
            'id' => 3,
            'month' => 'Maret'
        ],
        [
            'id' => 4,
            'month' => 'April'
        ],
        [
            'id' => 5,
            'month' => 'Mei'
        ],
        [
            'id' => 6,
            'month' => 'Juni'
        ],
        [
            'id' => 7,
            'month' => 'Juli'
        ],
        [
            'id' => 8,
            'month' => 'Agustus'
        ],
        [
            'id' => 9,
            'month' => 'September'
        ],
        [
            'id' => 10,
            'month' => 'Oktober'
        ],
        [
            'id' => 11,
            'month' => 'November'
        ],
        [
            'id' => 12,
            'month' => 'Desember'
        ]
    ];
    return $month;
}

function dateFormat($date, $time = false)
{
    if ($time) {
        return Carbon::parse($date)->format('d-m-Y H:i');
    }
    return Carbon::parse($date)->format('d-m-Y');
}

function rupiahConverter($number, $right = true, $reverse = false)
{
    if($reverse) {
        return (int)str_replace('.', '', $number);
    } else {
        if ($right) {
            return '<span class="float-right">'.number_format($number, 0, '.', '.').'</span>';
        } else {
            return number_format($number, 0, '.', '.');
        }
    }
} 
