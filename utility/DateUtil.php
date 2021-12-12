<?php

class DateUtil
{
    public const TZ_DEFAULT = 'Europe/Sofia';
    public const TZ_UTC = 'UTC';

    public const FORMAT_DATE_TIME_MYSQL = 'Y-m-d H:i:s';

//    public const FORMAT_DATE_TIME_FRONTEND = 'Y-m-d H:i:s';

    public const FORMAT_DATE_TIME_FRONTEND = 'Y/m/d H:i:s';

    /**
     * @param string $dateTimeString
     * @param string $newFormat
     * @param string|null $timezone
     * @return string
     * @throws Exception
     */
    public static function reformatDateTimeString(string $dateTimeString, string $newFormat, string $timezone = null): string
    {
        $dateTime = new DateTimeImmutable($dateTimeString, $timezone);
        return $dateTime->format($newFormat);
    }

    /**
     * Converts a datetime string to one in the UTC timezone with a specified format
     *
     * @param string $dateTimeString - the one to convert
     * @param string $timeZone - the timezone of the $dateTimeString, defaults to self::TZ_DEFAULT
     * @param string $format - the output format, defaults to self::FORMAT_DATE_TIME_MYSQL
     * @return string - the converted datetime string in UTC timezone in the desired format
     * @throws Exception
     */
    public static function toUTCDateTimeString(
        string $dateTimeString,
        string $timeZone = self::TZ_DEFAULT,
        string $format = self::FORMAT_DATE_TIME_MYSQL
    ): string {
        $utc = new \DateTimeZone(self::TZ_UTC);
        $currentTz = new \DateTimeZone($timeZone);
        $dateTime = new \DateTime($dateTimeString, $currentTz);
        $dateTime->setTimezone($utc);
        return $dateTime->format($format);
    }

    /**
     * Converts a datetime string from one in the UTC timezone to a specific TZ with a specified format
     *
     * @param string $dateTimeString - the one to convert
     * @param string $timeZone - the desired timezone, defaults to self::TZ_DEFAULT
     * @param string $format - the output format, defaults to self::FORMAT_DATE_TIME_FRONTEND
     * @return string - the converted datetime string in the desired timezone in the desired format
     * @throws Exception
     */
    public static function fromUTCDateTimeString(
        string $dateTimeString,
        string $timeZone = self::TZ_DEFAULT,
        string $format = self::FORMAT_DATE_TIME_FRONTEND
    ): string {
        $utc = new \DateTimeZone(self::TZ_UTC);
        $desiredTz = new \DateTimeZone($timeZone);
        $dateTime = new \DateTime($dateTimeString, $utc);
        $dateTime->setTimezone($desiredTz);
        return $dateTime->format($format);
    }
}