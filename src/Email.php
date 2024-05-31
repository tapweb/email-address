<?php

namespace Tapweb\EmailAddress;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;

class Email
{
    private EmailValidator $validator;

    public function __construct()
    {
        $this->validator = new EmailValidator();
    }

    public function valid($email): bool
    {
        $domain = substr(strrchr($email, "@"), 1);
        if ($this->validator->isValid($email, new RFCValidation()) && strpos($domain, '.')) {
            return true;
        }
        return false;
    }

}
