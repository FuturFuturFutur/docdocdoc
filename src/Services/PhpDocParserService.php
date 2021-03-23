<?php


namespace Futurfuturfutur\Docdocdoc\Services;


class PhpDocParserService
{
    public static function parsePhpDoc(string $phpDoc)
    {
        $pattern = "#(@[a-zA-Z]+\s*[a-zA-Z0-9, ()_].*)#";

        preg_match_all($pattern, $phpDoc, $matches, PREG_PATTERN_ORDER);

        $params = array();
        foreach ($matches[0] as $param)
        {
            $explodedParam = explode(' ', $param);
            $name = $explodedParam[0];
            unset($explodedParam[0]);
            $data = implode(' ', $explodedParam);

            if (strpos($name, '@DocDocDocRoute') !== false) {
                $params[strtolower(str_replace('@DocDocDocRoute', '', $name))] = $data;
            }
        }

        return $params;
    }
}
