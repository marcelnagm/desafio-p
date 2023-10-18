<?php
namespace App\Trait;

trait  ArrayExpressible {
    public function toArray() {
        return get_object_vars($this);
    }
}