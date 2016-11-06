<?php

namespace Custom\CMSBundle\Twig;

use Custom\CMSBundle\Util\DateUtil;

class MyFilterExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('ago', array($this, 'agoFilter')),
        );
    }

    public function agoFilter(\Datetime $dt)
    {
        return DateUtil::ago($dt);
    }

    public function getName()
    {
        return 'my_filter_extension';
    }
}