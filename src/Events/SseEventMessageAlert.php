<?php

namespace LuizFabianoNogueira\SseNotify\Events;

use LuizFabianoNogueira\SseNotify\Enums\SseEnumEvent;

/**
 * Class SseMessageAlert
 *
 * @category Notify
 *
 * @package App\Services\Sse
 *
 * @author Luiz Fabiano Nogueira
 */
class SseEventMessageAlert extends SseEvents
{
    /**
     * @var string $event
     */
    protected string $event = SseEnumEvent::MESSAGE_ALERT;

    /**
     * @var string $message
     */
    public string $message;

    /**
     * SseMessageAlert constructor.
     *
     * @param $data
     */
    public function __construct($data = null)
    {
        parent::__construct();
        if ($data) {
            $this->fill($data);
        }
    }

    /**
     * @return int
     */
    public function getSleep(): int
    {
        return $this->sleep;
    }

    /**
     * @return string[]
     */
    public function getMessageData(): array
    {
        return [
            'message' => $this->message,
            'sse_notify_id' => $this->sse_notify_id
        ];
    }


}
