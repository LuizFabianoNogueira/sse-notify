<?php

namespace LuizFabianoNogueira\SseNotify;

use JsonException;
use LuizFabianoNogueira\SseNotify\Enums\SseEnumStyle;
use LuizFabianoNogueira\SseNotify\Models\SseNotify;
use LuizFabianoNogueira\SseNotify\Enums\SseEnumEvent;
use LuizFabianoNogueira\SseNotify\Events\SseEventInjectHtml;
use LuizFabianoNogueira\SseNotify\Events\SseEventInjectScript;
use LuizFabianoNogueira\SseNotify\Events\SseEventMessageAlert;
use LuizFabianoNogueira\SseNotify\Events\SseEventMessageNotify;
use LuizFabianoNogueira\SseNotify\Events\SseEventMessageSweet;
use LuizFabianoNogueira\SseNotify\Events\SseEventMessageToast;

/**
 * Class SseService
 *
 * @category Sse
 *
 * @package App\Services\Sse
 *
 * @author Luiz Fabiano Nogueira
 */
class SseNotifyService
{
    /**
     * @var string
     */
    public string $dateStart;

    /**
     * @var string $userId
     */
    public string $userId;

    /**
     * SseService constructor.
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
        $this->dateStart = date('Y-m-d H:i:s');
    }

    /**
     * @param int $minutes
     * @param bool $reload
     * @return bool
     * @throws JsonException
     */
    public function closeIfTimeExpired(int $minutes, bool $reload = false): bool
    {
        if (strtotime($this->dateStart . " +$minutes minutes") < time()) {
            $this->responseData('close', ['reload' => $reload]);
            return true;
        }
        return false;
    }

    /**
     * @param object $objMessage
     * @return void
     * @throws JsonException
     */
    public function sendEvent(object $objMessage): void
    {
        $this->responseData($objMessage->getEvent(), $objMessage->getMessageData(), $objMessage->getSleep());
    }

    /**
     * @param $event
     * @param $data
     * @param int $sleep
     * @return void
     * @throws JsonException
     */
    private function responseData($event, $data, int $sleep = 3): void
    {
        echo "event:".$event."\n";
        echo "data: " . json_encode($data, JSON_THROW_ON_ERROR) . "\n\n";
        ob_flush();
        flush();
        sleep($sleep);

        $this->setMessageRead($data['sse_notify_id']??'9cfdfe39-c7d6-4671-9e95-ebc29b1b64f7');
    }

    /**
     * Add headers to the response
     *
     * @param bool $contentType
     * @param bool $cacheControl
     * @param bool $connection
     * @param bool $accessControlAllowOrigin
     * @param array $headersExtra
     *
     * @return void
     *
     * @example
     *  Exemple of use:
     *
     *  setHeaders(true, true, false, true, [
     *      'X-Custom-Header' => 'CustomValue',
     *      'X-Another-Header' => 'AnotherValue'
     *  ]);
     */
    public function getHeaders(bool $contentType = true, bool $cacheControl = true, bool $connection = true, bool $accessControlAllowOrigin = true, array $headersExtra = []): void
    {
        if($contentType) {
            header('Content-Type: text/event-stream');
        }
        if($cacheControl) {
            header('Cache-Control: no-cache');
        }
        if($connection) {
            header('Connection: keep-alive');
        }
        if($accessControlAllowOrigin) {
            header('Access-Control-Allow-Origin: *');
        }

        if(is_array($headersExtra) && empty($headersExtra) > 0) {
            foreach ($headersExtra as $key => $header) {
                header($key.":".$header);
            }
        }
    }

    /**
     * Get new message
     *
     * @return mixed
     */
    public function getNewMessage(): mixed
    {
        return SseNotify::where('user_id', $this->userId)->where('read', false)->orderBy('created_at') ->first();
    }

    /**
     * Set message as read
     *
     * @param $id
     * @return void
     */
    public function setMessageRead($id): void
    {
        SseNotify::where('id', $id)->update(['read' => true]);
    }

    /**
     * Load object data
     *
     * @param SseNotify $sseNotify
     * @return SseEventMessageAlert|SseEventMessageNotify|SseEventMessageSweet|SseEventMessageToast|SseEventInjectHtml|SseEventInjectScript
     */
    public function loadObjectData(SseNotify $sseNotify) : SseEventMessageAlert|SseEventMessageNotify|SseEventMessageSweet|SseEventMessageToast|SseEventInjectHtml|SseEventInjectScript
    {
        $data = $sseNotify->data;
        $data['id'] = $data->id??time();
        $data['userId'] = $sseNotify->user_id;
        $data['event'] = $sseNotify->event;
        $data['sse_notify_id'] = $sseNotify->id;

        return match ($sseNotify->event) {

            SseEnumEvent::MESSAGE_ALERT => new SseEventMessageAlert($data),
            SseEnumEvent::MESSAGE_NOTIFY => new SseEventMessageNotify($data),
            SseEnumEvent::MESSAGE_SWEET => new SseEventMessageSweet($data),
            SseEnumEvent::MESSAGE_TOAST => new SseEventMessageToast($data),
            SseEnumEvent::INJECTION_HTML => new SseEventInjectHtml($data),
            SseEnumEvent::INJECTION_SCRIPT => new SseEventInjectScript($data),
            default => new SseEventMessageAlert([
                'message' => 'Error - event not found! ',
                'userId' => $this->userId
            ]),
        };
    }

    public function insertFakeData(SseEnumEvent|string $event, $loop = 1): void
    {
        try {
            for ($i = 0; $i < $loop; $i++) {

                # Generate javascript alert
                if ($event === SseEnumEvent::MESSAGE_ALERT) {
                    $sseMessageAlert = new SseEventMessageAlert([
                        'message' => 'Notify Alert! - ' . $i,
                        'userId' => $this->userId
                    ]);
                    $sseMessageAlert->save();
                }

                # Generate SweetAlert2
                if ($event === SseEnumEvent::MESSAGE_SWEET) {
                    $data = [
                        'title' => 'Notify title Sweet! - ' . $i,
                        'message' => 'Notify message Sweet! - ' . $i,
                        'type' => SseEnumStyle::STYLE_SUCCESS,
                        'id' => time(),
                        'autoClose' => false,
                        'confirm' => false,
                        'userId' => $this->userId
                    ];
                    (new SseEventMessageSweet($data))->save();

                    $data['type'] = SseEnumStyle::STYLE_ERROR;
                    (new SseEventMessageSweet($data))->save();

                    $data['type'] = SseEnumStyle::STYLE_WARNING;
                    (new SseEventMessageSweet($data))->save();

                    $data['type'] = SseEnumStyle::STYLE_INFO;
                    (new SseEventMessageSweet($data))->save();
                }

                if ($event === SseEnumEvent::MESSAGE_NOTIFY) {
                    $data = [
                        'title' => 'Notify title notify! - ' . $i,
                        'message' => 'Notify message notify! - ' . $i,
                        'type' => SseEnumStyle::STYLE_SUCCESS,
                        'id' => time(),
                        'autoClose' => true,
                        'userId' => $this->userId
                    ];
                    (new SseEventMessageNotify($data))->save();

                    $data['type'] = SseEnumStyle::STYLE_ERROR;
                    (new SseEventMessageNotify($data))->save();

                    $data['type'] = SseEnumStyle::STYLE_WARNING;
                    (new SseEventMessageNotify($data))->save();

                    $data['type'] = SseEnumStyle::STYLE_INFO;
                    (new SseEventMessageNotify($data))->save();
                }

                if ($event === SseEnumEvent::MESSAGE_TOAST) {
                    $data = [
                        'title' => 'Notify title toast! - ' . $i,
                        'message' => 'Notify message toast! - ' . $i,
                        'type' => SseEnumStyle::STYLE_SUCCESS,
                        'id' => time(),
                        'autoClose' => true,
                        'userId' => $this->userId,
                        'imgURL' => '/android-chrome-192x192.png',
                        'linkURL' => 'https://www.google.com',
                        'linkText' => 'Google'
                    ];
                    (new SseEventMessageToast($data))->save();

                    $data['type'] = SseEnumStyle::STYLE_ERROR;
                    (new SseEventMessageToast($data))->save();

                    $data['type'] = SseEnumStyle::STYLE_WARNING;
                    (new SseEventMessageToast($data))->save();

                    $data['type'] = SseEnumStyle::STYLE_INFO;
                    (new SseEventMessageToast($data))->save();
                }

                if ($event === SseEnumEvent::INJECTION_HTML) {
                    (new SseEventInjectHtml([
                        'html' => '<div class="alert alert-success">Notify message! - ' . $i . '</div>',
                        'target' => 'boxTestes',
                        'userId' => $this->userId
                    ]))->save();
                }

                if ($event === SseEnumEvent::INJECTION_SCRIPT) {
                    (new SseEventInjectScript([
                        'script' => 'console.log("Notify message! - ' . $i . '")',
                        'userId' => $this->userId
                    ]))->save();
                }

            }
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }

    }
}
