<?php

namespace LuizFabianoNogueira\SseNotify\Events;

use LuizFabianoNogueira\SseNotify\Models\SseNotify;
use LuizFabianoNogueira\SseNotify\Enums\SseEnumStyle;

/**
 * Class Sse
 *
 * This class represents a Server-Sent Event (SSE) with properties for sleep duration and date.
 *
 * @package App\Services\Sse\Events
 */
class SseEvents
{
    /**
     * @var int
     */
    public int $sleep = 3;

    /**
     * @var string $date
     */
    public string $date;

    /**
     * @var string $userId
     */
    public string $userId;

    /**
     * @var string $sse_notify_id
     */
    public string $sse_notify_id;

    public string $type;

    public function __construct()
    {
        $this->date = date('Y-m-d H:i:s');
        $this->sse_notify_id = '9cfdfe39-c7d6-4671-9e95-ebc29b1b64f7';
        $this->type = SseEnumStyle::STYLE_SUCCESS;
    }

    /**
     * @return string
     */
    public function getEvent(): string
    {
        return $this->event;
    }

    /**
     * @return int
     */
    public function getSleep(): int
    {
        return $this->sleep;
    }

    /**
     * Fill the object with the data
     *
     * @param array $data
     * @return void
     */
    public function fill(array $data): void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * Get the message data
     *
     * @return void
     */
    public function save(): void
    {
        $sseNotify = new SseNotify();
        $sseNotify->event = $this->getEvent();
        $sseNotify->type = $this->type;
        $sseNotify->data = $this->getMessageData();
        $sseNotify->user_id = $this->userId;
        $sseNotify->save();
    }
}
