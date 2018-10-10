<?php
declare(strict_types=1);


namespace src\RemoteServer;

use Psr\Log\LoggerInterface;

class RemoteServer implements DoRequestInterface
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $pwd;

    /**
     * @var null|LoggerInterface
     */
    private $logger;

    /**
     * RemoteServer constructor.
     *
     * @param string               $host
     * @param string               $user
     * @param string               $pwd
     * @param LoggerInterface|null $logger
     */
    public function __construct(string $host, string $user, string $pwd, LoggerInterface $logger = null)
    {
        $this->host = $host;
        $this->user = $user;
        $this->pwd = $pwd;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function doRequest(array $request): array
    {
        try {
            // TODO: Implement doRequest() method.
        } catch (\Throwable $e) {
            if (null !== $this->logger) {
                $msg = \sprintf('Error occurs while request to remote server with message "%s"', $e->getMessage());
                $this->logger->error($msg, [
                    'remoteServerHost' => $this->host,
                    'remoteServerUser' => $this->user,
                ]);
                throw $e;
            }
        }
    }
}
