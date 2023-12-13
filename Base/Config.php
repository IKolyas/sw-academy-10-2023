<?

namespace app\Base;

use app\Traits\Singleton;

class Config
{
    use Singleton;

    private ?array $config = null;
    private ?string $name = null;



    public function __construct()
    {
        $this->config = include $_SERVER['DOCUMENT_ROOT'] . '/../config/config.php' ?: null;
        $this->config['envInfo'] = parse_ini_file("./../.env") ?: null;
    }

    public function getData(): ?array
    {
        return $this->config;
    }

    public function getConfig($name): ?array
    {
        return $this->config[$name] ?: null;
    }
}
