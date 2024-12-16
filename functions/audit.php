<?php



require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findAdmin.php";
/**
 * Store and controls the auditory of the application
 */
class AuditObj
{
    /**
     * @var string The api Key of the user
     */
    public string $apiKey;
    /**
     * @var string The CRUD type of the Operation, can be CREATE, READ, UPDATE and DELETE.
     */
    public string $type;
    /**
     * @var string The route of the request
     */
    public string $route;
    /**
     * @var string A more detailed, generally two word string, description of the operation
     */
    public string $operation;

    /**
     * Initialize the Audit Object
     * @param string $apiKey The api Key of the user
     * @param string $type The route of the request
     * @param string $route A more detailed, generally two word string, description of the operation
     */

    public function __construct(string $apiKey, string $type, string $route)
    {
        $this->apiKey = $apiKey;
        $this->type = $type;
        $this->route = $route;
        $this->operation = "unknown";
    }
    /**
     * Saves the audit Object in the Database
     * @param string $msg The message of the response
     * @param string $code The status code of the response
     */

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

    /**
     * Sets the operation string
     * @param string $operation The new operation string
     */

    public function setOperation(string $operation)
    {
        $this->operation = $operation;
    }
}
