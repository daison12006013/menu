<?php

namespace spec\Spatie\Navigation\Displayers;

use PhpSpec\Exception\Example\FailureException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spatie\Navigation\Displayers\MenuDisplayer;
use Spatie\Navigation\Groups\Group;
use Spatie\Navigation\Items\Link;

class MenuDisplayerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(MenuDisplayer::class);
    }

    function it_can_display_a_link()
    {
        $link = new Link('Home', 'https://spatie.be');

        $this->display($link)->shouldRender('
            <ul>
                <li>
                    <a href="https://spatie.be">Home</a>
                </li>
            </ul>
        ');
    }

    function it_can_display_an_active_link()
    {
        $link = (new Link('Home', 'https://spatie.be'))->setActive();

        $this->display($link)->shouldRender('
            <ul>
                <li class="active">
                    <a href="https://spatie.be">Home</a>
                </li>
            </ul>
        ');
    }

    function it_can_display_a_group()
    {
        $group = new Group(
            new Link('Home', 'https://spatie.be'),
            new Link('Open Source', 'https://spatie.be/opensource')
        );

        $this->display($group)->shouldRender('
            <ul>
                <li>
                    <a href="https://spatie.be">Home</a>
                </li>
                <li>
                    <a href="https://spatie.be/opensource">Open Source</a>
                </li>
            </ul>
        ');
    }

    function it_can_display_a_group_that_contains_an_active_link()
    {
        $group = new Group(
            new Link('Home', 'https://spatie.be'),
            (new Link('Open Source', 'https://spatie.be/opensource'))->setActive()
        );

        $this->display($group)->shouldRender('
            <ul>
                <li>
                    <a href="https://spatie.be">Home</a>
                </li>
                <li class="active">
                    <a href="https://spatie.be/opensource">Open Source</a>
                </li>
            </ul>
        ');
    }

    function getMatchers() : array
    {
        return [
            'render' => function ($subject, $html) {
                $html = preg_replace('/>\s+</', '><', $html);
                $html = preg_replace('/(^\s+)|(\s+$)/', '', $html);

                if ($subject !== $html) {
                    throw new FailureException("expected {$html} but got {$subject}");
                }

                return true;
            },
        ];
    }
}
