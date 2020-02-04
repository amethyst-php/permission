<?php

namespace Amethyst\Permissions;

trait MatchDotNotation
{
    /**
     * Discovery.
     *
     * @param string $needle
     * @param array  $stack
     * @param string $wildcard
     * @param strnig $separator
     *
     * @return bool
     */
    public function match(string $needle, array $stack, string $wildcard = '*', string $separator = '.')
    {
        $pp = explode($separator, $needle);

        foreach ($stack as $p) {
            if ($needle == $p) {
                return true;
            }

            $p = explode($separator, $p);

            foreach ($p as $k => $in) {
                if ($in == $wildcard) {
                    return true;
                }

                if (!isset($pp[$k])) {
                    break;
                }

                if ($pp[$k] != $in) {
                    break;
                }
            }
        }

        return false;
    }
}
