<?php

namespace BD\pdf\elements;

class CheckboxTag extends Tag
{
    public function render()
    {
        if ($this->data) {
            $pdf = $this->context->pdf;
            $x1 = $this->area->x;
            $y1 = $this->area->y;
            $x2 = $this->area->x + $this->area->w;
            $y2 = $this->area->y + $this->area->h;

            $pdf->line($x1, $y1, $x2, $y2);
            $pdf->line($x1, $y2, $x2, $y1);
        }
    }
}