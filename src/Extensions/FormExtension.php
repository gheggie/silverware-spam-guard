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
 * @copyright 2017 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-spam-guard
 */

namespace SilverWare\SpamGuard\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Core\Injector\Injector;

/**
 * An extension which adds spam guard protection to forms.
 *
 * @package SilverWare\SpamGuard\Extensions
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2017 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-spam-guard
 */
class FormExtension extends Extension
{
    /**
     * Enables spam guard protection for the extended form.
     *
     * @param array $args
     *
     * @return Form
     */
    public function enableSpamProtection($args = [])
    {
        // Obtain Spam Guard Instance:
        
        if ($guard = $this->getSpamGuardInstance($args)) {
            
            // Define Field Name and Title:
            
            $name  = isset($args['name'])  ? $args['name']  : $guard->getDefaultName();
            $title = isset($args['title']) ? $args['title'] : $guard->getDefaultTitle();
            
            // Obtain Spam Guard Form Field:
            
            if ($field = $guard->getFormField($name, $title)) {
                
                // Link Field with Form:
                
                $field->setForm($this->owner);
                
                // Add Field to Form:
                
                if (isset($args['insertBefore'])) {
                    
                    // Insert Before Specified Field:
                    
                    $this->owner->Fields()->insertBefore($field, $args['insertBefore']);
                    
                } elseif (isset($args['insertAfter'])) {
                    
                    // Insert After Specified Field:
                    
                    $this->owner->Fields()->insertAfter($field, $args['insertAfter']);
                    
                } else {
                    
                    // Push Field to End of List:
                    
                    $this->owner->Fields()->push($field);
                    
                }
                
            }
            
        }
        
        // Answer Extended Form:
        
        return $this->owner;
    }
    
    /**
     * Answers the spam guard instance for the extended form.
     *
     * @param array $args
     *
     * @return SpamGuard
     */
    public function getSpamGuardInstance($args = [])
    {
        return Injector::inst()->create(isset($args['class']) ? $args['class'] : 'DefaultSpamGuard');
    }
}
