<?php

/**
 * An extension of the form field class to provide simple spam protection on forms.
 */
class SilverWareSpamProtectorField extends FormField
{
    /**
     * Specifies how many seconds must pass before the form can be submitted.
     *
     * @config
     * @var integer
     */
    private static $time_limit = 5;
    
    /**
     * Constructs the object upon instantiation.
     *
     * @param string $name
     * @param string $title
     * @param mixed $value
     */
    public function __construct($name, $title = null, $value = null)
    {
        // Construct Parent:
        
        parent::__construct($name, $title, $value);
    }
    
    /**
     * Renders the receiver for the HTML template.
     *
     * @param array $properties
     * @return string
     */
    public function Field($properties = array())
    {
        // Load Requirements:
        
        Requirements::customCSS('.field.silverwarespamprotector { display: none !important; }');
        
        // Create Honeypot Field:
        
        $text = TextField::create(
            $this->getName(),
            '',
            $this->Value()
        )->setForm($this->getForm());
        
        // Create Timestamp Field:
        
        $time = HiddenField::create(
            $this->getName() . '_Timestamp',
            '',
            time()
        )->setForm($this->getForm());
        
        // Render Fields:
        
        return $text->Field() . $time->Field();
    }
    
    /**
     * Answers true if validation is successful for the receiver.
     *
     * @param Validator $validator
     * @todo Show a different error for a fast submission?
     * @return boolean
     */
    public function validate($validator)
    {
        // Obtain Time Limit and Timestamp:
        
        $limit = $this->config()->time_limit;
        $stamp = $this->getForm()->getRequest()->postVar($this->getName() . '_Timestamp');
        
        // Check Value and Timestamp (value should be empty for a legitimate submission):
        
        if (!empty($this->value) || ($limit > 0 && ($stamp + $limit) > time())) {
            
            // Define Validation Error:
            
            $validator->validationError(
                $this->name,
                _t(
                    'SilverWareSpamProtectorField.VALIDATIONERRORMESSAGE',
                    'Sorry, an error has occurred. Please try again later.'
                ),
                'error'
            );
            
            // Answer Failure:
            
            return false;
            
        }
        
        // Answer Success:
        
        return true;
    }
}
