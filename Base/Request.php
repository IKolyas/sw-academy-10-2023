<?

namespace app\Base;

use app\Traits\Singleton;

class Request
{
    use Singleton;

    public ?string $postName = null;
    public ?string $postMessage = null;
    public ?string $getName = null;
    public ?string $getMessage = null;


    public function __construct()
    {
        $this->postName = $_POST["name"] ?? "NO NAME";
        // print_r($this->postName);
        $this->postMessage = $_POST["message"] ?? "NO MESSAGE";
        // print_r($this->postMessage);
        $this->getName = $_GET["name"] ?? "NO NAME";
        // print_r($this->getName);
        $this->getMessage = $_GET["message"] ?? "NO MESSAGE";
        // print_r($this->getMessage);

    }

    public function getRequest()
    {
        return [
            'postName' => $this->postName,
            'postMessage' => $this->postMessage,
            'getName' => $this->getName,
            'getMessage' => $this->getMessage,
        ];
    }
}
