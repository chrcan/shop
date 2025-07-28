<?php

declare(strict_types=1);

/*
 * (c) 2025 rc design visual concepts (rc-design.at)
 * _________________________________________________
 * The TYPO3 project - inspiring people to share!
 * _________________________________________________
 */

namespace Rcdesign\Rcdesign\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 * Phone link view helper.
 * Erzeugt einen klickbaren "tel:"-Link.
 *
 * = Beispiele =
 *
 * <code title="Einfache Telefonnummer">
 * <f:link.phone phone="+49 123 456 7890" />
 * </code>
 * <output>
 * <a href="tel:+49 123 456 7890">+49 123 456 7890</a>
 * </output>
 *
 * <code title="Benutzerdefinierter Linktext">
 * <f:link.phone phone="+49 123 456 7890">Jetzt anrufen</f:link.phone>
 * </code>
 * <output>
 * <a href="tel:+49 123 456 7890">Jetzt anrufen</a>
 * </output>
 */
class PhoneViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'a';

    /**
     * Registriert die möglichen Argumente und HTML-Attribute.
     */
    public function initializeArguments(): void
    {
        parent::initializeArguments();

        // Attribut für die Telefonnummer
        $this->registerArgument('phone', 'string', 'Telefonnummer', true);
    }

    /**
     * Rendert den Telefon-Link.
     *
     * @return string Gerenderter <a>-Tag mit "tel:"-Link
     */
    public function render()
    {
        $linkHref = 'tel:' . $this->arguments['phone'];
        $linkText = $this->arguments['phone'];

        $tagContent = $this->renderChildren();
        if (!empty($tagContent)) {
            $linkText = $tagContent;
        }

        $this->tag->addAttribute('href', $linkHref);
        $this->tag->setContent($linkText);
        $this->tag->forceClosingTag(true);

        return $this->tag->render();
    }
}
