<?php

namespace App\Helpers;

class PcmHtml
{
    public static function getFieldLabel($name, $title, $tooltip = '')
    {
        $label = '';
        $text  = $title;

        // Build the class for the label.
        $dataTooltip = !empty($tooltip) ? 'data-toggle="tooltip" data-placement="top" title="" data-original-title="' . $tooltip . '"' : '';

        // Add the opening label tag and main attributes attributes.
        $label .= '<span id="' . $name . '-lbl" for="' . $name . '" ' . $dataTooltip . '>';
        $label .= $text . '</span>';

        return $label;
    }

    public static function getBooleanInput($name, $value)
    {
        $checked = ($value == 1) ? 'checked' : '';
        $html = '<div class="box-published">';
        $html .= ' <div class="custom-control custom-switch">';
        $html .= '<input type="checkbox" ' . $checked . ' value="' . config('const.is_published') . '" onclick="setValueSwitch(this)" class="custom-control-input" id="' . $name . '">';
        $html .= ' <label class="custom-control-label" for="' . $name . '"></label>';
        $html .= ' <input type="hidden" value = "' . $value . '" name=' . $name . '>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }
}
