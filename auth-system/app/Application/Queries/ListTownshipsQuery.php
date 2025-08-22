<?php
namespace App\Application\Queries;

class ListTownshipsQuery
{
    // Optional filter, e.g., by region or status (if needed)
    public ?int $regionId;

    public function __construct(?int $regionId = null)
    {
        $this->regionId = $regionId;
    }
}
