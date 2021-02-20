<?php


namespace App\Utils;


class ContentRangeHeader
{
    public static function getContentRangeHeader(int $page, int $pageSize, int $total): string
    {
        $first = $pageSize * ($page - 1);
        $last = $first + ($pageSize - 1);
        if ($total === 0) {
            $first = 0;
            $last = 0;
        } else if ($last > $total - 1) {
            $last = $total - 1;
            if ($first > $last) {
                $first = $last;
            }
        }
        return sprintf("items %d-%d/%d", $first, $last, $total);
    }
}