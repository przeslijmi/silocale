<?php declare(strict_types=1);

namespace Przeslijmi\Silocale\Exceptions;

use Exception;

/**
 * When malformed header is sent.
 */
class AcceptLanguageHeaderException extends Exception
{

    /**
     * Constructor.
     *
     * @param string $header Contents of header `Accept-Language`.
     */
    public function __construct(string $header)
    {

        // Lvd.
        $args    = func_get_args();
        $args[0] = 'Wrong language header was used: ' . $header;

        // Call Exception.
        parent::__construct(...$args);
    }
}
