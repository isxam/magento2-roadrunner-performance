<?php

ini_set('display_errors', 'stderr');

use Isxam\M2RoadRunner\Application\ApplicationInterface;
use Spiral\Goridge\StreamRelay;
use Spiral\RoadRunner\PSR7Client;
use Spiral\RoadRunner\Worker;

require __DIR__ . '/app/bootstrap.php';
ini_set('display_errors', 'stderr');

$relay = new StreamRelay(STDIN, STDOUT);
$psr7 = new PSR7Client(new Worker($relay));

$bootstrap = \Magento\Framework\App\Bootstrap::create(BP, []);
/** @var \Magento\Framework\App\Http $app */
$app = $bootstrap->createApplication(\Magento\Framework\App\Http::class);

/** @var ApplicationInterface $psr7Application */
$psr7Application = $bootstrap->getObjectManager()->create(
    \Isxam\M2RoadRunner\Application\MagentoAppWrapper::class,
    [
        'magentoApp' => $app
    ]
);

while ($request = $psr7->acceptRequest()) {
    try {
        $response = $psr7Application->handle($request);

        $psr7->respond($response);
    } catch (\Throwable $e) {
        $psr7->getWorker()->error((string)$e);
    }
}
