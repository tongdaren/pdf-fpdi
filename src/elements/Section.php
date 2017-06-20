<?php

namespace BD\pdf\elements;

use BD\pdf\Document;
use BD\pdf\exceptions\InvalidConfigException;

class Section implements Render
{
    /**
     * @var Document
     */
    protected $context;
    /**
     * @var Page
     */
    protected $page;
    /**
     * @var Area
     */
    protected $area;
    /**
     * @var Area
     */
    protected $container;
    /**
     * @var int
     */
    protected $tplIdx;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var array
     */
    protected $data;


    /**
     * Section constructor.
     *
     * @param Document $context
     * @param Page $page
     * @param array $config
     * @param array $data
     * @throws InvalidConfigException
     */
    public function __construct(Document $context, Page $page, $config, $data = [])
    {
        $this->context = $context;
        $this->data = $data;
        $this->page = $page;
        $this->page->addSection($this);

        if (!isset($config['container'])) {
            throw new InvalidConfigException();
        }
        if (!isset($config['section'])) {
            throw new InvalidConfigException();
        }

        $section = $this->context->sectionConfig($config['section']);
        if (!isset($section['tplIdx'])) {
            throw new InvalidConfigException(sprintf('$config[\'%s\'] must be set.', 'tplIdx'));
        }

        if ($config['container'] instanceof Area) {
            $this->container = $config['container'];
        } else {
            $this->container = new Area($config['container']);
        }

        $this->area = new Area($section['area']);
        $this->tplIdx = (int) $section['tplIdx'];
        $this->name = $config['section'];

        $this->buildTags();
    }

    /**
     * @return Area
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * @return Area
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Build tags.
     */
    public function buildTags()
    {
        $tags = $this->context->pageTags($this->tplIdx);

        foreach ($tags as $tag) {
            $data = $this->getTagData($tag['name']);
            if ($data === null) {
                continue;
            }

            $area = new Area([
                'x' => $tag['x'],
                'y' => $tag['y'],
                'w' => $tag['width'],
                'h' => $tag['height'],
            ]);
            $area->x = $this->container->x + ($area->x - $this->area->x);
            $area->y = $this->container->y + ($area->y - $this->area->y);

            $tag['area'] = $area;
            TagFactory::create($this->context, $this->page, $tag, $data);
        }
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getTagData($name)
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function render()
    {
        $pdf = $this->context->pdf;
        if (!isset($this->context->templates[$this->name])) {
            $idx = $pdf->importPage($this->tplIdx);
            $this->context->templates[$this->name] = $idx;
        } else {
            $idx = $this->context->templates[$this->name];
        }

        $pdf->useTemplate($idx, $this->container->x, $this->container->y);
    }
}
