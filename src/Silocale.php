<?php

namespace Przeslijmi\Silocale;

use Przeslijmi\Silocale\Exceptions\AcceptLanguageHeaderException;

/**
 * Simple localization tool for PHP.
 */
class Silocale
{

    /**
     * Which lang to use.
     *
     * @var string
     */
    private $lang = 'en-us';

    /**
     * Array with locales.
     *
     * @var array
     */
    private $locales = [];

    /**
     * Constructor.
     *
     * @param array  $localeDirUris Array with dirs in which locale files are held.
     * @param string $forcedLang    Optional, empty. Forced language choosen - overriding header.
     *
     * @throws AcceptLanguageHeaderException When malformed header is sent.
     */
    public function __construct(array $localeDirUris, string $forcedLang = null)
    {

        // Get header.
        $header = explode(',', ( $forcedLang ?? getallheaders()['Accept-Language'] ?? 'en-us' ));
        $header = trim($header[0]);

        // Test if is short version.
        preg_match('/^([a-z]{2})$/', $header, $regexTest);

        // Expand.
        if (count($regexTest) === 2) {
            $header = $header . '-' . $header;
        }

        // Final test.
        preg_match('/^([a-z]{2}\-[a-z]{2})$/', $header, $regexTest);

        // Verify.
        if (count($regexTest) !== 2) {
            throw new AcceptLanguageHeaderException($header);
        }

        // Save language.
        $this->lang = $header;

        // Include fiels.
        foreach ($localeDirUris as $dirUri) {

            // Convert slashes.
            $dirUri = rtrim(str_replace('\\', '/', $dirUri), '/') . '/';

            // Require files.
            foreach ($this->findFiles($dirUri, $this->lang) as $fileUri) {

                // Lvd.
                $prefix          = null;
                $includedLocales = include $fileUri;
                $locales         = [];

                // Add prefix.
                if ($prefix !== null) {
                    foreach ($includedLocales as $id => $locale) {
                        $locales[$prefix . '.' . $id] = $locale;
                    }
                } else {
                    $locales = $includedLocales;
                }

                // Merge with whole warehouse.
                $this->locales = array_merge($this->locales, $locales);

                // Free memory.
                unset($includedLocales);
                unset($locales);
            }
        }
    }

    /**
     * Getter for message id.
     *
     * @param string $mid     Message id.
     * @param array  $sprintf Optional, if given `sprintf` with this params is fired.
     *
     * @return string
     */
    public function get(string $mid, array $sprintf = []): string
    {

        // Get message.
        $message = ( $this->locales[$mid] ?? $mid );

        if (is_array($message) === true && isset($message['redirect']) === true) {
            return $this->get($message['redirect'], $sprintf);
        }

        // Sprintf if needed.
        if (count($sprintf) > 0) {
            $message = sprintf($message, ...$sprintf);
        }

        return $message;
    }

    /**
     * Get array of fitting locale basing on given prefix.
     *
     * @param string $prefix Prefix (beginnign of message id) used as a pattern.
     *
     * @return array
     */
    public function getSub(string $prefix)
    {

        // Lvd.
        $result = [];
        $prefix = ( rtrim($prefix, '.') . '.' );
        $strlen = mb_strlen($prefix);

        // Find matching message id's.
        foreach ($this->locales as $mid => $message) {
            if (substr($mid, 0, $strlen) === $prefix) {
                $result[substr($mid, $strlen)] = $message;
            }
        }

        return $result;
    }

    /**
     * Find locale files inside given dir.
     *
     * @param string $dirUri Dir to search in.
     *
     * @return array
     */
    private function findFiles(string $dirUri, string $lang): array
    {

        // Lvd.
        $result = [];

        // Scan directory.
        $dh = opendir($dirUri);
        while (( $element = readdir($dh) ) !== false) {
            if (
                $element !== '.'
                && $element !== '..'
                && is_file($dirUri . $element) === true
                && mb_substr($element, -4) === '.php'
                && mb_substr($element, 0, 6) === ( $lang . '.' )
            ) {
                $result[] = $dirUri . $element;
            }
        }

        return $result;
    }
}
