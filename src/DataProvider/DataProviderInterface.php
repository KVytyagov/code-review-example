<?php
declare(strict_types=1);


namespace src\DataProvider;


interface DataProviderInterface
{
    /**
     * @param array $request
     *
     * @return array
     */
    public function get(array $request): array;
}
