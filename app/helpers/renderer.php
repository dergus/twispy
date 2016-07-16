<?php
    /**
     * renders given php file
     * @param  string  $file    file path relative to APP_ROOT
     * @param  array   $params  variables to be extracted in
     * rendering file
     * @param  boolean $partial whether render without layout or with
     * @return string           rendering result
     */
    function render($file, $params = [], $partial = false)
    {
        extract($params);
        ob_start();
        include(APP_ROOT . '/' . $file . '.php');
        $content = ob_get_clean();

        //if file has layout and should  be
        //rendered with layout, also render layout
        if (!empty($__layout) && !$partial) {
            $params = isset($layoutParams) ? $layoutParams : [];
            $params['content'] = $content;
            $content = render($__layout, $params);
        }
        return $content;
    }

