<?php
require (__DIR__ .'/Controller.php');
class uploads extends Controller
{
    private $table = 'avatar';
    private $pdo;
    private $avatar;

    public function __construct()
    {

        $this->connectData();
    }

//    public function render($file, $variables = [])
//    {
//        require_once $file;
//        extract($variables);
//    }

    public function avatar()
    {
        $table = $this->table;
        if (isset($_POST['submit'])) {
            $filename = '';
            if ($_FILES['avatar']['error'] == 0) {
                $dir_upload = 'assets/upload';
                if (!file_exists($dir_upload)) {
                    mkdir($dir_upload);
                }
                $filename = time() . '-product-' . $_FILES['avatar']['name'];
                move_uploaded_file($_FILES['avatar']['tmp_name'], "$dir_upload/ . $filename");

                $this->avatar = $filename;
                $sql = "INSERT INTO $table(avartar) VALUES (:avatar)";
                $tmp = $this->pdo->prepare($sql);
                $insert = [
                    ':avatar' => $this->avatar
                ];
                $conn = $tmp->execute($insert);
                if ($conn) {
                    echo 'Upload thành công';
                }
            }

            $insertData = "SELECT * FROM $table";
            $sql_insert = $this->pdo->prepare($insertData);
            $sql_insert->execute();
            $sqlAvatar = $sql_insert->fetchAll(PDO::FETCH_ASSOC);
            $this->sqlAvatar = $sqlAvatar;

            $this->render('avatar.php', [
                'avatars' => 1
            ]);
            require_once 'index.php';
        }
    }

    public function connectData()
    {
        $host = '127.0.0.1';
        $db = 'php0922e2_crud';
        $user = 'root';
        $pass = '';
        $port = "3306";
        $charset = 'utf8mb4';


        $dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
        try {
            $this->pdo = new \PDO($dsn, $user, $pass);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}