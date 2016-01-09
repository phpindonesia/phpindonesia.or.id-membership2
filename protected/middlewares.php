<?php
/*
 * Middleware for setting up Core App View variables.
 * This mean all view variable setup here is a CORE view vars
 */
$app->add(function ($request, $response, $next) {
	$this['view']->getPlates()->addData(array(
		'_view_validation_errors_' => array(),
		'_view_js_' => array(),
		'_view_css_' => array(),
	));

	return $next($request, $response);
});

/*
 * Middleware for checking user authentication
 * Check wether a user already logged in or not
 */
$app->add(function ($request, $response, $next) {
	$uri = $request->getUri();

	$exclude_from_auth = $this['settings']['exclude_from_auth'];
	$base_path = $uri->getBasePath() != '' ? $uri->getBasePath() : '';
	$path = '';

	if ($uri->getBasePath() != '' && $uri->getPath() == '/') {
	    $path = '/';
	} else if ($uri->getBasePath() != '' && $uri->getPath() != '/') {
	    $path = '/'.$uri->getPath();
	} else if ($uri->getBasePath() == '') {
	    $path = $uri->getPath();
	}

	// $request_path = $base_path.$path;
	$request_path = $path;

	$contain = false;
    if ($request_path != '/apps/membership') {
    	foreach ($exclude_from_auth as $item) {
            if ($item == '/apps/membership') {
                continue;
            } else {
                $str_path = str_replace('/', '\/', $item);
                if (preg_match('/'.$str_path.'/i', $request_path)) {
                    $contain = true;
                    break;
                }
            }
    	}
    } else {
        $contain = true;
    }

	if (!$contain) {
        if (!isset($_SESSION['MembershipAuth'])) {
            $this['flash']->addMessage('error', 'You are not authenticated');
            return $response->withStatus(302)->withHeader('Location', $this['router']->pathFor('membership-login'));
        }
	}

	return $next($request, $response);
});

