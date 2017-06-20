<?php

namespace BD\pdf\elements;

use BD\pdf\Document;

class TagFactory
{
    /**
     * @param Document $context
     * @param Page $page
     * @param array $config
     * @param array $data
     * @return Tag
     */
    public static function create(Document $context, Page $page, $config, $data = [])
    {
        if (!isset($config['type'])) {
            $config['type'] = 'text';
        }

        $type = strtolower($config['type']);
        $args = func_get_args();
        if ($type === 'checkbox') {
            return new CheckboxTag(...$args);
        } elseif ($type === 'radio') {
            return new SignatureTag(...$args);
        } else {
            return new Tag(...$args);
        }
    }
}