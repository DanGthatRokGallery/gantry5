<?php

/**
 * @package   Gantry5
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2015 RocketTheme, LLC
 * @license   GNU/GPLv2 and later
 *
 * http://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Gantry\Framework;

use Gantry\Admin\ThemeList;
use Gantry\Component\Filesystem\Folder;
use Gantry\Framework\Base\Configurations as BaseConfigurations;
use Gantry\Joomla\StyleHelper;
use RocketTheme\Toolbox\ResourceLocator\UniformResourceLocator;

class Configurations extends BaseConfigurations
{
    /**
     * @param string $path
     * @return $this
     */
    public function load($path = 'gantry-config://')
    {
        $gantry = Gantry::instance();

        $styles = ThemeList::getStyles($gantry['theme.name']);

        $configurations = [];
        foreach ($styles as $style) {
            $old = isset($style->params['configuration']) ? $style->params['configuration'] : null;
            if ($old != $style->id) {
                // New style generated by Joomla.
                StyleHelper::copy($style, $old, $style->id);
            }
            $configurations[$style->id] = $style->style;
        }

        asort($configurations);

        $this->items = $this->addDefaults($configurations);

        return $this;
    }
}
