<?php
declare(strict_types=1);


namespace src\DataProvider;


use src\RemoteServer\DoRequestInterface;

class RemoteServerDataProvider implements DataProviderInterface
{
    /**
     * @var DoRequestInterface
     */
    private $server;

    /**
     * RemoteServerDataProvider constructor.
     *
     * @param DoRequestInterface $server
     */
    public function __construct(DoRequestInterface $server)
    {
        $this->server = $server;
    }

    /**
     * {@inheritdoc}
     */
    public function get(array $request): array
    {
        return $this->server->doRequest($request);
    }
}
