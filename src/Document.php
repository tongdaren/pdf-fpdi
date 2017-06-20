<?php

namespace BD\pdf;

use BD\pdf\elements\Page;
use BD\pdf\exceptions\InvalidConfigException;

/**
 * Class Document.
 *
 * @property PDF $pdf
 * @property array $data
 */
class Document
{
    /**
     * Pdf import pages.
     *
     * @var array
     */
    public $templates = [];

    /**
     * The base path for assets. (e.g. PDF template source file.)
     *
     * @var string
     */
    protected $baseTemplateDir = '';
    /**
     * The document config.
     *
     * @var array
     */
    protected $document;
    /**
     * The data for display.
     *
     * @var array
     */
    protected $data;
    /**
     * mPDF engine.
     *
     * @var PDF
     */
    protected $pdf;
    /**
     * @var bool
     */
    protected $debug = false;

    /**
     * Document constructor.
     *
     * @param array $document
     * @param array $data
     * @param array $options
     */
    public function __construct($document, $data = [], $options = [])
    {
        $this->errorCode = error_reporting();
        if (isset($options['baseTemplateDir'])) {
            $this->baseTemplateDir = realpath($options['baseTemplateDir']);
        }
        if (isset($options['debug'])) {
            $this->debug = (bool) $options['debug'];
        }

        $this->document = $this->resolveDocument($document);
        $this->data = $data;
        $this->pdf = $this->initPdf();

    }

    /**
     * Check config.
     *
     * @param array $document
     * @return array
     * @throws InvalidConfigException
     */
    protected function resolveDocument($document)
    {
        $fields = ['sourceFile', 'dhekFile', 'pages', 'sections', 'document'];
        foreach ($fields as $field) {
            if (!isset($document[$field])) {
                throw new InvalidConfigException(sprintf('$document[\'%s\'] must be set.', $field));
            }
        }

        $result = [];
        $result['sourceFile'] = $this->resolveFile($document['sourceFile'], $this->baseTemplateDir);
        $result['dhekFile'] = $this->resolveFile($document['dhekFile'], $this->baseTemplateDir);
        $result['pages'] = $document['pages'];
        $result['sections'] = $document['sections'];
        $result['document'] = array_merge(
            [
                'format' => 'Letter',
                'fontFamily' => 'Arial',
                'fontSize' => 8,
                'textColor' => [0, 0, 0],
                'pages' => [],
            ],
            $document['document']
        );

        $this->document = $result;
        return $this->document;
    }

    /**
     * @param string $path
     * @param string $base
     * @return string
     * @throws InvalidConfigException
     */
    protected function resolveFile($path, $base = '')
    {
        $path = trim($path);
        $base = trim($base);
        $path = trim($path, '/\\');
        $base = rtrim($base, '/\\');

        $file = implode('/', [$base, $path]);
        if (!is_readable($file)) {
            throw new InvalidConfigException(sprintf('File %s is not readable.', $file));
        }

        return $file;
    }

    /**
     * @return PDF
     */
    protected function initPdf()
    {
        $d = $this->document['document'];
        $pdf = new PDF('P', 'pt', $d['format']);
        error_reporting($this->errorCode);

        if ($this->debug) {
            $d['textColor'] = [255, 0, 0];
        }

        $pdf->setFont($d['fontFamily']);
        $pdf->setFontSize($d['fontSize']);
        $pdf->setTextColor(...$d['textColor']);
        $pdf->setSourceFile($this->document['sourceFile']);
        $pdf->setDrawColor(...$d['textColor']);

        return $pdf;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if (in_array($name, ['pdf', 'data', 'debug'])) {
            return $this->$name;
        }

        throw new \InvalidArgumentException();
    }

    /**
     * Render PDF document and save it to file.
     * @param string $file
     */
    public function render($file)
    {
        $pages = $this->document['document']['pages'];
        foreach ($pages as $page) {
            $page = new Page($this, $this->pageConfig($page));
            $page->render();
        }

        $this->pdf->output('F', $file);
        $this->pdf->cleanUp();
    }

    public function pageConfig($name)
    {
        $config = $this->document;
        if (!isset($config['pages'][$name])) {
            throw new InvalidConfigException('Can not find page config for ' . $name);
        }

        return $config['pages'][$name];
    }

    public function sectionConfig($name)
    {
        $config = $this->document;
        if (!isset($config['sections'][$name])) {
            throw new InvalidConfigException('Can not find section config for ' . $name);
        }

        return $config['sections'][$name];
    }

    private $_dhekData;

    /**
     * Get tags on page.
     *
     * @param int $idx
     * @return array
     * @throws InvalidConfigException
     */
    public function pageTags($idx)
    {
        if ($this->_dhekData === null) {
            $content = file_get_contents($this->document['dhekFile']);
            $this->_dhekData = json_decode($content, true);
            if ($this->_dhekData !== false) {
                $this->_dhekData = $this->_dhekData['pages'];
            } else {
                throw new InvalidConfigException('$document[\'dhekFile\'] does not contain valid JSON.');
            }
        }

        if (isset($this->_dhekData[$idx - 1]) && $this->_dhekData[$idx - 1]['areas']) {
            return $this->_dhekData[$idx - 1]['areas'];
        }
        return [];
    }

    private $_signatures = [];
    public function addSignature($tag)
    {
        $this->_signatures[] = $tag;
    }

    public function signatures()
    {
        return $this->_signatures;
    }
}
