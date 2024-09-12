<?php

namespace LuizFabianoNogueira\SseNotify\Events;

use LuizFabianoNogueira\SseNotify\Enums\SseEnumEvent;

/**
 * Class SseMessageSweet
 *
 * @category Notify
 *
 * @package App\Services\Sse
 *
 * @author Luiz Fabiano Nogueira
 */
class SseEventMessageSweet extends SseEvents
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
     * @var bool $confirm
     */
    public bool $confirm;

    /**
     * @var string $event
     */
    protected string $event = SseEnumEvent::MESSAGE_SWEET;

    /**
     * SseMessageSweet constructor.
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
            'confirm' => $this->confirm,
            'sse_notify_id' => $this->sse_notify_id,
        ];
    }
}
