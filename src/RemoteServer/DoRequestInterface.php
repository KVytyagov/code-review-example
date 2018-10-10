<?php
declare(strict_types=1);


namespace src\RemoteServer;


interface DoRequestInterface
{
    /**
     * @param array $request
     *
     * @return array
     */
    public function doRequest(array $request): array;
}
