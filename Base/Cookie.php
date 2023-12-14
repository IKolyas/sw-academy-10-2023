<?

namespace app\Base;

use app\Traits\Singleton;

class Cookie
{
    use Singleton;

    private ?array $cookies;

    public function __construct()
    {
        $this->cookies = $_COOKIE;
    }

    public function getCookie(string $key): ?string
    {
        return $this->cookies[$key] ?? null;
    }

    public function setCookie(string $key, string $value): void
    {
        setcookie($key, $value, time() + 60 * 60 * 24, '/');
        $this->cookies = $_COOKIE;
    }
}
