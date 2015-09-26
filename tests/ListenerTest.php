<?php

/*
 * This file is part of HtmlCompress.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WyriHaximus\HtmlCompress\Tests\Integrations\Sculpin;

use Phake;
use WyriHaximus\HtmlCompress\Integrations\Sculpin\Listener;

class ListenerTest extends \PHPUnit_Framework_TestCase {

    public function testOnAfterFormatFastest() {
        $event = Phake::mock('Sculpin\Core\Event\SourceSetEvent');
        $listener = Phake::mock('WyriHaximus\HtmlCompress\Integrations\Sculpin\Listener');
        Phake::when($listener)->compress($this->isInstanceOf('WyriHaximus\HtmlCompress\Parser'), $event);
        Phake::when($listener)->onAfterFormatFastest($event)->thenCallParent();
        $listener->onAfterFormatFastest($event);
        Phake::verify($listener)->compress($this->isInstanceOf('WyriHaximus\HtmlCompress\Parser'), $event);
    }

    public function testOnAfterFormat() {
        $event = Phake::mock('Sculpin\Core\Event\SourceSetEvent');
        $listener = Phake::mock('WyriHaximus\HtmlCompress\Integrations\Sculpin\Listener');
        Phake::when($listener)->compress($this->isInstanceOf('WyriHaximus\HtmlCompress\Parser'), $event);
        Phake::when($listener)->onAfterFormat($event)->thenCallParent();
        $listener->onAfterFormat($event);
        Phake::verify($listener)->compress($this->isInstanceOf('WyriHaximus\HtmlCompress\Parser'), $event);
    }

    public function testOnAfterFormatSmallest() {
        $event = Phake::mock('Sculpin\Core\Event\SourceSetEvent');
        $listener = Phake::mock('WyriHaximus\HtmlCompress\Integrations\Sculpin\Listener');
        Phake::when($listener)->compress($this->isInstanceOf('WyriHaximus\HtmlCompress\Parser'), $event);
        Phake::when($listener)->onAfterFormatSmallest($event)->thenCallParent();
        $listener->onAfterFormatSmallest($event);
        Phake::verify($listener)->compress($this->isInstanceOf('WyriHaximus\HtmlCompress\Parser'), $event);
    }

    public function testCompress() {
        $sourceA = Phake::mock('Sculpin\Core\Source\SourceInterface');
        Phake::when($sourceA)->filename()->thenReturn('index.html');
        Phake::when($sourceA)->formattedContent()->thenReturn('foo');

        $sourceB = Phake::mock('Sculpin\Core\Source\SourceInterface');
        Phake::when($sourceB)->filename()->thenReturn('robots.txt');

        $event = Phake::mock('Sculpin\Core\Event\SourceSetEvent');
        Phake::when($event)->allSources()->thenReturn(array(
            $sourceA,
            $sourceB
        ));

        $listener = new Listener();
        $listener->onAfterFormatSmallest($event);

        Phake::inOrder(
            Phake::verify($event)->allSources(),
            Phake::verify($sourceA)->filename(),
            Phake::verify($sourceA)->formattedContent(),
            Phake::verify($sourceB)->filename()
        );

        Phake::verify($sourceB, Phake::never())->formattedContent();
    }

}
