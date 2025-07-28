<?php

declare(strict_types=1);

/*
 * (c) 2025 rc design visual concepts (rc-design.at)
 * _________________________________________________
 * The TYPO3 project - inspiring people to share!
 * _________________________________________________
 */

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/*
 * (c) 2025 rc design visual concepts (rc-design.at)
 * _________________________________________________
 * The TYPO3 project - inspiring people to share!
 * _________________________________________________
 */

defined('TYPO3') or die();

ExtensionManagementUtility::registerPageTSConfigFile(
    'rcdesign',
    'Configuration/TSconfig/backendLayouts.tsconfig',
    'Default Backendlayouts'
);
ExtensionManagementUtility::registerPageTSConfigFile(
    'rcdesign',
    'Configuration/TSconfig/page.tsconfig',
    'Default PageTSconfig'
);
