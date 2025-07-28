<?php

declare(strict_types=1);

/*
 * (c) 2025 rc design visual concepts (rc-design.at)
 * _________________________________________________
 * The TYPO3 project - inspiring people to share!
 * _________________________________________________
 */

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/*
 * Copyright (C) 2023 rc design visual concepts (rc-design.at)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 * The TYPO3 project - inspiring people to share!
 */

defined('TYPO3') or die();

GeneralUtility::makeInstance(B13\Container\Tca\Registry::class)->configureContainer(
    (
        new B13\Container\Tca\ContainerConfiguration(
            '2Spalten', // CType
            '2 Spalten', // label
            '50% / 50%', // description
            [
                [
                    ['name' => 'Linke Spalte', 'colPos' => 201, 'disallowed' => ['CType' => '2cols, 3cols']],
                    ['name' => 'Rechte Spalte', 'colPos' => 202, 'disallowed' => ['CType' => '2cols, 3cols']],
                ],
            ] // grid configuration
        )
    )
        // override default configurations
        ->setIcon('EXT:container/Resources/Public/Icons/container-2col.svg')
        ->setSaveAndCloseInNewContentElementWizard(true)
);
// override default settings
$GLOBALS['TCA']['tt_content']['types']['2colsU']['showitem'] = 'sys_language_uid,CType,header,header_layout,layout,colPos,tx_container_parent';

GeneralUtility::makeInstance(B13\Container\Tca\Registry::class)->configureContainer(
    (
        new B13\Container\Tca\ContainerConfiguration(
            '3Spalten', // CType
            '3 Spalten', // label
            '33% / 33% / 33%', // description
            [
                [
                    ['name' => 'Linke Spalte', 'colPos' => 301, 'disallowed' => ['CType' => '2cols, 2colsU, 2cols84, 3cols']],
                    ['name' => 'Mittlere Spalte', 'colPos' => 302, 'disallowed' => ['CType' => '2cols, 3cols']],
                    ['name' => 'Rechte Spalte', 'colPos' => 303, 'disallowed' => ['CType' => '2cols, 3cols']],
                ],
            ] // grid configuration
        )
    )
        // override default configurations
        ->setIcon('EXT:container/Resources/Public/Icons/container-3col.svg')
        ->setSaveAndCloseInNewContentElementWizard(true)
);
// override default settings
$GLOBALS['TCA']['tt_content']['types']['3cols']['showitem'] = 'sys_language_uid,CType,header,header_layout,layout,colPos,tx_container_parent';

GeneralUtility::makeInstance(B13\Container\Tca\Registry::class)->configureContainer(
    (
        new B13\Container\Tca\ContainerConfiguration(
            '4Spalten', // CType
            '4 Spalten', // label
            '33% / 33% / 33% / 33%', // description
            [
                [
                    ['name' => 'Linke Spalte', 'colPos' => 401, 'disallowed' => ['CType' => '2cols, 3cols, 4cols']],
                    ['name' => 'Linke Mittlere Spalte', 'colPos' => 402, 'disallowed' => ['CType' => '2cols, 3cols, 4cols']],
                    ['name' => 'Rechte Mittlere Spalte', 'colPos' => 403, 'disallowed' => ['CType' => '2cols, 3cols, 4cols']],
                    ['name' => 'Rechte Spalte', 'colPos' => 404, 'disallowed' => ['CType' => '2cols, 3cols, 4cols']],
                ],
            ] // grid configuration
        )
    )
        // override default configurations
        ->setIcon('EXT:container/Resources/Public/Icons/container-4col.svg')
        ->setSaveAndCloseInNewContentElementWizard(true)
);
// override default settings
$GLOBALS['TCA']['tt_content']['types']['4cols']['showitem'] = 'sys_language_uid,CType,header,header_layout,layout,colPos,tx_container_parent';

// Eigenes CType erstellen

ExtensionManagementUtility::addTCAcolumns(
    'tt_content',
    [
        'row_items' => [
            'exclude' => 0,
            'label' => 'Cards Menge',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 1, 'value' => 'row-cols-1 row-cols-md-1'],
                    ['label' => 2, 'value' => 'row-cols-1 row-cols-md-2'],
                    ['label' => 3, 'value' => 'row-cols-1 row-cols-md-3'],
                    ['label' => 4, 'value' => 'row-cols-1 row-cols-md-4'],
                ],
                'size' => 1,
                'maxitems' => 1,
            ],
        ],
    ],
);

/// Neues CE Element Card mit Inline Funktion

ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        // title
        'label' => 'RC Card',
        // plugin signature: extkey_identifier
        'value' => 'rcdesign_rccard',
        // icon identifier
        'icon' => 'content-card',
        // make one group
        // 'group' => 'common',
        // description
        'description' => 'LLL:EXT:rcdesign/Resources/Private/Language/locallang.xlf:rcdesign_rccard_description',
    ],
    'rcdesign_rcaccordion',
    'after'
);

// Adds the content element icon to TCA typeicon_classes
$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['rcdesign_rccard'] = 'content-card';

// Configure the default backend fields for the content element
$GLOBALS['TCA']['tt_content']['types']['rcdesign_rccard'] = [
    'showitem' => '
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
            --palette--;;general,
            rccard_group_item,
            bodytext;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:bodytext_formlabel,
        ',

    'columnsOverrides' => [
        'bodytext' => [
            'config' => [
                'enableRichtext' => true,
                'richtextConfiguration' => 'BootstrapRTE',
            ],
        ],
    ],
];
// Configure element type rccard
$GLOBALS['TCA']['tt_content']['types']['rcdesign_rccard'] = array_replace_recursive(
    $GLOBALS['TCA']['tt_content']['types']['rcdesign_rccard'],
    [
        'showitem' => '
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
            --palette--;;general,
        header;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_formlabel,
            row_items,
            rccard_group_item,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.appearanceLinks;appearanceLinks,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
            --palette--;;language,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
            --palette--;;hidden,
            --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
        ',
    ]
);

// Register fields rccard_group_item
$GLOBALS['TCA']['tt_content']['columns'] = array_replace_recursive(
    $GLOBALS['TCA']['tt_content']['columns'],
    [
        'rccard_group_item' => [
            'label' => 'LLL:EXT:rcdesign/Resources/Private/Language/Backend.xlf:rccard_group_item',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'rccard_group_item',
                'foreign_field' => 'tt_content',
                'appearance' => [
                    'useSortable' => true,
                    'showSynchronizationLink' => true,
                    'showAllLocalizationLink' => true,
                    'showPossibleLocalizationRecords' => true,
                    'expandSingle' => true,
                    'enabledControls' => [
                        'localize' => true,
                    ],
                ],
                'behaviour' => [
                    'mode' => 'select',
                ],
            ],
        ],
    ]
);

/// Neues CE Element Accordion mit Inline Funktion

ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        // title
        'label' => 'RC Accordion',
        // plugin signature: extkey_identifier
        'value' => 'rcdesign_rcaccordion',
        // icon identifier
        'icon' => 'module-list',
        // make one group
        // 'group' => 'common',
        // description
        'description' => 'LLL:EXT:rcdesign/Resources/Private/Language/locallang.xlf:rcdesign_rcaccordion_description',
    ],
    'rcdesign_rccard',
    'after'
);
// Adds the content element icon to TCA typeicon_classes
$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['rcdesign_rcaccordion'] = 'module-list';
// Configure the default backend fields for the content element
$GLOBALS['TCA']['tt_content']['types']['rcdesign_rcaccordion'] = [
    'showitem' => '
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
            --palette--;;general,
            header;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_formlabel,
            rcaccordion_accordion_item,
        ',

    'columnsOverrides' => [
        'bodytext' => [
            'config' => [
                'enableRichtext' => true,
                'richtextConfiguration' => 'BootstrapRTE',
            ],
        ],
    ],
];
// Register fields rcaccordion_accordion_item
$GLOBALS['TCA']['tt_content']['columns'] = array_replace_recursive(
    $GLOBALS['TCA']['tt_content']['columns'],
    [
        'rcaccordion_accordion_item' => [
            'label' => 'LLL:EXT:rcdesign/Resources/Private/Language/Backend.xlf:accordion_item',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'rcaccordion_accordion_item',
                'foreign_field' => 'tt_content',
                'appearance' => [
                    'useSortable' => true,
                    'showSynchronizationLink' => true,
                    'showAllLocalizationLink' => true,
                    'showPossibleLocalizationRecords' => true,
                    'expandSingle' => true,
                    'enabledControls' => [
                        'localize' => true,
                    ],
                ],
                'behaviour' => [
                    'mode' => 'select',
                ],
            ],
        ],
    ]
);

/// Neues Carousel rccarousel

ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        // title
        'label' => 'RC Carousel',
        // plugin signature: extkey_identifier
        'value' => 'rcdesign_rccarousel',
        // icon identifier
        'icon' => 'module-viewpage',
        // make one group
        // 'group' => 'common',
        // description
        'description' => 'LLL:EXT:rcdesign/Resources/Private/Language/locallang.xlf:rcdesign_rccarousel_description',
    ],
    'rcdesign_rccard',
    'after'
);
// Adds the content element icon to TCA typeicon_classes
$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['rcdesign_rccarousel'] = 'module-viewpage';
// Configure the default backend fields for the content element
$GLOBALS['TCA']['tt_content']['types']['rcdesign_rccarousel'] = [
    'showitem' => '
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
            --palette--;;general,
            header;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_formlabel,
            rccarousel_carousel_item,
        ',

    'columnsOverrides' => [
        'bodytext' => [
            'config' => [
                'enableRichtext' => true,
                'richtextConfiguration' => 'BootstrapRTE',
            ],
        ],
    ],
];
// Register fields rccarousel_carousel_item
$GLOBALS['TCA']['tt_content']['columns'] = array_replace_recursive(
    $GLOBALS['TCA']['tt_content']['columns'],
    [
        'rccarousel_carousel_item' => [
            'label' => 'LLL:EXT:rcdesign/Resources/Private/Language/Backend.xlf:carousel_item',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'rccarousel_carousel_item',
                'foreign_field' => 'tt_content',
                'appearance' => [
                    'useSortable' => true,
                    'showSynchronizationLink' => true,
                    'showAllLocalizationLink' => true,
                    'showPossibleLocalizationRecords' => true,
                    'expandSingle' => true,
                    'enabledControls' => [
                        'localize' => true,
                    ],
                ],
                'behaviour' => [
                    'mode' => 'select',
                ],
            ],
        ],
    ]
);

/// Neues CE Element Tab mit Inline Funktion

ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        // title
        'label' => 'RC Tab',
        // plugin signature: extkey_identifier
        'value' => 'rcdesign_rctab',
        // icon identifier
        'icon' => 'content-tab',
        // make one group
        // 'group' => 'common',
        // description
        'description' => 'LLL:EXT:rcdesign/Resources/Private/Language/locallang.xlf:rcdesign_rctab_description',
    ],
    'rcdesign_rccard',
    'after'
);
// Adds the content element icon to TCA typeicon_classes
$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['rcdesign_rctab'] = 'content-tab';
// Configure the default backend fields for the content element
$GLOBALS['TCA']['tt_content']['types']['rcdesign_rctab'] = [
    'showitem' => '
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
            --palette--;;general,
            header;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_formlabel,
            rctab_tab_item,
        ',

    'columnsOverrides' => [
        'bodytext' => [
            'config' => [
                'enableRichtext' => true,
                'richtextConfiguration' => 'BootstrapRTE',
            ],
        ],
    ],
];
// Register fields rctab_tab_item
$GLOBALS['TCA']['tt_content']['columns'] = array_replace_recursive(
    $GLOBALS['TCA']['tt_content']['columns'],
    [
        'rctab_tab_item' => [
            'label' => 'LLL:EXT:rcdesign/Resources/Private/Language/Backend.xlf:tab_item',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'rctab_tab_item',
                'foreign_field' => 'tt_content',
                'appearance' => [
                    'useSortable' => true,
                    'showSynchronizationLink' => true,
                    'showAllLocalizationLink' => true,
                    'showPossibleLocalizationRecords' => true,
                    'expandSingle' => true,
                    'enabledControls' => [
                        'localize' => true,
                    ],
                ],
                'behaviour' => [
                    'mode' => 'select',
                ],
            ],
        ],
    ]
);
