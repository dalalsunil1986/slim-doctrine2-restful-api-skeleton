<?php
use Slim\Http\Request;
use Slim\Http\Response;

$app->post('/record', App\Action\RecordAddAction::class)
    ->setName('rd');
