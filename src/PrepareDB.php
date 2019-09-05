<?php


namespace App;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class Init
 * @package App
 */
class PrepareDB implements CommandInterface
{
    /** @var array */
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function execute(): void
    {
        try {
            $conn = new \PDO("mysql:host=mysql;dbname=" . $this->config['dbName'], $this->config['dbUser'], $this->config['dbPassword']);
            $conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );

            $sql ="CREATE TABLE IF NOT EXISTS " . $this->config['tableName'] . " (
                id INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
                `sum` INT NOT NULL,
                `count_fib` INT NOT NULL,
                `count_prime` INT NOT NULL) ENGINE=InnoDB CHARSET=utf8" ;
            $conn->exec($sql);

            $query = $conn->prepare("SELECT * FROM " . $this->config['tableName'] . " LIMIT 1");
            $query->execute();
            if (!$query->fetch()) {
                $sql = "INSERT INTO " . $this->config['tableName'] . " (`sum`, `count_fib`, `count_prime`) VALUES (?,?,?)";
                $stmt= $conn->prepare($sql);
                $stmt->execute([0, 0, 0]);
            }
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }
    }
}