<?php

function responseOne(mixed $data)
{
    return response([
        'data' => $data
    ]);
}

function responseList(array $listData)
{
    return response([
        'data' => $listData['data'],
        'meta' => $listData['meta']
    ]);
}