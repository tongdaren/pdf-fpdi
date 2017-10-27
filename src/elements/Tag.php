<?php

namespace BD\pdf\elements;

use BD\pdf\Document;

class Tag implements Render
{
    /**
     * @var Document
     */
    protected $context;
    /**
     * @var Area
     */
    protected $area;
    /**
     * @var Page
     */
    protected $page;
    /**
     * @var array
     */
    protected $schema;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var mixed
     */
    protected $data;
    /**
     * @var $array
     */
    protected $value;

    /**
     * Tag constructor.
     *
     * @param Document $context
     * @param Page $page
     * @param array $config
     * @param array $data
     */
    public function __construct(Document $context, Page $page, $config, $data)
    {
        $this->context = $context;
        $this->area = $config['area'];
        $this->page = $page;
        $this->data = $data;
        $this->schema = $config;
        $this->name = $config['name'];
        $this->page->addTag($this);

        if (isset($config['value'])) {
            $this->value = @json_decode($config['value'], true) ?: [];
        }
    }

    /**
     * @inheritdoc
     */
    public function render()
    {
        $old = null;
        if (isset($this->value['fontSize'])) {
            $old = $this->context->pdf->setFontSize($this->value['fontSize']);
        }

        $this->context->pdf->setCurrentPagePoint($this->area->x, $this->area->y);
        $this->context->pdf->cell($this->area->w, $this->area->h, $this->data);

        if ($old) {
            $this->context->pdf->setFontSize($old);
        }
    }
}
