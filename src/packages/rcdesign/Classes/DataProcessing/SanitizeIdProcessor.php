<?php

declare(strict_types=1);

/*
 * (c) 2025 rc design visual concepts (rc-design.at)
 * _________________________________________________
 * The TYPO3 project - inspiring people to share!
 * _________________________________________________
 */

namespace Rcdesign\Rcdesign\DataProcessing;

use TYPO3\CMS\Core\Charset\CharsetConverter;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

class SanitizeIdProcessor implements DataProcessorInterface
{
    // public function __construct() {}
    public function __construct(
        protected readonly CharsetConverter $charsetConverter
    ) {}

    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ): array {
        $sourceField = $processorConfiguration['field'] ?? '';
        $targetField = $processorConfiguration['as'] ?? $sourceField . 'Ascii';

        // Prüfen, ob es sich um eine Liste von Records handelt
        if (isset($processedData['records']) && is_array($processedData['records'])) {
            // Mehrere Datensätze verarbeiten (z.B. bei IRRE-Relationen)
            foreach ($processedData['records'] as &$record) {
                $original = $record['data'][$sourceField] ?? '';
                $record[$targetField] = $this->sanitize($original);
            }
            unset($record);
        } elseif (isset($processedData[$sourceField]) && is_string($processedData[$sourceField])) {
            // Einzelner Wert
            $original = $processedData[$sourceField];
            $processedData[$targetField] = $this->sanitize($original);
        }

        return $processedData;
    }

    protected function sanitize(string $value): string
    {
        // Sonderzeichen in ASCII umwandeln über CharsetConverter
        $value = $this->charsetConverter->specCharsToASCII('utf-8', $value);

        // Kleinbuchstaben
        $value = strtolower($value);

        // Ersetze unerlaubte Zeichen durch Bindestrich
        $value = preg_replace('/[^a-z0-9]+/', '-', $value);
        $value = preg_replace('/-+/', '-', $value);
        $value = trim($value, '-');

        // Wenn mit Zahl beginnend, ein "r" voranstellen
        if (preg_match('/^[0-9]/', $value)) {
            $value = 'r' . $value;
        }

        return $value;
    }
}
