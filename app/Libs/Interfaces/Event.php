<?php
namespace App\Libs\Interfaces;

interface Event {
    public function hasExecuted();
    public function execute($data);
    public function hasError();
}