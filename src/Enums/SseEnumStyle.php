<?php

namespace LuizFabianoNogueira\SseNotify\Enums;

/**
 * Class EnumJson
 *
 * @category Enum
 *
 * @package App\Enum
 *
 * @author Luiz Fabiano Nogueira <luizfabianonogueira>
 */
abstract class SseEnumStyle
{
    /**
     * Style error
     *
     * @var string
     */
    const string STYLE_ERROR = 'error';

    /**
     * Style success
     *
     * @var string
     */
    const string STYLE_SUCCESS = 'success';

    /**
     * Style warning
     *
     * @var string
     */
    const string STYLE_WARNING = 'warning';

    /**
     * Style info
     *
     * @var string
     */
    const string STYLE_INFO = 'info';

    /**
     * Style question
     *
     * @var string
     */
    const string STYLE_QUESTION = 'question';

    /**
     * Get styles
     *
     * @return array
     */
    public static function getStyles(): array
    {
        return [
            self::STYLE_ERROR,
            self::STYLE_SUCCESS,
            self::STYLE_WARNING,
            self::STYLE_INFO,
            self::STYLE_QUESTION,
        ];
    }
}
