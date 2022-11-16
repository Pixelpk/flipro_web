<?php
namespace App\Libs\Interfaces;

interface Campaign {
    public function getName(): string;
    public function getDescription(): string;
    public static function getLeads($campaign);
    public function requireList() : bool;
    public function requireTag() : bool;
    public static function handle($campaign);
}