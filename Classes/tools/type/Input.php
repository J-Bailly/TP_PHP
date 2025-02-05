<?php 

namespace tools\type;

use tools\GenericFormElement;

abstract class Input extends GenericFormElement
{
    public function render(): string
    {
        return sprintf(
            '<input type="%s" %s value="%s" name="form[%s]" id="%s"/>', 
            $this->type,
            $this->isRequired() ? 'required="required"' : '',
            htmlspecialchars((string)$this->getValue(), ENT_QUOTES | ENT_HTML5),
            $this->getName(),
            $this->getId()
        );
    }
}

?>