<?php

/**
 * This file is part of SilverWare.
 *
 * PHP version >=5.6.0
 *
 * For full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 *
 * @package SilverWare\SpamGuard\Extensions
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2018 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-spam-guard
 */

namespace SilverWare\SpamGuard\Extensions;

use SilverStripe\Core\Extension;

/**
 * An extension which adds spam guard protection to user forms.
 *
 * @package SilverWare\SpamGuard\Extensions
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2018 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-spam-guard
 */
class UserFormExtension extends Extension
{
    /**
     * Updates the extended user form instance.
     *
     * @return void
     */
    public function updateForm()
    {
        if ($userDefinedForm = $this->owner->getController()->data()) {
            
            if ($userDefinedForm->EnableSpamGuard) {
                $this->owner->enableSpamProtection();
            }
            
        }
    }
}
