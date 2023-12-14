<?

namespace app\Base;

use app\Traits\Singleton;

class Request
{
    use Singleton;

    public ?string $methodRequest = null;

    public ?array $bodyRequest = null;

    public ?array $paramsRequest = null;

    public function __construct()
    {

        $this->methodRequest = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        $this->paramsRequest = $_REQUEST;

        $input = file_get_contents('php://input');
        $this->bodyRequest = json_decode($input, true);
    }

    public function getMethodRequest(): ?string
    {
        return $this->methodRequest;
    }
    public function getBody(): ?array
    {
        return $this->bodyRequest;
    }

    public function getParams(): ?array
    {
        return $this->paramsRequest;
    }
}
