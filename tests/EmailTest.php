<?php

namespace Tapweb\EmailAddress\Test;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tapweb\EmailAddress\Email;

class EmailTest extends TestCase
{
    public static function invalidEmailProvider(): array
    {
        return [
            '正常なメールアドレス' => ['omura@fb.tapweb.jp', true],
            '無効なメールアドレス' => ['invalid_email', false],
            'ドットを含むメールアドレス' => ['firstname.lastname@domain.com', true],
            'サブドメインを含むメールアドレス' => ['email@subdomain.domain.com', true],
            'プラス記号を含むメールアドレス' => ['firstname+lastname@domain.com', true],
            'IPアドレスを含むメールアドレス' => ['email@123.123.123.123', false],
            '角括弧で囲まれたIPアドレスを含むメールアドレス' => ['email@[123.123.123.123]', false],
            '@記号がない' => ['plainaddress', false],
            'ローカル部がない' => ['@no-local-part.com', false],
            '名前とメールアドレスを含む' => ['Outlook Contact <email@domain.com>', false],
            '@記号がない' => ['no-at.domain.com', false],
            'トップレベルドメインがない' => ['no-tld@domain', false],
            'ローカル部に連続したドットがある' => ['double..dot@domain.com', false],
            'ドメイン部に連続したドットがある' => ['email@domain..com', false],
            'メール名が64文字を超えています' => ['aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa@gmail.com', false],
            'ドメイン名が 64 文字を超えている' => ['email@aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa.com', false],
            'ローカル部分に特殊文字が含まれています' => ['abc#def@mail.com', false],
            'メールアドレスにはアンダースコアが付いています' => ['abc_def@mail.com', true],
            'メールアドレスにはハイフンが含まれています' => ['abc-def@mail.com', true],
            'ドメイン名を含むメールアドレスの教育' => ['xxx@willcorp.education', true]
        ];
    }

    /**
     * @return void
     */
    #[DataProvider('invalidEmailProvider')] public function testValid($emailAddress, bool $expected)
    {
        $email = new Email();
        $this->assertEquals($expected, $email->valid($emailAddress));
    }
}
