<?

# Возвращает ссылку по роуту
function getRoueUrl($routeName) {
    $urlRoute = Router::getInstance()->getUrlByName($routeName);
    $protocol = (empty($_SERVER['HTTPS'])) ? 'http://' : 'https://';
    return "$protocol{$_SERVER['HTTP_HOST']}$urlRoute";
}