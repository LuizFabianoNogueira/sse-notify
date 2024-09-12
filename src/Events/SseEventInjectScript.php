<?php

namespace LuizFabianoNogueira\SseNotify\Events;

use LuizFabianoNogueira\SseNotify\Enums\SseEnumEvent;

/**
 * Class SseInjectHtml
 *
 * @category Notify
 *
 * @package App\Services\Sse
 *
 * @author Luiz Fabiano Nogueira
 */
class SseEventInjectScript extends SseEvents
{
    /**
     * @var string $script
     */
    public string $script;

    /**
     * @var string $event
     */
    public string $event = SseEnumEvent::INJECTION_SCRIPT;

    /**
     * SseInjectHtml constructor.
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
     * @return string[]
     */
    public function getMessageData(): array
    {
        return [
            'script' => $this->script,
            'sse_notify_id' => $this->sse_notify_id,
        ];
    }
}
