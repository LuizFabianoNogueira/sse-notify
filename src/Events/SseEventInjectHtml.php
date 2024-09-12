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
class SseEventInjectHtml extends SseEvents
{
    /**
     * @var string $html
     */
    public string $html;

    /**
     * @var string $target
     */
    public string $target;

    /**
     * @var string $event
     */
    public string $event = SseEnumEvent::INJECTION_HTML;

    /**
     * @var bool $append
     */
    public bool $append = false;

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
            'html' => $this->html,
            'target' => $this->target,
            'append' => $this->append,
            'sse_notify_id' => $this->sse_notify_id,
        ];
    }
}
