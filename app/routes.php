<?php
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * POST
 * Body: JSON array e.g. [r1, r2]
 */
$app->post('/record', function (Request $request, Response $response) {
    $data = json_decode($request->getBody(), 1);
    $this->get('providerService')->addFromArray($data);
    $response->getBody()->write('Completed ');

    return $response;
});
