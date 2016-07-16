<?php

    require_once 'helpers/renderer.php';
    require_once 'vendor/autoload.php';
    require_once 'twi_keys.php';

    use Abraham\TwitterOAuth\TwitterOAuth;

    session_start();

    function indexAction()
    {
        if (!isset($_SESSION['access_token'])) {

            $callback_url = ROOT_URL . '?action=' . TWI_AUTH_ACTION;
            $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
            $request_token = $connection->oauth('oauth/request_token',
                ['oauth_callback' => $callback_url]);
            $_SESSION['oauth_token'] = $request_token['oauth_token'];
            $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
            $url = $connection->url('oauth/authorize',
                ['oauth_token' => $request_token['oauth_token']]);
            $_SESSION['redirect_url'] = $url;
            $action = TWI_REDIRECT_ACTION;
        } else {
            $action = SAVED_ACTION;
        }

        return render('views/index', compact('action'));
    }

    function twiredirectAction()
    {
        $url = ROOT_URL;
        if (!empty($_POST['username']) && !empty($_SESSION['redirect_url'])) {
            $_SESSION['username'] = $_POST['username'];
            $url = $_SESSION['redirect_url'];
        }

        redirect($url);
    }

    function twiauthAction()
    {
        $request_token = [];
        $request_token['oauth_token'] = $_SESSION['oauth_token'];
        $request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];

        if (!isset($_REQUEST['oauth_token'], $_REQUEST['oauth_verifier'], $_SESSION['username']) || $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
            redirect(ROOT_URL);
        }
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);
        $access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $_REQUEST['oauth_verifier']]);
        $_SESSION['access_token'] = $access_token;
        $list_uri = spy($access_token, $_SESSION['username']);

        redirect("https://twitter.com/" . $list_uri);
    }

    function savedAction()
    {
        if (!isset($_SESSION['access_token'], $_POST['username'])) {
            redirect(ROOT_URL);
        }
        $list_uri = spy($_SESSION['access_token'], $_POST['username']);

        redirect("https://twitter.com/" . $list_uri);
    }

    /**
     * creates new private list for user on twitter
     * and fills it with users which are followed
     * by user with given username
     * @param  array $access_token access tokens
     * @param  string $username     twitter username
     * @return string            created list uri
     */
    function spy($access_token, $username)
    {
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'],
            $access_token['oauth_token_secret']);
        $ids = $connection->get('friends/ids', ['screen_name' => $username,
            'count' => 5000])->ids;
        $list = $connection->post('lists/create', ['name' => $username,
            'mode' => 'private']);
        $list_id = $list->id;
        $list_uri = $list->uri;
        $ids = array_chunk($ids, 100);
        foreach ($ids as $key => $user_id) {
            $user_id = join(',', $user_id);
            $connection->post('lists/members/create_all',compact('list_id', 'user_id'));
        }

        return $list_uri;
    }