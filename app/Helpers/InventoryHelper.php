<?php

namespace App\Helpers;

class InventoryHelper
{
    /**
     * @throws \Exception
     */
    public static function getExpiryStatus($expiryDate): string
    {
        $days = self::getDaysUntilExpiry($expiryDate);
        if ($days < 0) return 'expired';
        if ($days < 30) return 'expiring';
        return 'good';
    }

    /**
     * @throws \Exception
     */
    public static function getDaysUntilExpiry($expiryDate): float|int
    {
        $today = now();
        $expiry = new \DateTime($expiryDate);
        $diff = $today->diff($expiry);
        $days = $diff->days * ($diff->invert ? -1 : 1);
        return $days;
    }
}
