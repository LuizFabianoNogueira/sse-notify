<?php

namespace LuizFabianoNogueira\SseNotify\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JsonException;
use LuizFabianoNogueira\SseNotify\Enums\SseEnumEvent;
use LuizFabianoNogueira\SseNotify\SseNotifyService;

class SseController extends Controller
{
    /**
     * Connect to SSE
     *
     * @param Request $request
     * @param $userId
     * @return void
     * @throws JsonException
     */
    public function connect(Request $request, $userId): void
    {
        if ($userId) {
            $sseService = new SseNotifyService($userId);
            $sseService->getHeaders();

            while (true) {

                # Close connection after 3 minute
                if ($sseService->closeIfTimeExpired(3, true)) {
                    break;
                }

                $objectSseNotify = $sseService->getNewMessage();
                if ($objectSseNotify) {
                    $sseService->sendEvent($sseService->loadObjectData($objectSseNotify));
                } else {
                    # sleep for 10 seconds
                    sleep(10);
                }
            }
        }
    }

    /**
     * @return void
     */
    public function generateFakeData(Request $request, $userId): void
    {
        if ($userId) {
            $sseService = new SseNotifyService($userId);
            $sseService->insertFakeData(SseEnumEvent::INJECTION_SCRIPT, 1);
            $sseService->insertFakeData(SseEnumEvent::MESSAGE_TOAST, 1);
            $sseService->insertFakeData(SseEnumEvent::MESSAGE_SWEET, 1);
            $sseService->insertFakeData(SseEnumEvent::MESSAGE_NOTIFY, 1);
        }
    }
}
