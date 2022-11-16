<?php
namespace App\Enums;

enum UserType:string {
    case HOMEOWNER = 'home-owner';
    case BUILDER = 'builder';
    case EVALUATOR = 'evaluator';
    case FRANCHISE = 'franchise';
    case ADMIN = 'admin';
}