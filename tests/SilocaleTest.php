<?php declare(strict_types=1);

namespace Przeslijmi\Silocale;

use PHPUnit\Framework\TestCase;
use Przeslijmi\Silocale\Exceptions\AcceptLanguageHeaderException;
use Przeslijmi\Silocale\Silocale;


/**
 * Testing Silocale.
 */
final class SilocaleTest extends TestCase
{

    /**
     * Test proper string and pattern and assert true.
     *
     * @return void
     */
    public function testIfWorks() : void
    {

        // Create
        $loc = new Silocale([ 'resources/forTesting/' ], 'en-us');

        // Get translation for given message id.
        $this->assertEquals('Simple test', $loc->get('silocale.test.simple'));
        $this->assertEquals('Hello John!', $loc->get('silocale.test.sprintf', [ 'John' ]));
        $this->assertEquals('silocale.unknown', $loc->get('silocale.unknown'));
    }

    /**
     * Test proper string and pattern and assert true.
     *
     * @return void
     */
    public function testIfShortLocaleWorks() : void
    {

        // Create
        $loc = new Silocale([ 'resources/forTesting/' ], 'pl');

        // Get translation for given message id.
        $this->assertEquals('Prosty test', $loc->get('silocale.test.simple'));
        $this->assertEquals('Cześć John!', $loc->get('silocale.test.sprintf', [ 'John' ]));
        $this->assertEquals('silocale.unknown', $loc->get('silocale.unknown'));
    }

    /**
     * Test if malformed header throws.
     *
     * @return void
     */
    public function testIfMalformedHeaderThrows() : void
    {

        // Prepare.
        $this->expectException(AcceptLanguageHeaderException::class);

        // Create
        $loc = new Silocale([ 'resources/forTesting/' ], 'xx-xxx');
    }
}
