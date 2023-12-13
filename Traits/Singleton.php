<?

namespace app\Traits;

trait Singleton
{
    private static $instance;

    public static function getInstance(): self
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}
