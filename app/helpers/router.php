<?php

    /**
     * a simple router function
     * runs function whose action is equal to current action,
     * outputs it's returning and exits script.
     * if there is no handler for current action
     * runs $defaultAction
     * @param  string $currentAction current action
     * @param  array $handlers      action => function name
     */
    function handle($currentAction, $defaultAction, $handlers)
    {
        $action = isset($handlers[$currentAction]) ?
                    $handlers[$currentAction] :
                    $defaultAction;
        $action .= 'Action';
        echo $action();
        die;
    }

    /**
     * redirects user to the given url and
     * exits script
     * @param  string $url where to redirect
     */
    function redirect($url)
    {
        header('Location: ' . $url);
        die;
    }