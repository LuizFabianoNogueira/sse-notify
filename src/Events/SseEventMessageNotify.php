<?php

namespace LuizFabianoNogueira\SseNotify\Events;

use LuizFabianoNogueira\SseNotify\Enums\SseEnumEvent;

/**
 * Class SseMessageNotify
 *
 * @category Notify
 *
 * @package App\Services\Sse
 *
 * @author Luiz Fabiano Nogueira
 */
class SseEventMessageNotify extends SseEvents
{
    /**
     * @var int $id
     */
    public int $id;

    /**
     * @var string $type
     */
    public string $type;

    /**
     * @var string $title
     */
    public string $title;

    /**
     * @var string $message
     */
    public string $message;

    /**
     * @var bool $autoClose
     */
    public bool $autoClose;

    /**
     * @var string $event
     */
    protected string $event = SseEnumEvent::MESSAGE_NOTIFY;


    /**
     * @param $data
     */
    public function __construct($data)
    {
        parent::__construct();
        if ($data) {
            $this->fill($data);
        }
    }

    /**
     * @return string[]
     */
    public function getMessageData(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
            'message' => $this->message,
            'autoClose' => $this->autoClose,
            'date' => $this->date,
            'sse_notify_id' => $this->sse_notify_id,
        ];
    }
}
