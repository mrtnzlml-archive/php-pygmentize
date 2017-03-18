<?php

/**
 * Comment
 */
class Aaa extends Bbb implements Ccc {

    public const SINGLE = 'OK';
    private const DOUBLE = "OK";

    public function run(?string $variable): void
    {
        $out = <<<"HEREDOC"
This is $variable string...
HEREDOC;
        $_x = __NAMESPACE__ . `ls -l`;
        return; //void comment
    }

    public function __destruct()
    {
        $this->self = new self(
            self::DOUBLE,
            10e3, -6.7, 007, 0xabc,
            "string $variable string"
        );
    }

}

(new Aaa)->run();
