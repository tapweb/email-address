<?php

namespace Tapweb\EmailAddress;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;

class Email
{
    public const MAX_LENGTH = 64;
    public const MAX_DOT_DOMAIN = 2;
    private EmailValidator $validator;

    public function __construct()
    {
        $this->validator = new EmailValidator();
    }

    public function valid($email): bool
    {
        $domain = substr(strrchr($email, "@"), 1);
        if ($this->validator->isValid($email, new RFCValidation()) && strpos($domain, '.')) {
            return $this->isValidEmailRule((string)$email);
        }
        return false;
    }

    private function isValidEmailRule(string $email): bool
    {
        $arr = explode("@", $email);
        $domain = $arr[1];
        if (strlen($arr[0]) > self::MAX_LENGTH || strlen($domain) > self::MAX_LENGTH) {
            return false;
        }
        if (substr_count($domain, ".") > self::MAX_DOT_DOMAIN) {
            return false;
        }
        return true;
    }

}
