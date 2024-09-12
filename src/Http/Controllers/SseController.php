<?php

namespace LuizFabianoNogueira\SseNotify\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Sse\Enums\SseEnumEvent;
use Illuminate\Http\Request;
use JsonException;
use LuizFabianoNogueira\SseNotify\SseNotifyService;

class SseController extends Controller
{
    /**
     * Connect to SSE
     *
     * @param Request $request
     * @param $user_id
     * @throws JsonException
     */
    public function connect(Request $request, $user_id): void
    {
        if ($user_id === null) {
            return;
        }

        $sseService = new SseNotifyService($user_id);
        $sseService->getHeaders();

        $sseService->insertFakeData(SseEnumEvent::INJECTION_SCRIPT, 10);

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
