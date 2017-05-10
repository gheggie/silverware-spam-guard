<?php

/**
 * This file is part of SilverWare.
 *
 * PHP version >=5.6.0
 *
 * For full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 *
 * @package SilverWare\SpamGuard\Interfaces
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2017 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-spam-guard
 */

namespace SilverWare\SpamGuard\Interfaces;

/**
 * An interface for a spam guard implementation.
 *
 * @package SilverWare\SpamGuard\Interfaces
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2017 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-spam-guard
 */
interface SpamGuard
{
    /**
     * Answers the form field used for implementing the spam guard.
     *
     * @param string $name
     * @param string $title
     * @param mixed $value
     *
     * @return FormField
     */
    public function getFormField($name = null, $title = null, $value = null);
    
    /**
     * Answers the default name for the form field.
     *
     * @return string
     */
    public function getDefaultName();
    
    /**
     * Answers the default title for the form field.
     *
     * @return string
     */
    public function getDefaultTitle();
}
