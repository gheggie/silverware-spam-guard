<?php

/**
 * This file is part of SilverWare.
 *
 * PHP version >=5.6.0
 *
 * For full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 *
 * @package SilverWare\SpamGuard\Fields
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2017 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-spam-guard
 */

namespace SilverWare\SpamGuard\Fields;

use SilverStripe\Forms\FormField;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\View\Requirements;

/**
 * An extension of the form field class for preventing spam using a honeypot.
 *
 * @package SilverWare\SpamGuard\Fields
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2017 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware-spam-guard
 */
class SimpleSpamGuardField extends FormField
{
    /**
     * A form field instance for the honeypot.
     *
     * @var TextField
     */
    protected $honeypot;
    
    /**
     * A form field instance for the timestamp.
     *
     * @var HiddenField
     */
    protected $timestamp;
    
    /**
     * How many seconds must pass before the form can be submitted.
     *
     * @var integer
     */
    protected $timeLimit = 5;
    
    /**
     * Constructs the object upon instantiation.
     *
     * @param string $name
     * @param string $title
     * @param mixed $value
     */
    public function __construct($name, $title = null, $value = null)
    {
        // Define Name:
        
        $this->setName($name);
        
        // Construct Object:
        
        $this->honeypot  = TextField::create(sprintf('%s[value]', $name), $title, $value);
        $this->timestamp = HiddenField::create(sprintf('%s[timestamp]', $name), '', time());
        
        // Construct Parent:
        
        parent::__construct($name, $title, $value);
    }
    
    /**
     * Defines the value of the timeLimit attribute.
     *
     * @param integer $timeLimit
     *
     * @return $this
     */
    public function setTimeLimit($timeLimit)
    {
        $this->timeLimit = (integer) $timeLimit;
        
        return $this;
    }
    
    /**
     * Answers the value of the timeLimit attribute.
     *
     * @return integer
     */
    public function getTimeLimit()
    {
        return $this->timeLimit;
    }
    
    /**
     * Defines the form instance for the receiver.
     *
     * @param Form $form
     *
     * @return $this
     */
    public function setForm($form)
    {
        // Associate Fields with Form:
        
        $this->honeypot->setForm($form);
        $this->timestamp->setForm($form);
        
        // Call Parent Method:
        
        return parent::setForm($form);
    }
    
    /**
     * Answers the honeypot form field instance.
     *
     * @return TextField
     */
    public function getHoneypotField()
    {
        return $this->honeypot;
    }
    
    /**
     * Answers the timestamp form field instance.
     *
     * @return HiddenField
     */
    public function getTimestampField()
    {
        return $this->timestamp;
    }
    
    /**
     * Answers the field type for the template.
     *
     * @return string
     */
    public function Type()
    {
        return 'simpleguard';
    }
    
    /**
     * Renders the field for the template.
     *
     * @param array $properties
     *
     * @return DBHTMLText
     */
    public function Field($properties = [])
    {
        Requirements::customCSS('.field.simpleguard { display: none !important; }');
        
        return DBField::create_field('HTMLFragment', $this->honeypot->Field() . $this->timestamp->Field());
    }
    
    /**
     * Defines the field value.
     *
     * @param mixed $value
     * @param array $data
     *
     * @return $this
     */
    public function setValue($value, $data = null)
    {
        // Check Value Type:
        
        if (is_array($value)) {
            
            // Define Field Values:
            
            $this->honeypot->setValue(isset($value['value']) ? $value['value'] : null);
            $this->timestamp->setValue(isset($value['timestamp']) ? $value['timestamp'] : null);
            
            // Define Self Value:
            
            $this->value = $this->honeypot->dataValue();
            
        }
        
        // Answer Self:
        
        return $this;
    }
    
    /**
     * Answers true if the form was submitted too soon.
     *
     * @return boolean
     */
    public function tooSoon()
    {
        return ($this->timeLimit > 0 && ($this->timestamp->dataValue() + $this->timeLimit) > time());
    }
    
    /**
     * Answers true if the value is valid for the receiver.
     *
     * @param Validator $validator
     *
     * @return boolean
     */
    public function validate($validator)
    {
        // Check Value and Timestamp:
        
        if (!empty($this->value) || $this->tooSoon()) {
            
            // Define Validation Error:
            
            $validator->validationError(
                $this->name,
                _t(
                    __CLASS__ . '.VALIDATIONERROR',
                    'Sorry, an error has occurred. Please try again later.'
                ),
                'validation'
            );
            
            // Answer Failure:
            
            return false;
            
        }
        
        // Answer Success:
        
        return true;
    }
}
