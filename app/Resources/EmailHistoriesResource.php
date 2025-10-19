<?php

namespace App\Resources;

use JsonSerializable;

class EmailHistoriesResource implements JsonSerializable
{
    protected $resource;

    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return [
            'id'                => $this->resource['id'],
            'code'              => $this->resource['code'],
            'recipient'         => $this->resource['recipient'],
            'cc'                => $this->resource['cc'],
            'bcc'               => $this->resource['bcc'],
            'subject'           => $this->resource['subject'],
            'body'              => $this->resource['body'],
            'error_message'     => $this->resource['error_message'],
            'status'            => $this->resource['status'],
            'sent_at'           => $this->resource['sent_at'],
            'resent_times'      => $this->resource['resent_times'],
            'deleted_at'        => $this->resource['deleted_at'],
            'updated_at'        => $this->resource['updated_at'],
            'created_at'        => $this->resource['created_at'],
        ];
    }

    public static function collection(array $items): array
    {
        return array_map(fn($item) => (new static($item))->toArray(), $items);
    }
}

