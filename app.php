<?php

function header_stuff()
{
    return 'header';
}

function send_money($amount)
{
    check_a($amount);
    check_b($amount);
    return transfer($amount);
}

function test_fixture()
{
    $money_to_transfer = 1;
    return $money_to_transfer;
}
