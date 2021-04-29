<?php

/**
 * An implementation of the spam protector interface to provide simple spam protection on forms.
 */
class SilverWareSpamProtector implements SpamProtector
{
    /**
     * Answers the form field used for spam protection.
     *
     * @param string $name
     * @param string $title
     * @param mixed $value
     * @return FormField
     */
    public function getFormField($name = null, $title = null, $value = null)
    {
        if (!$title) {
            
            $title = _t(
                'SilverWareSpamProtector.DEFAULTTITLE',
                'If you can see this field, please leave it empty!'
            );
            
        }
        
        return SilverWareSpamProtectorField::create($name, $title, $value);
    }
    
    /**
     * Defines the fields to map spam protection to (not used).
     *
     * @param array $fieldMapping
     */
    public function setFieldMapping($fieldMapping)
    {
        
    }
}
