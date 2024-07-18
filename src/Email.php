<?php

namespace Tapweb\EmailAddress;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;

class Email
{
    public const MAX_LENGTH = 64;
    private EmailValidator $validator;

    public function __construct()
    {
        $this->validator = new EmailValidator();
    }

    public function valid($email): bool
    {
        $domain = substr(strrchr($email, "@"), 1);
        if ($this->validator->isValid($email, new RFCValidation()) && strpos($domain, '.')) {
            $arr = explode("@", $email);
            if ($arr[0] > self::MAX_LENGTH || $arr[1] > self::MAX_LENGTH) {
                return false;
            }
            return true;
        }
        return false;
    }

}
