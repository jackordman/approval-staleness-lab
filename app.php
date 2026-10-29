<?php

function header_stuff()
{
    $a = 1;
    $b = 2;
    $c = 3;
    $a = 1;
    $b = 2;
    $c = 3;
    return 'header';
}

function send_money($amount)
{
    check_a($amount);
    check_b($amount);
    return transfer($amount);
}

function test_fixture_v2()
{
    $money_to_transfer = 1;
    return $money_to_transfer;
}
