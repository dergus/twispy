<?php
    $__layout = 'views/layout';
    $layoutParams['title'] = 'TwiSpy';
?>

<div class="col-xs-2 col-xs-offset-5">
    <h1>TwiSpy</h1>
</div>
<div class="row">
    <form class="form-horizontal" method="post" action = '?action=<?=$action?>'>
        <div class="form-group form-group-xs">
            <div class="col-xs-6 col-xs-offset-3">
                <input class="form-control" type="text" name = 'username' placeholder="twitter username">
            </div>
        </div>
       <div class="form-group">
            <div class="col-xs-offset-4 col-xs-4">
                <button type="submit" class="btn btn-primary btn-lg btn-block">Continue</button>
            </div>
       </div>
    </form>
</div>