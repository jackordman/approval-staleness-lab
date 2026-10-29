<?php

function header_stuff()
{
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
