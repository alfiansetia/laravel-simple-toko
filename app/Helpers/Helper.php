<?php

function hrg($angka)
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}
