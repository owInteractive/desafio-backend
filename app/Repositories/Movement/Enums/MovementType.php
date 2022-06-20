<?php
namespace App\Repositories\Movement\Enums;

enum MovementType: int
{
    case debit=1;
    case credit=2;
    case reversal=3;

    /**
     * @return array<int,string>
     */
    public static function all(): array
    {
        return [
            self::debit->name,
            self::credit->name,
            self::reversal->name,
        ];
    }

    /**
     * @param $type
     *
     * @return int
     */
    public static function type($type): int
    {
        return match($type)
        {
            self::debit->name => 1,
            self::credit->name => 2,
            self::reversal->name => 3,
        };
    }
}
