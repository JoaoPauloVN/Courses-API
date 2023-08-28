<?php
namespace App\Trait;

trait TimeEstimated
{
    /**
     * Calculate estimated time to read a text
     */
    public function read(string $text): string
    {
        $readSpeed = 183;
        $words = str_word_count(strip_tags($text));
        $m = floor($words / $readSpeed);
        $s = floor($words % $readSpeed / ($readSpeed / 60));

        $return = '';

        if($m != 0) {
            $return = $m . ' ' . ($m == 1 ?  __('generic.minute') :  __('generic.minutes')) . ', ';
        }

        $return = $return . $s . ' ' . ($s == 1 ?  __('generic.second') :  __('generic.seconds'));

        return $return;
    }
}