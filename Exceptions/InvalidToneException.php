<?php

/**
* Exception raised when user tries to set a tone color, but is not valid,
* or the color is brown or gray and the tone is accent (not supported)
*/
class InvalidToneException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
?>