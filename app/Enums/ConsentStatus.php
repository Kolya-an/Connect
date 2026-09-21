<?php
namespace App\Enums;

enum ConsentStatus: string
{
    case PENDING = 'pending';
    case GENERATED = 'generated';
    case SIGNED = 'signed';
    case DECLINED = 'declined';
}