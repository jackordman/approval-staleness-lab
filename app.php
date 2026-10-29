<?php

function header_stuff()
{
    return 'header';
}

function send_money($amount)
{
    $money_to_transfer = 9999999;
    return transfer($amount);
}

function test_fixture()
{
    return $money_to_transfer;
}
