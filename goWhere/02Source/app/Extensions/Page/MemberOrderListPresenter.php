<?php

namespace App\Extensions\Page;

use Illuminate\Pagination\BootstrapThreePresenter;

class MemberOrderListPresenter extends BootstrapThreePresenter
{
    /**
     * Convert the URL window into Bootstrap HTML.
     *
     * @return string
     */
    public function render()
    {
        if ($this->hasPages()) {
            return sprintf(
                '<div class="pagination">%s %s %s</div>', $this->getPreviousButton(trans('common.pre_page')), $this->getLinks(), $this->getNextButton(trans('common.next_page'))
            );
        }

        return '';
    }

    /**
     * Get HTML wrapper for active text.
     *
     * @param  string  $text
     * @return string
     */
    protected function getActivePageWrapper($text, $rel=null)
    {
        $rel = is_null($rel) ? '' : (' ' . $rel);
        return '<span class="current'.$rel.'">'.$text.'</span>';
    }

    /**
     * Get HTML wrapper for disabled text.
     *
     * @param  string  $text
     * @return string
     */
    protected function getDisabledTextWrapper($text, $rel = null)
    {
        $class = '';
        if($rel) {
            $class = ' class="current '.$rel.'"';
        }
        return '<span' . $class . '>' . $text . '</span>';
    }

    /**
     * Get HTML wrapper for an available page link.
     *
     * @param  string  $url
     * @param  int  $page
     * @param  string|null  $rel
     * @return string
     */
    protected function getAvailablePageWrapper($url, $page, $rel = null)
    {
        $class = is_null($rel) ? '' : ' class="' . $rel . '"';
        $rel = is_null($rel) ? '' : ' rel="' . $rel . '"';

        return '<a href="' . htmlentities($url) . '"' . $class . $rel . '>' . $page . '</a>';
    }

    /**
     * Get the previous page pagination element.
     *
     * @param  string  $text
     * @return string
     */
    public function getPreviousButton($text = '&laquo;')
    {
        // If the current page is less than or equal to one, it means we can't go any
        // further back in the pages, so we will render a disabled previous button
        // when that is the case. Otherwise, we will give it an active "status".
        if ($this->paginator->currentPage() <= 1) {
            return $this->getDisabledTextWrapper($text, 'prev');
        }

        $url = $this->paginator->url(
            $this->paginator->currentPage() - 1
        );

        return $this->getPageLinkWrapper($url, $text, 'prev');
    }
    /**
     * Get the next page pagination element.
     *
     * @param  string  $text
     * @return string
     */
    public function getNextButton($text = '&raquo;')
    {
        // If the current page is greater than or equal to the last page, it means we
        // can't go any further into the pages, as we're already on this last page
        // that is available, so we will make it the "next" link style disabled.
        if (!$this->paginator->hasMorePages()) {
            return $this->getDisabledTextWrapper($text, 'next');
        }

        $url = $this->paginator->url($this->paginator->currentPage() + 1);

        return $this->getPageLinkWrapper($url, $text, 'next');
    }

}