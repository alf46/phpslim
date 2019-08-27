<?php

function jsonResponse($response, $result){
    return $response->withStatus(200)
    ->withHeader('Content-Type', 'application/json')
    ->write(json_encode($result));
}

?>