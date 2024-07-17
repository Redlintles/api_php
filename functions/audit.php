<?php



require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findAdmin.php";

class AuditObj
{
    public string $apiKey;
    public string $type;
    public string $route;
    public string $operation;

    public function __construct(string $apiKey, string $type, string $route)
    {
        $this->apiKey = $apiKey;
        $this->type = $type;
        $this->route = $route;
        $this->operation = "unknown";
    }

    public function postAudit(string $msg, int $code)
    {
        $audit = new \Buildings\Audit();
        $dataStr = implode("/", [
            ucfirst(explode("/", $this->route)[1]),
            $this->operation,
            $code === 200 ? "success" : "error",
            $code,
            $msg
        ]);

        $username = findAdmin($this->apiKey)->getUsername();
        $audit->setOperationExecutor($username);
        $audit->setOperationType($this->type);
        $audit->setOperationRoute($this->route);
        $audit->setOperationDataString($dataStr);

        $audit->save();

    }

    public function setOperation(string $operation)
    {
        $this->operation = $operation;
    }
}
