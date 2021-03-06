<?php

namespace Spatie\Menu;

use Spatie\HtmlElement\HtmlElement;
use Spatie\Menu\Traits\Activatable as ActivatableTrait;
use Spatie\Menu\Traits\HtmlAttributes;
use Spatie\Menu\Traits\ParentAttributes;

class Link implements Item, Activatable, HasUrl
{
    use ActivatableTrait, HtmlAttributes, ParentAttributes;

    /** @var string */
    protected $text;

    /** @var string */
    protected $url;

    /**
     * @param string $url
     * @param string $text
     */
    protected function __construct(string $url, string $text)
    {
        $this->url = $url;
        $this->text = $text;
        $this->active = false;

        $this->initializeHtmlAttributes();
        $this->initializeParentAttributes();
    }

    /**
     * @param string $url
     * @param string $text
     *
     * @return static
     */
    public static function to(string $url, string $text)
    {
        return new static($url, $text);
    }

    /**
     * @return string
     */
    public function getText() : string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getUrl() : string
    {
        return $this->url;
    }

    /**
     * Return a segment of the link's URL. This function works for both absolute
     * and relative URL's. The index is a 1-index based number. Trailing and
     * double slashes are ignored.
     *
     * Example: (new Link('Open Source', 'https://spatie.be/opensource'))->segment(1)
     *      => 'opensource'
     *
     * @param int $index
     *
     * @return string|null
     */
    public function segment(int $index)
    {
        $path = parse_url($this->url)['path'] ?? '';

        $segments = array_values(
            array_filter(
                explode('/', $path),
                function ($value) {
                    return $value !== '';
                }
            )
        );

        return $segments[$index - 1] ?? null;
    }

    /**
     * @param string $prefix
     *
     * @return $this
     */
    public function prefix(string $prefix)
    {
        $this->url = $prefix.'/'.ltrim($this->url, '/');

        return $this;
    }

    /**
     * @return string
     */
    public function render() : string
    {
        return HtmlElement::render(
            "a[href={$this->url}]",
            $this->htmlAttributes->toArray(),
            $this->text
        );
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->render();
    }
}
