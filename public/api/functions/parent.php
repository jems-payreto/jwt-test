<?php
class MainFunction {
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function prepareAndExecute($params = array(), $sql) {
        $stmt = $this->pdo->prepare($sql);

        foreach($params as $param => &$paramDetails) {
            $paramValue = &$paramDetails['value'];
            $paramType = &$paramDetails['type'];

            $stmt->bindParam(':' . $param, $paramValue, $paramType);
        }

        $result = $stmt->execute();

        // For SELECT queries
        if(stripos($sql, 'SELECT') === 0) {
            if ($result === false) {
                $this->exceptionHandler('Error when executing the SQL query.');
            }

            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $stmt->closeCursor();

            return $data;
        }

        // For UPDATE queries, return the number of affected rows
        $rowCount = $stmt->rowCount();
        $stmt->closeCursor();

        return $rowCount;
    }

    protected function handleUpdateResponse($rowCount) {
        if($rowCount > 0) {
            return json_encode(['success' => true, 'message' => 'Updated successfully']);
        } else {
            return json_encode(['success' => false, 'message' => 'No rows were updated.']);
        }
    }

    protected function exceptionHandler($errorMessage) {
        throw new Exception($errorMessage);
    }
}
?>
