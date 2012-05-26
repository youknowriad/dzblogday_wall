<?php

namespace Rizeway\RizewayWallBundle\Utils;

use Rizeway\RizewayWallBundle\Entity\Element;

class Grid
{
    const element_view = 'RizewayWallBundle:Element:show.html.twig';
    const empty_view   = 'RizewayWallBundle:Element:empty.html.twig';

    /**
     * @var array|\Rizeway\RizewayWallBundle\Utils\Element[]
     */
    protected $elements = array();

    /**
     * @var int
     */
    protected $width = 250;

    /**
     * @param Element[] $elements
     */
    public function __construct($elements)
    {
        // Calcul de X et Y
        $x = (int) sqrt(count($elements));
        $y = (sqrt(count($elements)) == $x) ? $x : $x + 1;
        if ($x*$y < count($elements))
        {
            $x = $y;
        }
        if (count($elements) <= 2)
        {
            $y = 2;
            $x = 1;
        }

        // Ajout des éléments vides
        $elms = $elements;
        for ($i = 0; $i < $x*$y - count($elements); $i++)
        {
            $elms[] = 'empty';
        }

        // Tri aléatoire du tableau
        shuffle($elms);
        shuffle($elms);
        $this->width = (int) ((900 - ($y * 22)) / $y);
        $this->elements = $elms;
    }

    /**
     * @param \Symfony\Bundle\FrameworkBundle\Templating\Engine $templating_engine
     * @return string
     */
    public function render($templating_engine)
    {
        // Affichage
        $html = '';
        foreach ($this->elements as $elm)
        {
            if ($elm instanceof Element)
            {
                $html .= $templating_engine->render(self::element_view, array('element' => $elm, 'width' => $this->width));
            }
            else
            {
                $html .= $templating_engine->render(self::empty_view, array('width' => $this->width));
            }
        }

        return sprintf('<div id="wall">%s</div>', $html);
    }

    public function getWidth()
    {
        return $this->width;
    }
}