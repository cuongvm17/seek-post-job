<?php namespace Seek\Enums;

use MabeEnum\Enum;

/**
 * Work type enum
 */
class SalaryType extends Enum
{
    const ANNUAL_PACKAGE = 'AnnualPackage';
    const ANNUAL_COMMISSION = 'AnnualCommission';
    const COMMISSION_ONLY = 'CommissionOnly';
    const HOURLY_RATE = 'HourlyRate';
}
