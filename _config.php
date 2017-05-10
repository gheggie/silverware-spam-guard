<?php

/**
 * SilverWare Spam Guard configuration file.
 *
 * PHP version >=5.6.0
 *
 * For full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 *
 * @package SilverWare\SpamGuard
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2017 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-spam-guard
 */

// Define Module Constants:

if (!defined('SILVERWARE_SPAM_GUARD_DIR')) {
    define('SILVERWARE_SPAM_GUARD_DIR', basename(__DIR__));
}

if (!defined('SILVERWARE_SPAM_GUARD_PATH')) {
    define('SILVERWARE_SPAM_GUARD_PATH', realpath(__DIR__));
}
