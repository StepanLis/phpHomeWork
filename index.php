<?php 
abstract class ShopProduct 
{

    function __construct(private string $title, private float $weight, private int $amount, private float $price) 
    {
        
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function setTitle(string $new_title) : void
    {
        $this->title = $new_title;
    }

    public function getWeight() : float
    {
        return $this->weight;
    }

    public function setWeight(float $new_weight) : void
    {
        $this->weight = $new_weight;
    }

    public function getAmount() : int
    {
        return $this->amount;
    }

    public function setAmount(int $new_amount)  : void
    {
        $this->amount = $new_amount;
    }

    public function getPrice() : float
    {
        return $this->price;
    }

    public function setPrice(float $new_price) : void
    {
        $this->price = $new_price;
    }

    

    abstract public function actionCreate(PDO $mysql) : void;

    public static function getInstance(int $id, PDO $mysql)
    {
        $stmt = $mysql->prepare("SELECT * FROM `products` WHERE id=?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!empty($row))
        {
            return null;
        }

        if ($row["product_type"] === "cd")
        {
            return new CDProduct(
                $row["title"],
                (float) $row["weight"],
                (int) $row["amount"],
                (float) $row["price"],
                $row["cover_link"],
                (float) $row["length"],
                $row["type"],
                $row["author"]
            );
        } elseif ($row["product_type"] === "book") {
            return new BookProduct(
                $row["title"],
                (float) $row["weight"],
                (int) $row["amount"],
                (float) $row["price"],
                $row["author"],
                (int) $row["page_amount"],
                $row["serial_number"],
                $row["rating"],
                $row["genre"]
            );
        }
    }
}

class CDProduct extends ShopProduct 
{
    function __construct
    ( 
    string $title, 
    float $weight, 
    int $amount, 
    float $price,
    
    private string $cover_link,
    private float $length,
    private string $type,
    private string $author
    )
    {
        parent::__construct($title, $weight, $amount, $price);

        $this->cover_link = $cover_link;
        $this->length = $length;
        $this->type = $type;
        $this->author = $author;
    }

    public function getCoverLink() : string
    {
        return $this->cover_link;
    }

    public function setCoverLink(string $new_cover_link) : void
    {
        $this->cover_link = $new_cover_link;
    }

    public function getLength() : float
    {
        return $this->length;
    }

    public function setLength(float $new_length) : void 
    {
        $this->length = $new_length;
    }

    public function getType() : string
    {
        return $this->type;
    }

    public function setType(string $new_type) : void 
    {
        $this->type = $new_type;
    }

    public function getAuthor() : string
    {
        return $this->author;
    }

    public function setAuthor(int $new_author) : void 
    {
        $this->author = $new_author;
    }

    public function actionCreate(PDO $mysql) : void
    {
        $stmt = $mysql->prepare("INSERT INTO `products` (`title`, `weight`, `amount`, `price`, `product_type`)
        VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([$this->getTitle(), $this->getWeight(), $this->getAmount(), $this->getPrice(), "cd"]);

        $stmt = $mysql->prepare("INSERT INTO `cdProducts` (`product_id`, `cover_link`, `length`, `type`, `author`)
        VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([$mysql->lastInsertId(), $this->cover_link, $this->length, $this->type, $this->author]);
    }
}

class BookProduct extends ShopProduct
{
    function __construct
    (
    string $title, 
    float $weight, 
    int $amount, 
    float $price,
    
    private string $author,
    private int $page_amount,
    private string $serial_number,
    private int $rating,
    private string $genre,
    )
    {
        parent::__construct($title, $weight, $amount, $price);

        $this->author = $author;
        $this->page_amount = $page_amount;
        $this->serial_number = $serial_number;
        $this->rating = $rating;
        $this->genre = $genre;
    }

    public function getAuthor() : string 
    {
        return $this->author;
    }

    public function setAuthor(string $new_author) : void
    {
        $this->author = $new_author;
    }

    public function getPageAmount() : int 
    {
        return $this->page_amount;
    }

    public function setPageAmount(int $new_page_amount) : void
    {
        $this->page_amount = $new_page_amount;
    }

    public function getSerialNumber() : string 
    {
        return $this->serial_number;
    }

    public function setSerialNumber(string $new_srn) : void
    {
        $this->serial_number = $new_srn;
    }

    public function getRating() : int 
    {
        return $this->rating;
    }

    public function setRating(string $new_srn) : void
    {
        $this->serial_number = $new_srn;
    }

    public function getGenre() : string 
    {
        return $this->genre;
    }

    public function setGenre(string $new_genre) : void
    {
        $this->genre = $new_genre;
    }

    public function actionCreate(PDO $mysql) : void
    {
        $stmt = $mysql->prepare("INSERT INTO `products` (`title`, `weight`, `amount`, `price`, `product_type`)
        VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([$this->getTitle(), $this->getWeight(), $this->getAmount(), $this->getPrice(), "book"]);

        $stmt = $mysql->prepare("INSERT INTO `bookProducts` (`product_id`, `author`, `page_amount`, `serial_number`, `rating`, `genre`)
        VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$mysql->lastInsertId(), $this->author, $this->page_amount, $this->serial_number, $this->rating, $this->genre]);
    }
}

class WebSite {

    public function createConnection(string $dbName, string $dbLogin, string $dbPass) : PDO
    {
        $dsn = "mysql:host=localhost;dbname=" . $dbName . ";charset=UTF8";
        $pdo = new PDO($dsn, $dbLogin, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $pdo->query("
        CREATE TABLE IF NOT EXISTS `products` (
            `id` int(11) PRIMARY KEY AUTO_INCREMENT,
            `title` VARCHAR(255) NOT NULL,
            `weight` float(255,2) NOT NULL,
            `amount` int(255) NOT NULL,
            `price` float(255,2) NOT NULL,
            `product_type` VARCHAR(255)
        );
        
        CREATE TABLE IF NOT EXISTS `cdProducts` (
            `product_id` INT,
            `cover_link` VARCHAR(255) NOT NULL,
            `length` float(15,2) NOT NULL,
            `type` VARCHAR(255) NOT NULL,
            `author` VARCHAR(255) NOT NULL,
               
            FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
        );

        CREATE TABLE IF NOT EXISTS `bookProducts` (
            `product_id` INT,
            `author` VARCHAR(255) NOT NULL,
            `page_amount` INT(20) NOT NULL,
            `serial_number` VARCHAR(10) NOT NULL,
            `rating` INT(2) NOT NULL,
            `genre` VARCHAR(10) NOT NULL,
                       
            FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
        );
        ");

        return $pdo;
    }

    public function showProductInfo(mixed $product) : void
    {
        $string = "No product found <br>";

        if ($product instanceof CDProduct) {
            $string = "CDProduct <br> 
            Title: {$product->getTitle()} <br> Weight: {$product->getWeight()} kg <br> Amount: {$product->getAmount()} <br> Price: {$product->getPrice()} <br> <br>
            Cover Link: {$product->getCoverLink()} <br> Length: {$product->getLength()} <br> Type: {$product->getTitle()} <br> Author: {$product->getAuthor()}
            <br> <br>";
        } elseif ($product instanceof BookProduct) {
            $string = "BookProduct <br> 
            Title: {$product->getTitle()} <br> Weight: {$product->getWeight()} kg <br> Amount: {$product->getAmount()} <br> Price: {$product->getPrice()} <br> <br>
            Author: {$product->getAuthor()} <br> Genre: {$product->getGenre()} <br> Page Amount: {$product->getPageAmount()} <br> Rating: {$product->getRating()} <br> SRN: {$product->getSerialNumber()}
            <br> <br>";
        }

        print($string);
    }
}

$page = new WebSite();
$mysql = $page->createConnection("arhzfxgj_m4", "arhzfxgj", "Ju5M96");

$cdProduct = new CDProduct("The End", 15.0, 1, 307827.84, "img/test.jpg", 15.23, "CD-RW", "Testoviy Chelovek");
$cdProduct->actionCreate($mysql);
$page->showProductInfo($cdProduct);

$bookProduct = new BookProduct("Testovaya Knishka", 15.0, 1, 1231.41, "Lousville", 22, "YBSNW-2823", 5, "Drama");
$bookProduct->actionCreate($mysql);
$page->showProductInfo($bookProduct);