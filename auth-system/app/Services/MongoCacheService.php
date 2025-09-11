<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use MongoDB\Client;

abstract class MongoCacheService
{
    protected Client $mongo;
    protected string $collectionName;

    public function __construct(string $collectionName)
    {
        $this->mongo = MongoService::getClient();
        $this->collectionName = $collectionName;
    }

    protected function getCollection()
    {
        return $this->mongo
            ->selectDatabase('read_model')
            ->selectCollection($this->collectionName);
    }

    /**
     * Paginate documents from MongoDB
     */
    // app/Services/MongoCacheService.php

public function paginate(int $page = 1, int $perPage = 10): array
{
    $skip = ($page - 1) * $perPage;
    $collection = $this->getCollection();

    $cursor = $collection->find(
        [],
        ['skip' => $skip, 'limit' => $perPage, 'sort' => ['created_at' => -1]]
    );

    $items = iterator_to_array($cursor, false);

    $total = $collection->countDocuments();
    $lastPage = (int) ceil($total / $perPage);

    return [
        'data'      => array_map([$this, 'mapDocument'], $items),
        'current'   => $page,
        'per_page'  => $perPage,
        'total'     => $total,
        'last_page' => $lastPage,
    ];
}


    /**
     * Fetch all (use carefully for small datasets)
     */
    public function fetchAll(): array
    {
        return Cache::remember("{$this->collectionName}_all", now()->addMinutes(10), function () {
            $cursor = $this->getCollection()->find([], ['sort' => ['created_at' => -1]]);
            $docs = iterator_to_array($cursor, false);

            return array_map([$this, 'mapDocument'], $docs);
        });
    }

    /**
     * Refresh all cache entries
     */
    public function refreshCache(): void
    {
        // Forget all keys (all + paginated)
        Cache::forget("{$this->collectionName}_all");

        // Optional: clear paginated caches too
        // (if you use tagged cache, easier)
    }

    /**
     * Find one by id
     */
    public function find(string|int $id): ?array
    {
        $doc = $this->getCollection()->findOne(['id' => (int)$id]);
        return $doc ? $this->mapDocument($doc) : null;
    }

    /**
     * Every service must define mapping
     */
    abstract protected function mapDocument($doc): array;
}
