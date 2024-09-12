<?php

namespace LuizFabianoNogueira\SseNotify\Enums;

use ReflectionException;

/**
 * Class SseEnumEvent
 *
 * @category Notify
 *
 * @package App\Services\Sse
 *
 * @author Luiz Fabiano Nogueira
 */
abstract class SseEnumEvent extends SseEnum
{
    /**
     * Message alert event constant
     */
    const string MESSAGE_ALERT = 'messageAlert';

    /**
     * Message sweet event constant
     */
    const string MESSAGE_SWEET = 'messageSweet';

    /**
     * Message toast event constant
     */
    const string MESSAGE_TOAST = 'messageToast';

    /**
     * Message notify event constant
     */
    const string MESSAGE_NOTIFY = 'messageNotify';

    /**
     * Injection html event constant
     */
    const string INJECTION_HTML = 'injectionHtml';

    /**
     * Injection script event constant
     */
    const string INJECTION_SCRIPT = 'injectionScript';

    /**
     * @throws ReflectionException
     */
    public static function getAll(): array
    {
        $list = self::getConstants(__CLASS__);
        asort($list);
        return $list;
    }
}
