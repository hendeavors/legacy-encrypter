<?php

use Illuminate\Support\Str;
use Laravel\LegacyEncrypter\McryptEncrypter;
use PHPUnit\Framework\TestCase;

class EncrypterTest extends TestCase
{
    public function testEncryption()
    {
        $e = $this->getEncrypter();
        $this->assertNotEquals('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', $e->encrypt('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'));
        $encrypted = $e->encrypt('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
        $this->assertEquals('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', $e->decrypt($encrypted));
    }

    public function testJsonValueEncryption()
    {
        $value = json_encode(['key' => 'value']);
        $e = $this->getEncrypter();
        $this->assertNotEquals($value, $e->encrypt($value, false));
        $encrypted = $e->encrypt($value, false);
        $this->assertEquals($value, $e->decrypt($encrypted, false));
    }

    /**
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage The value [{"key":"value"}] cannot be unserialized. Did you forget to set $unserialize to false?
     */
    public function testInvalidDecryptionUsageEncryption()
    {
        $value = json_encode(['key' => 'value']);
        $e = $this->getEncrypter();
        $this->assertNotEquals($value, $e->encrypt($value, false));
        $encrypted = $e->encrypt($value, false);
        $this->assertEquals($value, $e->decrypt($encrypted));
    }


    public function testEncryptionWithCustomCipher()
    {
        $e = $this->getEncrypter();
        $e->setCipher(MCRYPT_RIJNDAEL_256);
        $this->assertNotEquals('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', $e->encrypt('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'));
        $encrypted = $e->encrypt('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
        $this->assertEquals('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', $e->decrypt($encrypted));
    }

    /**
     * @expectedException Illuminate\Contracts\Encryption\DecryptException
     */
    public function testExceptionThrownWhenPayloadIsInvalid()
    {
        $e = $this->getEncrypter();
        $payload = $e->encrypt('foo');
        $payload = str_shuffle($payload);
        $e->decrypt($payload);
    }


    protected function getEncrypter()
    {
        return new McryptEncrypter(str_repeat('a', 32));
    }
}
