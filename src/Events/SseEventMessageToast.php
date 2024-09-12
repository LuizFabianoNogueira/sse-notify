<?php

namespace LuizFabianoNogueira\SseNotify\Events;

use LuizFabianoNogueira\SseNotify\Enums\SseEnumEvent;

/**
 * Class SseMessageToast
 *
 * @category Notify
 *
 * @package App\Services\Sse
 *
 * @author Luiz Fabiano Nogueira
 */
class SseEventMessageToast extends SseEvents
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
     * @var string|null
     */
    public string|null  $imgURL;

    /**
     * @var string|null
     */
    public string|null $linkURL;

    /**
     * @var string|null $linkText
     */
    public string|null $linkText;

    /**
     * @var string $event
     */
    public string $event = SseEnumEvent::MESSAGE_TOAST;


    /**
     * SseMessageToast constructor.
     *
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
     * Get message data
     *
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
            'imgURL' => $this->imgURL,
            'linkURL' => $this->linkURL,
            'linkText' => $this->linkText,
            'sse_notify_id' => $this->sse_notify_id,
        ];
    }
}
