<?php

namespace Spatie\Menu;

use Spatie\Menu\Traits\Activatable as ActivatableTrait;
use Spatie\Menu\Traits\ParentAttributes;

class Html implements Item, Activatable
{
    use ActivatableTrait, ParentAttributes;

    /** @var string */
    protected $html;

    /**
     * @param string $html
     */
    protected function __construct(string $html)
    {
        $this->html = $html;
        $this->active = false;

        $this->initializeParentAttributes();
    }

    /**
     * Create an item containing a chunk of raw html.
     *
     * @param string $html
     *
     * @return static
     */
    public static function raw(string $html)
    {
        return new static($html);
    }

    /**
     * @return string
     */
    public function getHtml() : string
    {
        return $this->html;
    }

    /**
     * @return string
     */
    public function render() : string
    {
        return $this->html;
    }
}
