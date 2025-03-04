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
            return $this->isValidEmailRule((string)$email);
        }
        return false;
    }

    private function isValidEmailRule(string $email): bool
    {
        $arr = explode("@", $email);
        $localPart = $arr[0];
        $domain = $arr[1];
        if (strlen($localPart) > self::MAX_LENGTH || strlen($domain) > self::MAX_LENGTH) {
            return false;
        }
        $domainPattern = '/^(?!\.)[a-zA-Z0-9\-]*(?:\.[a-zA-Z0-9\-]+)*\.[a-z]+$/';
        if (!preg_match($domainPattern, $domain)) {
            return false;
        }
        $localPartPattern = '/^[a-zA-Z0-9\-_+](?!.*?\.\.)(?:[a-zA-Z0-9\-_+]*(?:\.[a-zA-Z0-9\-_+]+)*)?$/';
        if (!preg_match($localPartPattern, $localPart)) {
            return false;
        }
        return true;
    }

}
