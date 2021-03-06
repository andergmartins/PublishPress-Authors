<?php
/**
 * File responsible for defining basic general constants used by the plugin.
 *
 * @package     MultipleAuthors
 * @author      PublishPress <help@publishpress.com>
 * @copyright   Copyright (C) 2018 PublishPress. All rights reserved.
 * @license     GPLv2 or later
 * @since       1.0.0
 */

use PPVersionNotices\Module\MenuLink\Module;

defined('ABSPATH') or die('No direct script access allowed.');

if (!defined('PP_AUTHORS_LOADED')) {
    require_once 'defines.php';

    if (!class_exists(PP_AUTHORS_AUTOLOAD_CLASS_NAME) && !class_exists('MultipleAuthors\\Plugin')) {
        $autoloadPath = PP_AUTHORS_VENDOR_PATH . 'autoload.php';
        if (file_exists($autoloadPath)) {
            require_once $autoloadPath;
        }
    }

    require_once PP_AUTHORS_SRC_PATH . '/deprecated.php';
    require_once PP_AUTHORS_SRC_PATH . '/functions/template-tags.php';
    require_once PP_AUTHORS_SRC_PATH . '/functions/amp.php';

    if (is_admin() && !defined('PUBLISHPRESS_AUTHORS_SKIP_VERSION_NOTICES')) {
        if (!defined('PP_VERSION_NOTICES_LOADED')) {
            $includesPath = PP_AUTHORS_VENDOR_PATH . 'publishpress/wordpress-version-notices/includes.php';

            if (file_exists($includesPath)) {
                require_once $includesPath;
            }
        }

        add_filter(
            \PPVersionNotices\Module\TopNotice\Module::SETTINGS_FILTER,
            function ($settings) {
                $settings['publishpress-authors'] = [
                    'message' => 'You\'re using PublishPress Authors Free. The Pro version has more features and support. %sUpgrade to Pro%s',
                    'link'    => 'https://publishpress.com/links/authors-banner',
                    'screens' => [
                        ['base' => 'edit-tags', 'id' => 'edit-author', 'taxonomy' => 'author'],
                        ['base' => 'term', 'id' => 'edit-author', 'taxonomy' => 'author'],
                        ['base' => 'authors_page_ppma-modules-settings', 'id' => 'authors_page_ppma-modules-settings'],
                    ]
                ];

                return $settings;
            }
        );

        add_filter(
            Module::SETTINGS_FILTER,
            function ($settings) {
                $settings['publishpress-authors'] = [
                    'parent' => 'ppma-authors',
                    'label'  => 'Upgrade to Pro',
                    'link'   => 'https://publishpress.com/links/authors-menu',
                ];

                return $settings;
            }
        );
    }

    require_once PP_AUTHORS_MODULES_PATH . 'multiple-authors/multiple-authors.php';
}
