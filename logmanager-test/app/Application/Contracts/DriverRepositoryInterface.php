<?php

namespace App\Application\Contracts;

use Illuminate\Support\Collection;

interface DriverRepositoryInterface
{
    public function listWithStats(?string $startDate = null, ?string $endDate = null): Collection;
}
