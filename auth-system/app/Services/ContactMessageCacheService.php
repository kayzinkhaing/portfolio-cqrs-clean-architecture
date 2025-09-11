<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class ContactMessageCacheService extends MongoCacheService
{
    protected string $cacheKeyUnread;

    public function __construct()
    {
        parent::__construct('contact_messages');
        $this->cacheKeyUnread = 'contact_messages_unread';
    }

    // Only ContactMessage has unread filter
    public function fetchUnread(): array
    {
        return Cache::remember($this->cacheKeyUnread, now()->addMinutes(10), function () {
            $cursor = $this->getCollection()->find(['is_read' => false], ['sort' => ['created_at' => -1]]);
            $docs = iterator_to_array($cursor, false);

            return array_map([$this, 'mapDocument'], $docs);
        });
    }

    protected function mapDocument($doc): array
    {
        $doc = json_decode(json_encode($doc), true);

        return [
            'id'         => $doc['id'] ?? (string)($doc['_id'] ?? ''),
            'name'       => $doc['name'] ?? null,
            'email'      => $doc['email'] ?? null,
            'subject'    => $doc['subject'] ?? null,
            'message'    => $doc['message'] ?? null,
            'is_read'    => $doc['is_read'] ?? false,
            'created_at' => $doc['created_at'] ?? null,
            'updated_at' => $doc['updated_at'] ?? null,
        ];
    }
}
