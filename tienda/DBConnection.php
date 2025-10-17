<?php
//Conexion a la base de datos


// Clase DBConnection 
class DBConnection {
    private $host = "localhost";
    private $username = 'root';
    private $password = '';
    private $db = 'tienda';
    private $conn = null;


    //Constructor de la clase
    public function __construct(){
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db);
        if ($this->conn->connect_errno) {
            throw new Exception('DB connection error: ' . $this->conn->connect_error);
        }
        $this->conn->set_charset('utf8mb4');
    }

    public function getConnection(){
        return $this->conn;
    }



    //extraer productos de la base de datos segun el lenguaje seleccionado 
    public function fetchProducts($lang = 'es'){
        $products = [];
        if ($lang === 'en'){
            $sql = "SELECT id, name AS title, description AS description, price AS price FROM `productosen`";
        } else {
            $sql = "SELECT id, nombre AS title, descripcion AS description, precio AS price FROM `productoses`";
        }
        $result = $this->conn->query($sql);
        if ($result === false){
            throw new Exception('DB query error: ' . $this->conn->error);
        }
        while ($row = $result->fetch_assoc()){
            if (isset($row['price'])) $row['price'] = (float)$row['price'];
            $products[] = $row;
        }
        $result->free();
        return $products;
    }

    //Ingresar los productos en la tabla HTML
    public function renderProductsTable(array $products, $lang = 'es'){
        $html = '<table border="1" cellpadding="6" cellspacing="0">';
        $html .= '<thead><tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Precio</th></tr></thead><tbody>';
        foreach ($products as $p){
            $id = htmlspecialchars($p['id']);
            $title = htmlspecialchars($p['title']);
            $desc = htmlspecialchars($p['description']);
            $price = number_format((float)$p['price'], 2);
            // Link to productos.php with id and lang (lang may be handled later by cookies)
            $link = 'productos.php?id=' . urlencode($p['id']) . '&lang=' . urlencode($lang);
            $linkHtml = '<a href="' . htmlspecialchars($link) . '">' . $title . '</a>';
            $html .= "<tr><td>{$id}</td><td>{$linkHtml}</td><td>{$desc}</td><td>".htmlspecialchars($price)."</td></tr>";
        }
        $html .= '</tbody></table>';
        return $html;
    }


    // Cerramos la conexion HTML
    public function close(){
        if ($this->conn){
            $this->conn->close();
            $this->conn = null;
        }
    }
}

// Close the connection
// $conexion->close(); // This line is removed as the close method is now part of the class



?>