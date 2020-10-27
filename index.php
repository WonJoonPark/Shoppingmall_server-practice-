<?php
require './pdos/DatabasePdo.php';
require './pdos/ItemGetPdo.php';
require './pdos/ItemStatusPdo.php';
require './pdos/MainPdo.php';
require './pdos/ShopPdo.php';
require './pdos/ReviewPdo.php';
require './pdos/ItemInfoPdo.php';
require './pdos/UserInfoPdo.php';
require './pdos/CommentPdo.php';
require './vendor/autoload.php';


use \Monolog\Logger as Logger;
use Monolog\Handler\StreamHandler;

date_default_timezone_set('Asia/Seoul');
ini_set('default_charset', 'utf8mb4');

//에러출력하게 하는 코드
//error_reporting(E_ALL); ini_set("display_errors", 1);

//Main Server API
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    /* ******************   Test   ****************** */
    $r->addRoute('GET', '/item', ['ItemGetController', 'item']);
    $r->addRoute('GET', '/storeitem', ['StoreController', 'storeitem']);
    $r->addRoute('POST', '/basket', ['ItemStatusController', 'insertbasket']);
    $r->addRoute('GET', '/basket', ['ItemStatusController', 'lookupbasket']);
    $r->addRoute('DELETE', '/basket', ['ItemStatusController', 'deletebasket']);
    $r->addRoute('POST', '/likeitem', ['ItemStatusController', 'insertlikeitem']);
    $r->addRoute('DELETE', '/likeitem', ['ItemStatusController', 'deletelikeitem']);
    $r->addRoute('GET', '/likeitem', ['ItemStatusController', 'lookuplikeitem']);
    $r->addRoute('GET', '/orderstatus', ['ItemStatusController', 'orderstatus']);
    $r->addRoute('POST', '/directbuy', ['ItemStatusController', 'directbuy']);
    $r->addRoute('POST','/shop',['ShopController','addshop']);
    $r->addRoute('DELETE','/shop',['ShopController','deleteshop']);
    $r->addRoute('GET','/shop',['ShopController','lookupshop']);
    $r->addRoute('POST','/prefershop',['ShopController','addprefershop']);
    $r->addRoute('DELETE','/prefershop',['ShopController','deleteprefershop']);
    $r->addRoute('GET','/prefershop',['ShopController','lookupprefershop']);
    $r->addRoute('GET','/review',['ReviewController','lookupreview']);
    $r->addRoute('GET','/itemreview',['ReviewController','itemreview']);
    $r->addRoute('GET','/satisfaction',['ReviewController','satisfaction']);
    $r->addRoute('DELETE','/review',['ReviewController','delreview']);
    $r->addRoute('POST','/review',['ReviewController','insertreview']);
    $r->addRoute('GET','/itemsize',['ItemInfoController','lookupsize']);
    $r->addRoute('POST','/itemsize',['ItemInfoController','insertsize']);
    $r->addRoute('DELETE','/itemsize',['ItemInfoController','deletesize']);
    $r->addRoute('GET','/itemcolor',['ItemInfoController','lookupcolor']);
    $r->addRoute('POST','/itemcolor',['ItemInfoController','insertcolor']);
    $r->addRoute('DELETE','/itemcolor',['ItemInfoController','deletecolor']);
    $r->addRoute('PATCH','/review',['ReviewController','modifyreview']);
    $r->addRoute('POST','/easyaccount',['UserInfoController','inserteasyaccount']);
    $r->addRoute('GET','/easyaccount',['UserInfoController','lookupeasyaccount']);
    $r->addRoute('DELETE','/easyaccount',['UserInfoController','deleteeasyaccount']);
    $r->addRoute('POST','/refundaccount',['UserInfoController','insertrefundaccount']);
    $r->addRoute('GET','/refundaccount',['UserInfoController','lookuprefundaccount']);
    $r->addRoute('DELETE','/refundaccount',['UserInfoController','deleterefundaccount']);
    $r->addRoute('POST','/bodysize',['UserInfoController','insertbodysize']);
    $r->addRoute('GET','/bodysize',['UserInfoController','lookupbodysize']);
    $r->addRoute('POST','/comment',['CommentController','inputcomment']);
    $r->addRoute('GET','/comment',['CommentController','getcomment']);
    $r->addRoute('GET','/email',['MailController','email']);
    $r->addRoute('GET','/paging',['CommentController','paging']);

   // $r->addRoute('GET','/kakao_login_callback',['KakaoController','callback']);
    $r->addRoute('POST','/kakao_login_gettoken',['KakaoController','gettoken']);
    $r->addRoute('GET','/kakao_membership_in',['KakaoController','getmembership']);
    $r->addRoute('GET','/kakao_token_info',['KakaoController','tokeninfo']);


    $r->addRoute('GET', '/jwt', ['MainController', 'validateJwt']);
    $r->addRoute('POST', '/jwt', ['MainController', 'createJwt']);

    


//    $r->addRoute('GET', '/users', 'get_all_users_handler');
//    // {id} must be a number (\d+)
//    $r->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
//    // The /{title} suffix is optional
//    $r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

// 로거 채널 생성
$accessLogs = new Logger('ACCESS_LOGS');
$errorLogs = new Logger('ERROR_LOGS');
// log/your.log 파일에 로그 생성. 로그 레벨은 Info
$accessLogs->pushHandler(new StreamHandler('logs/access.log', Logger::INFO));
$errorLogs->pushHandler(new StreamHandler('logs/errors.log', Logger::ERROR));
// add records to the log
//$log->addInfo('Info log');
// Debug 는 Info 레벨보다 낮으므로 아래 로그는 출력되지 않음
//$log->addDebug('Debug log');
//$log->addError('Error log');

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        echo "404 Not Found";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        echo "405 Method Not Allowed";
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        switch ($routeInfo[1][0]) {
            case 'ItemGetController':
                $handler = $routeInfo[1][1];
                $vars = $routeInfo[2];
                require './controllers/ItemGetController.php';
                break;
            case 'MainController':
                $handler = $routeInfo[1][1];
                $vars = $routeInfo[2];
                require './controllers/MainController.php';
                break;
            case 'ItemStatusController':
                $handler = $routeInfo[1][1];
                $vars = $routeInfo[2];
                require './controllers/ItemStatusController.php';
                break;
            case 'ShopController':
                $handler = $routeInfo[1][1];
                $vars = $routeInfo[2];
                require './controllers/ShopController.php';
                break;
            case 'ReviewController':
                $handler = $routeInfo[1][1];
                $vars = $routeInfo[2];
                require './controllers/ReviewController.php';
                break;
            case 'ItemInfoController':
                $handler = $routeInfo[1][1];
                $vars = $routeInfo[2];
                require './controllers/ItemInfoController.php';
                break;
            case 'UserInfoController':
                $handler = $routeInfo[1][1];
                $vars = $routeInfo[2];
                require './controllers/UserInfoController.php';
                break;
            case 'CommentController':
                $handler = $routeInfo[1][1];
                $vars = $routeInfo[2];
                require './controllers/CommentController.php';
                break;
            case 'MailController':
                $handler = $routeInfo[1][1];
                $vars = $routeInfo[2];
                require './controllers/MailController.php';
                break;
            case 'KakaoController':
                $handler = $routeInfo[1][1];
                $vars = $routeInfo[2];
                require './controllers/KakaoController.php';
                break;
            /*case 'function':
                $handler = $routeInfo[1][1];
                $vars = $routeInfo[2];
                require './controllers/function.php';
                break;*/


            /*case 'EventController':
                $handler = $routeInfo[1][1]; $vars = $routeInfo[2];
                require './controllers/EventController.php';
                break;
            case 'ProductController':
                $handler = $routeInfo[1][1]; $vars = $routeInfo[2];
                require './controllers/ProductController.php';
                break;
            case 'SearchController':
                $handler = $routeInfo[1][1]; $vars = $routeInfo[2];
                require './controllers/SearchController.php';
                break;
            case 'ReviewController':
                $handler = $routeInfo[1][1]; $vars = $routeInfo[2];
                require './controllers/ReviewController.php';
                break;
            case 'ElementController':
                $handler = $routeInfo[1][1]; $vars = $routeInfo[2];
                require './controllers/ElementController.php';
                break;
            case 'AskFAQController':
                $handler = $routeInfo[1][1]; $vars = $routeInfo[2];
                require './controllers/AskFAQController.php';
                break;*/
        }

        break;
}
