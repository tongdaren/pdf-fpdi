<?php

namespace BD\pdf;

class PDF extends \FPDI
{
    /**
     * @var float
     */
    public $offsetX;
    /**
     * @var float
     */
    public $offsetY;


    /**
     * @param float $pt
     * @return float
     */
    public static function pt2mm($pt)
    {
        return round($pt / 72 * 25.4, 2);
    }

    /**
     * @param float $mm
     * @return float
     */
    public static function mm2pt($mm)
    {
        return round($mm * 72 / 25.4, 2);
    }

    /**
     * @param float $x
     * @param float $y
     */
    public function initOffset($x = 0.0, $y = 0.0)
    {
        $this->offsetX = $x;
        $this->offsetY = $y;
    }

    /**
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->page;
    }

    /**
     * @param int $page
     */
    public function setCurrentPage($page)
    {
        $this->page = $page;
        $this->initOffset();
    }

    /**
     * @return int[]
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * Set the current page to the last page.
     *
     * @return int
     */
    public function setEndPage()
    {
        $pages = count($this->getPages());
        $this->setCurrentPage($pages);
        $this->initOffset();
        return $pages;
    }

    /**
     * @see
     *
     * @param float $x
     * @param float $y
     */
    public function setCurrentPagePoint($x, $y)
    {
        $this->SetXY($x, $y);
    }

    /**
     * @param array $params
     * @return int
     */
    public function newPage($params = [])
    {
        $args = [
            'orientation' => '',
            'format' => '',
            'rotationOrKeepmargins' => false,
            'tocpage' => false,
        ];
        $args = array_values(array_merge($args, $params));
        parent::addPage(...$args);
        $this->initOffset();
        return $this->getCurrentPage();
    }

    /**
     * Current page size.
     *
     * @return array
     */
    public function getCurrentPageSize()
    {
        return [
            'width' => $this->w,
            'height' => $this->h,
        ];
    }

    /**
     * Specify the source PDF file used to import pages into the document.
     *
     * @param string $filename
     * @return int Returns the number of pages in the source file.
     * @throws \Exception
     */
    public function setSourceFile($filename)
    {
        return parent::SetSourceFile($filename);
    }

    /**
     * Import a page from an external PDF file.
     *
     * @param int $pageNo
     * @param string $boxName
     * @param bool $groupXObject
     * @return int
     */
    public function importPage($pageNo, $boxName = 'CropBox', $groupXObject = true)
    {
        return parent::ImportPage($pageNo, $boxName, $groupXObject);
    }

    /**
     * Insert an imported page from an external PDF file.
     *
     * @param int $tplIdx
     * @param float $x
     * @param float $y
     * @param float|int $w
     * @param float|int $h
     * @param bool $adjustPageSize
     * @return array ['w' => $w, 'h' => $h]
     */
    public function useTemplate($tplIdx, $x = null, $y = null, $w = 0, $h = 0, $adjustPageSize = false)
    {
        return parent::UseTemplate($tplIdx, $x, $y, $w, $h, $adjustPageSize);
    }

    /**
     * @param string $dst
     * @param string $name
     * @param bool $isUTF8
     * @return string
     * @internal param string $dst
     */
    public function output($dst = '', $name = '', $isUTF8 = false)
    {
        return parent::Output($dst, $name, $isUTF8);
    }

    /**
     * @param int $r
     * @param int $g
     * @param int $b
     */
    public function setTextColor($r, $g = null, $b = null)
    {
        parent::SetTextColor($r, $g, $b);
    }

    /**
     * @param int $r
     * @param int $g
     * @param int $b
     */
    public function setDrawColor($r, $g = null, $b = null)
    {
        parent::SetDrawColor($r, $g, $b);
    }

    /**
     * @param $family
     * @param string $style
     * @param null $size
     * @param string $fontfile
     * @param string $subset
     * @param bool $out
     * @return mixed|void
     */
    public function setFont($family, $style = '', $size = null, $fontfile = '', $subset = 'default', $out = true)
    {
        parent::SetFont($family, $style, $size, $fontfile, $subset, $out);
    }

    /**
     * @param $size
     * @return int
     */
    public function setFontSize($size)
    {
        $old = $this->FontSizePt;
        parent::SetFontSize($size);
        return $old;
    }

    /**
     * @param float $x1
     * @param float $y1
     * @param float $x2
     * @param float $y2
     */
    public function line($x1, $y1, $x2, $y2)
    {
        parent::Line($x1, $y1, $x2, $y2);
    }

    /**
     * @param int $w
     * @param int $h
     * @param string $txt
     * @param int $border
     * @param int $ln
     * @param string $align
     * @param bool $fill
     * @param string $link
     */
    public function cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {
        parent::Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);
    }
}