<?php

namespace App\Domain\Entities;

class Uuid
{
    protected string $uuid;

    public function __construct(string $uuid)
    {
        if (!self::isValidUuid($uuid)) {
            throw new \InvalidArgumentException('UUID é inválido');
        }

        $this->uuid = $uuid;
    }

    /**
     * Converts UUID to string
     * @return string
     */
    public function toString(): string
    {
        return $this->uuid;
    }
    
    /**
     * Generates a UUID version 1
     *
     * @param string $version The UUID version to generate (1, 3, 4, or 5).
     * @param string|null $namespace The namespace for versions 3 and 5.
     * @param string|null $name The name for versions 3 and 5.
     * 
     * @return string The generated UUID.
     */
    public static function generateUuidV1()
    {
        $time = microtime(true) * 10000000 + 0x01B21DD213814000;
        $time = pack('H*', sprintf('%016x', $time));
        $node = random_bytes(6);
        $node[0] = chr(ord($node[0]) | 0x01);
        $uuid = bin2hex($time[0].$time[1].$time[2].$time[3].$time[4].$time[5].$time[6].$time[7].chr(0x01).chr(0x00).$node[0].$node[1].$node[2].$node[3].$node[4].$node[5]);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split($uuid, 4));
    }

    /**
     * Generates a UUID version 3.
     *
     * @param string $namespace The namespace UUID.
     * @param string $name The name to generate the UUID from.
     * 
     * @return string The generated UUID version 3.
     */
    public static function generateUuidV3($namespace, $name)
    {
        if (! self::isValidUuid($namespace)) {
            throw new \InvalidArgumentException('Invalid namespace UUID');
        }
        $namespace = hex2bin(str_replace(['-', '{', '}'], '', $namespace));
        $hash = md5($namespace.$name);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split($hash, 4));
    }

    /**
     * Generates a UUID version 4.
     *
     * @return string The generated UUID version 4.
     */
    public static function generateUuidV4()
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * Generates a UUID version 4.
     * 
     * @param string $namespace The namespace UUID.
     * @param string $name The name to generate the UUID from.
     * 
     * @return string The generated UUID version 5.
     */
    public static function generateUuidV5($namespace, $name)
    {
        if (!self::isValidUuid($namespace)) {
            throw new \InvalidArgumentException('Invalid namespace UUID');
        }
        $namespace = hex2bin(str_replace(['-', '{', '}'], '', $namespace));
        $hash = sha1($namespace . $name);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(substr($hash, 0, 32), 4));
    }

    /**
     * Validates if a string is a valid UUID.
     *
     * @param string $uuid The UUID to validate.
     * 
     * @return bool True if valid, false otherwise.
     */
    private static function isValidUuid($uuid)
    {
        return preg_match('/^\{?[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}\}?$/', $uuid);
    }
}