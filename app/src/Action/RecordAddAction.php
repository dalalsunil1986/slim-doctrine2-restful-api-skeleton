<?php
namespace App\Action;

use App\Service\ProviderService;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class RecordAddAction
{
    /**
     * @var ProviderService
     */
    private $providerService;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(ProviderService $providerService, LoggerInterface $logger)
    {
        $this->providerService = $providerService;
        $this->logger = $logger;
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        $data = json_decode($request->getBody(), 1);
        $this->providerService->addFromArray($data);
        $this->logger->info('completed');
        $response->getBody()->write('Completed ');

        return $response;
    }
}
