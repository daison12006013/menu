<?php

namespace Spatie\Menu\Test;

use Spatie\Menu\Items\Link;
use Spatie\Menu\Menu;

class MenuAddTest extends MenuTestCase
{
    /** @test */
    function it_starts_as_an_empty_list()
    {
        $this->menu = Menu::new();

        $this->assertRenders('<ul></ul>');
    }

    /** @test */
    function it_renders_an_item()
    {
        $this->menu = Menu::new()->add(Link::to('#', 'Hello'));

        $this->assertRenders('
            <ul>
                <li><a href="#">Hello</a></li>
            </ul>
        ');
    }

    /** @test */
    function it_renders_multiple_items()
    {
        $this->menu = Menu::new()
            ->add(Link::to('#', 'Hello'))
            ->add(Link::to('#', 'World'));

        $this->assertRenders('
            <ul>
                <li><a href="#">Hello</a></li>
                <li><a href="#">World</a></li>
            </ul>
        ');
    }

    /** @test */
    function it_adds_an_active_class_to_active_items()
    {
        $this->menu = Menu::new()
            ->add(Link::to('#', 'Hello')->setActive());

        $this->assertRenders('
            <ul>
                <li class="active"><a href="#">Hello</a></li>
            </ul>
        ');
    }

    /** @test */
    function it_renders_submenus()
    {
        $this->menu = Menu::new()
            ->add(Menu::new()
                ->add(Link::to('#', 'In Too Deep'))
            );

        $this->assertRenders('
            <ul>
                <li>
                    <ul>
                        <li><a href="#">In Too Deep</a></li>
                    </ul>
                </li>
            </ul>
        ');
    }

    /** @test */
    function it_adds_active_classes_to_active_submenus()
    {
        $this->menu = Menu::new()
            ->add(Menu::new()
                ->add(Link::to('#', 'In Too Deep')->setActive())
            );

        $this->assertRenders('
            <ul>
                <li class="active">
                    <ul>
                        <li class="active"><a href="#">In Too Deep</a></li>
                    </ul>
                </li>
            </ul>
        ');
    }
}
