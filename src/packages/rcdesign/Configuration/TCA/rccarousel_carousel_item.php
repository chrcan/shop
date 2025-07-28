<?php

declare(strict_types=1);

/*
 * (c) 2025 rc design visual concepts (rc-design.at)
 * _________________________________________________
 * The TYPO3 project - inspiring people to share!
 * _________________________________________________
 */

return [
    'ctrl' => [
        'label' => 'header',
        'label_alt' => 'bodytext',
        'sortby' => 'sorting',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'title' => 'LLL:EXT:rcdesign/Resources/Private/Language/Backend.xlf:carousel_item',
        'delete' => 'deleted',
        'versioningWS' => true,
        'origUid' => 't3_origuid',
        'hideTable' => true,
        'hideAtCopy' => true,
        'prependAtCopy' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.prependAtCopy',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'languageField' => 'sys_language_uid',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
        'typeicon_classes' => [
            'default' => 'module-viewpage',
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
                header,
                bodytext,
                media,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
                --palette--;;hiddenLanguagePalette,
            ',
        ],
    ],
    'palettes' => [
        '1' => [
            'showitem' => '',
        ],
        'access' => [
            'showitem' => '
                starttime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:starttime_formlabel,
                endtime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:endtime_formlabel
            ',
        ],
        'general' => [
            'showitem' => '
                tt_content
            ',
        ],
        'visibility' => [
            'showitem' => '
                hidden;LLL:EXT:rcdesign/Resources/Private/Language/Backend.xlf:carousel_item
            ',
        ],
        // hidden but needs to be included all the time, so sys_language_uid is set correctly
        'hiddenLanguagePalette' => [
            'showitem' => 'sys_language_uid, l10n_parent',
            'isHiddenPalette' => true,
        ],
    ],
    'columns' => [
        'tt_content' => [
            'exclude' => true,
            'label' => 'LLL:EXT:rcdesign/Resources/Private/Language/Backend.xlf:carousel_item.tt_content',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tt_content',
                'foreign_table_where' => 'AND tt_content.pid=###CURRENT_PID### AND tt_content.{#CType}=\'rccarousel_carousel\'',
                'maxitems' => 1,
                'default' => 0,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
            ],
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038),
                ],
            ],
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
        ],
        'sys_language_uid' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => ['type' => 'language'],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        'label' => '',
                        'value' => 0,
                    ],
                ],
                'foreign_table' => 'rccarousel_carousel_item',
                'foreign_table_where' => 'AND rccarousel_carousel_item.pid=###CURRENT_PID### AND rccarousel_carousel_item.sys_language_uid IN (-1,0)',
                'default' => 0,
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'header' => [
            'exclude' => true,
            'label' => 'LLL:EXT:rcdesign/Resources/Private/Language/Backend.xlf:carousel_item.header',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'bodytext' => [
            'label' => 'LLL:EXT:rcdesign/Resources/Private/Language/Backend.xlf:carousel_item.bodytext',
            'l10n_mode' => 'prefixLangTitle',
            'l10n_cat' => 'text',
            'config' => [
                'type' => 'text',
                'cols' => '80',
                'rows' => '15',
                'softref' => 'typolink_tag,email[subst],url',
                'enableRichtext' => true,
            ],
        ],
        'media' => [
            'exclude' => true,
            'label' => 'LLL:EXT:rcdesign/Resources/Private/Language/Backend.xlf:carousel_item.media',
            'config' => [
                'type' => 'file',
                'allowed' => 'common-media-types',
                'disallowed' => ['mp3', 'wav', 'flac', 'opus'],
                'appearance' => [
                    'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/Database.xlf:tt_content.asset_references.addFileReference',
                ],
                'overrideChildTca' => [
                    'types' => [
                        TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette',
                        ],
                        TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                            'showitem' => '
                                --palette--;;videoOverlayPalette,
                                --palette--;;filePalette',
                        ],
                    ],
                ],
            ],
        ],
        // 'image_zoom' => [
        //     'exclude' => true,
        //     'label' => 'LLL:EXT:rcdesign/Resources/Private/Language/Backend.xlf:accordion_item.image_zoom',
        //     'config' => [
        //         'type' => 'check',
        //         'items' => [
        //             [
        //                 'label' => '',
        //                 1 => '',
        //             ],
        //         ],
        //     ],
        // ],
        // 'columnwidth1' => [
        //     'exclude' => 0,
        //     'label' => 'LLL:EXT:rcdesign/Resources/Private/Language/Backend.xlf:accordion_item.columnwidth2',
        //     'config' => [
        //         'type' => 'select',
        //         'renderType' => 'selectSingle',
        //         'items' => [
        //             ['label' => 'col-2', 'value' => 'col-2'],
        //             ['label' => 'col-3', 'value' => 'col-3'],
        //             ['label' => 'col-4', 'value' => 'col-4'],
        //             ['label' => 'col-5', 'value' => 'col-5'],
        //             ['label' => 'col-6', 'value' => 'col-6'],
        //             ['label' => 'col-7', 'value' => 'col-7'],
        //             ['label' => 'col-8', 'value' => 'col-8'],
        //             ['label' => 'col-9', 'value' => 'col-9'],
        //             ['label' => 'col-10', 'value' => 'col-10'],
        //         ],
        //         'size' => 1,
        //         'maxitems' => 1,
        //     ],
        // ],
        // 'columnwidth2' => [
        //     'exclude' => 0,
        //     'label' => 'LLL:EXT:rcdesign/Resources/Private/Language/Backend.xlf:accordion_item.columnwidth2',
        //     'config' => [
        //         'type' => 'select',
        //         'renderType' => 'selectSingle',
        //         'items' => [
        //             ['label' => 'col-2', 'value' => 'col-2'],
        //             ['label' => 'col-3', 'value' => 'col-3'],
        //             ['label' => 'col-4', 'value' => 'col-4'],
        //             ['label' => 'col-5', 'value' => 'col-5'],
        //             ['label' => 'col-6', 'value' => 'col-6'],
        //             ['label' => 'col-7', 'value' => 'col-7'],
        //             ['label' => 'col-8', 'value' => 'col-8'],
        //             ['label' => 'col-9', 'value' => 'col-9'],
        //             ['label' => 'col-10', 'value' => 'col-10'],
        //         ],
        //         'size' => 1,
        //         'maxitems' => 1,
        //     ],
        // ],
        // 'position1' => [
        //     'exclude' => 0,
        //     'label' => 'LLL:EXT:rcdesign/Resources/Private/Language/Backend.xlf:accordion_item.position1',
        //     'config' => [
        //         'type' => 'select',
        //         'renderType' => 'selectSingle',
        //         'items' => [
        //             ['label' => 'Left', 'value' => 'order-last'],
        //             ['label' => 'Right', 'value' => 'order-first'],
        //         ],
        //         'size' => 1,
        //         'maxitems' => 1,
        //     ],
        // ],
        // 'position2' => [
        //     'exclude' => 0,
        //     'label' => 'LLL:EXT:rcdesign/Resources/Private/Language/Backend.xlf:accordion_item.position2',
        //     'config' => [
        //         'type' => 'select',
        //         'renderType' => 'selectSingle',
        //         'items' => [
        //             ['label' => 'Left', 'value' => 'order-last'],
        //             ['label' => 'Right', 'value' => 'order-first'],
        //         ],
        //         'size' => 1,
        //         'maxitems' => 1,
        //     ],
        // ],
    ],
];
