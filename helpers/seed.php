<?php

function makePasswordHash($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

function verifyPassword($password, $hash)
{
    return password_verify($password, $hash);
}

function printPasswordHash($password = '123456')
{
    echo password_hash($password, PASSWORD_DEFAULT);
}
