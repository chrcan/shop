<?php

declare(strict_types=1);

namespace Rcdesign\Rcdesign\ViewHelpers;

use InvalidArgumentException;
use TYPO3\CMS\Core\Imaging\ImageManipulation\CropVariantCollection;
use TYPO3\CMS\Core\Resource\Exception\ResourceDoesNotExistException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Exception;
use TYPO3\CMS\Extbase\Service\ImageService;
use TYPO3\CMS\Frontend\Imaging\GifBuilder;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;
use UnexpectedValueException;

final class ImageViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'img';

    protected ImageService $imageService;

    public function __construct()
    {
        parent::__construct();
        $this->imageService = GeneralUtility::makeInstance(ImageService::class);
    }

    public function initializeArguments(): void
    {
        parent::initializeArguments();

        // registerUniversalTagAttributes() entfernt, diese Attribute sind nun automatisch verfügbar

        // Umstellung von registerTagAttribute() auf registerArgument()
        $this->registerArgument('alt', 'string', 'Alternativtext für ein Bild', false, '');
        $this->registerArgument('ismap', 'string', 'Bild ist ein serverseitiges Image-Map (selten verwendet)', false, '');
        $this->registerArgument('longdesc', 'string', 'URL zu einer detaillierten Bildbeschreibung', false, '');
        $this->registerArgument('usemap', 'string', 'Bild ist ein clientseitiges Image-Map', false, '');
        $this->registerArgument('loading', 'string', 'Native Lazy-Loading ("lazy", "eager" oder "auto")', false, '');
        $this->registerArgument('decoding', 'string', 'Hinweis zur Bilddekodierung ("sync", "async" oder "auto")', false, '');

        $this->registerArgument('src', 'string', 'Pfad zu einer Datei, FAL Identifier oder UID', false, '');
        $this->registerArgument('treatIdAsReference', 'bool', 'Behandelt src als sys_file_reference UID', false, false);
        $this->registerArgument('image', 'object', 'FAL-Objekt (\\TYPO3\\CMS\\Core\\Resource\\File oder FileReference)');
        $this->registerArgument('crop', 'string|bool|array', 'Crop-Einstellungen überschreiben');
        $this->registerArgument('cropVariant', 'string', 'Spezifische Crop-Variante auswählen', false, 'default');
        $this->registerArgument('fileExtension', 'string', 'Benutzerdefinierte Dateiendung');

        $this->registerArgument('width', 'string', 'Bildbreite in Pixeln oder Berechnung mit m/c');
        $this->registerArgument('height', 'string', 'Bildhöhe in Pixeln oder Berechnung mit m/c');
        $this->registerArgument('minWidth', 'int', 'Minimale Bildbreite');
        $this->registerArgument('minHeight', 'int', 'Minimale Bildhöhe');
        $this->registerArgument('maxWidth', 'int', 'Maximale Bildbreite');
        $this->registerArgument('maxHeight', 'int', 'Maximale Bildhöhe');
        $this->registerArgument('absolute', 'bool', 'Erzwingt absolute URLs', false, false);
        $this->registerArgument('gifBuilderEffect', 'string', 'Effekt für GifBuilder, z.B. "blur=20 | gamma=1.3"', false, '');
    }

    /**
     * Resizes a given image (if required) and renders the respective img tag.
     *
     * @see https://docs.typo3.org/typo3cms/TyposcriptReference/ContentObjects/Image/
     * @throws Exception
     */
    public function render(): string
    {
        $src = (string)$this->arguments['src'];
        if (($src === '' && $this->arguments['image'] === null) || ($src !== '' && $this->arguments['image'] !== null)) {
            throw new Exception($this->getExceptionMessage('You must either specify a string src or a File object.'), 1382284106);
        }

        if ((string)$this->arguments['fileExtension'] && !GeneralUtility::inList($GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'], (string)$this->arguments['fileExtension'])) {
            throw new Exception(
                $this->getExceptionMessage(
                    'The extension ' . $this->arguments['fileExtension'] . ' is not specified in $GLOBALS[\'TYPO3_CONF_VARS\'][\'GFX\'][\'imagefile_ext\']'
                        . ' as a valid image file extension and can not be processed.',
                ),
                1618989190
            );
        }

        try {
            $gifBuilderEffect = $this->arguments['gifBuilderEffect'];

            $image = $this->imageService->getImage($src, $this->arguments['image'], (bool)$this->arguments['treatIdAsReference']);
            $cropString = $this->arguments['crop'];
            if ($cropString === null && $image->hasProperty('crop') && $image->getProperty('crop')) {
                $cropString = $image->getProperty('crop');
            }

            // CropVariantCollection needs a string, but this VH could also receive an array
            if (is_array($cropString)) {
                $cropString = json_encode($cropString);
            }

            $cropVariantCollection = CropVariantCollection::create((string)$cropString);
            $cropVariant = $this->arguments['cropVariant'] ?: 'default';
            $cropArea = $cropVariantCollection->getCropArea($cropVariant);
            $processingInstructions = [
                'width' => $this->arguments['width'],
                'height' => $this->arguments['height'],
                'minWidth' => $this->arguments['minWidth'],
                'minHeight' => $this->arguments['minHeight'],
                'maxWidth' => $this->arguments['maxWidth'],
                'maxHeight' => $this->arguments['maxHeight'],
                'crop' => $cropArea->isEmpty() ? null : $cropArea->makeAbsoluteBasedOnFile($image),
            ];
            if (!empty($this->arguments['fileExtension'] ?? '')) {
                $processingInstructions['fileExtension'] = $this->arguments['fileExtension'];
            }
            $processedImage = $this->imageService->applyProcessingInstructions($image, $processingInstructions);

            if ($gifBuilderEffect) {
                $conf = [
                    1 => 'IMAGE',
                    '1.' => [
                        'file' => $processedImage->getForLocalProcessing(false),
                    ],
                    10 => 'TEXT',
                    '10.' => [
                        'offset' => '20,30',
                        #'align' => 'left',
                        'fontFile' => 'EXT:rcdesign/Resources/Public/Fonts/roboto/Roboto-Bold.ttf',
                        'text' => '©IFBBAustria.at',
                        'fontSize' => '14',
                        'fontColor' => '#ffffff',
                        'antiAlias' => '1',
                    ],
                    20 => 'EFFECT',
                    '20.' => [
                        'value' => $gifBuilderEffect
                    ],
                ];
                $conf['XY'] = '[1.w],[1.h]';
                /** @var GifBuilder $gifCreator */
                $gifCreator = GeneralUtility::makeInstance(GifBuilder::class);
                $gifCreator->start($conf, []);
                $imageUri = $gifCreator->gifBuild()->getPublicUrl();
            } else {
                $imageUri = $this->imageService->getImageUri($processedImage, $this->arguments['absolute']);
            }

            if (!$this->tag->hasAttribute('data-focus-area')) {
                $focusArea = $cropVariantCollection->getFocusArea($cropVariant);
                if (!$focusArea->isEmpty()) {
                    $this->tag->addAttribute('data-focus-area', $focusArea->makeAbsoluteBasedOnFile($image));
                }
            }
            $this->tag->addAttribute('src', $imageUri);
            $this->tag->addAttribute('width', $processedImage->getProperty('width'));
            $this->tag->addAttribute('height', $processedImage->getProperty('height'));

            if (is_string($this->arguments['alt'] ?? false) && $this->arguments['alt'] === '') {
                // In case the "alt" attribute is explicitly set to an empty string, respect
                // this to allow excluding it from screen readers, improving accessibility.
                $this->tag->addAttribute('alt', '');
            } elseif (empty($this->arguments['alt'])) {
                // The alt-attribute is mandatory to have valid html-code, therefore use "alternative" property or empty
                $this->tag->addAttribute('alt', $image->hasProperty('alternative') ? $image->getProperty('alternative') : '');
            }
            // Add title-attribute from property if not already set and the property is not an empty string
            $title = (string)($image->hasProperty('title') ? $image->getProperty('title') : '');
            if (empty($this->arguments['title']) && $title !== '') {
                $this->tag->addAttribute('title', $title);
            }
        } catch (ResourceDoesNotExistException $e) {
            // thrown if file does not exist
            throw new Exception($this->getExceptionMessage($e->getMessage()), 1509741911, $e);
        } catch (\UnexpectedValueException $e) {
            // thrown if a file has been replaced with a folder
            throw new Exception($this->getExceptionMessage($e->getMessage()), 1509741912, $e);
        } catch (\InvalidArgumentException $e) {
            // thrown if file storage does not exist
            throw new Exception($this->getExceptionMessage($e->getMessage()), 1509741914, $e);
        }
        return $this->tag->render();
    }

    protected function getExceptionMessage(string $detailedMessage): string
    {
        /** @var RenderingContext $renderingContext */
        $renderingContext = $this->renderingContext;
        $request = $renderingContext->getRequest();
        if ($request instanceof RequestInterface) {
            $currentContentObject = $request->getAttribute('currentContentObject');
            if ($currentContentObject instanceof ContentObjectRenderer) {
                return sprintf('Unable to render image tag in "%s": %s', $detailedMessage);
            }
        }
        return "Unable to render image tag: $detailedMessage";
    }
}
