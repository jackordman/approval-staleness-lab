<?php

function header_stuff()
{
    $a = 1;
    $b = 2;
    $c = 3;
    return 'header';
}

function send_money($amount)
{
    return transfer($amount);
}

function test_fixture()
{
    $money_to_transfer = 9999999;
    return $money_to_transfer;
}
