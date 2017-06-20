<?php

namespace BD\pdf\elements;

use BD\pdf\Document;
use BD\pdf\exceptions\InvalidConfigException;

class Page implements Render
{
    /**
     * @var Document
     */
    protected $context;
    /**
     * @var array
     */
    protected $sections = [];

    /**
     * @var Section[]
     */
    private $_sections = [];
    /**
     * @var Tag[]
     */
    private $_tags = [];
    /**
     * @var int
     */
    private $_page;


    /**
     * Page constructor.
     *
     * @param Document $context
     * @param array $sections
     */
    public function __construct(Document $context, $sections = [])
    {
        $this->context = $context;
        $this->sections = $sections;
        $this->_page = $this->context->pdf->newPage();
        $this->buildSections();
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->_page;
    }

    /**
     * @throws InvalidConfigException
     */
    public function buildSections()
    {
        $data = $this->context->data;
        foreach ($this->sections as $section) {
            $section = array_merge(
                [
                    'container' => [],
                    'type' => 'once',
                ],
                (array) $section
            );

            if (!isset($section['section'])) {
                throw new InvalidConfigException(sprintf('$section[\'%s\'] must be set.'), 'section');
            }


            if ($section['type'] == 'loop') {
                if (!isset($section['dataIdx'])) {
                    throw new InvalidConfigException(sprintf('$section[\'%s\'] must be set. because it is an loop section.'), 'dataIdx');
                }

                $items = isset($data[$section['dataIdx']]) ? $data[$section['dataIdx']] : [];
                $container = new Area($section['container']);
                $section['container'] = clone $container;
                foreach ($items as $item) {
                    $tmp = new Section($this->context, $this, $section, $item);
                    $container->y += $tmp->getArea()->h;
                    $section['container'] = clone $container;
                }
            } else {
                if (isset($section['dataIdx'])) {
                    $data = isset($data[$section['dataIdx']]) ? $data[$section['dataIdx']] : [];
                }
                new Section($this->context, $this, $section, $data);
            }
        }
    }

    /**
     * Add tag to the tag stacks of this page.
     *
     * @param Tag $tag
     */
    public function addTag(Tag $tag)
    {
        $this->_tags[] = $tag;
    }

    /**
     * Add section to the section stacks of this page.
     *
     * @param Section $section
     */
    public function addSection(Section $section)
    {
        $this->_sections[] = $section;
    }

    /**
     * @inheritdoc
     */
    public function render()
    {
        $this->context->pdf->setCurrentPage($this->_page);

        foreach ($this->_sections as $section) {
            $section->render();
        }

        foreach ($this->_tags as $tag) {
            $tag->render();
        }
    }
}