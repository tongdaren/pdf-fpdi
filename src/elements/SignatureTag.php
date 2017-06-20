<?php

namespace BD\pdf\elements;

class SignatureTag extends Tag
{
    public function render()
    {
        $area = $this->area->toArray();
        $data = array_merge(
            [
                'email' => null,
                'name' => null,
                'id' => null,
            ],
            (array) $this->data
        );

        $tmp = explode('.', $this->name);
        $type = array_pop($tmp);
        $tab = [
            'x' => $area['x'],
            'y' => $area['y'],
            'page' => $this->page->getPage(),
            'type' => $type,
            'scaleValue' => isset($this->value['scaleValue']) ? $this->value['scaleValue'] : 1,
        ];

        $data['tab'] = $tab;
        $this->context->addSignature($data);
    }
}
