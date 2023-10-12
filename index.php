<?php 
class ShopProduct 
{

    function __construct(private string $title, private float $weight, private int $amount, private float $price) 
    {
        
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function setTitle(string $new_title)
    {
        $this->title = $new_title;
    }

    public function getWeight() : float
    {
        return $this->weight;
    }

    public function setWeight(float $new_weight)
    {
        $this->weight = $new_weight;
    }

    public function getAmount() : int
    {
        return $this->amount;
    }

    public function setAmount(int $new_amount)
    {
        $this->amount = $new_amount;
    }

    public function getPrice() : float
    {
        return $this->price;
    }

    public function setPrice(int $new_price)
    {
        $this->price = $new_price;
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

    public function setCoverLink(string $new_cover_link) 
    {
        $this->cover_link = $new_cover_link;
    }

    public function getLength() : float
    {
        return $this->length;
    }

    public function setLength(float $new_length) 
    {
        $this->length = $new_length;
    }

    public function getType() : string
    {
        return $this->type;
    }

    public function setType(string $new_type) 
    {
        $this->type = $new_type;
    }

    public function getAuthor() : string
    {
        return $this->author;
    }

    public function setAuthor(int $new_author) 
    {
        $this->author = $new_author;
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

    public function setAuthor(string $new_author)
    {
        $this->author = $new_author;
    }

    public function getPageAmount() : int 
    {
        return $this->page_amount;
    }

    public function setPageAmount(int $new_page_amount)
    {
        $this->page_amount = $new_page_amount;
    }

    public function getSerialNumber() : string 
    {
        return $this->serial_number;
    }

    public function setSerialNumber(string $new_srn)
    {
        $this->serial_number = $new_srn;
    }

    public function getRating() : int 
    {
        return $this->rating;
    }

    public function setRating(string $new_srn)
    {
        $this->serial_number = $new_srn;
    }

    public function getGenre() : string 
    {
        return $this->genre;
    }

    public function setGenre(string $new_genre)
    {
        $this->genre = $new_genre;
    }
}

class Program {
    public function showProductInfo(ShopProduct $shopProduct) 
    {
        $string = "ShopProduct <br> Title: {$shopProduct->getTitle()} <br> Weight: {$shopProduct->getWeight()} kg <br> Amount: {$shopProduct->getAmount()} <br> Price: {$shopProduct->getPrice()} <br> <br>";
        print($string);
    }

    public function showCDProduct(CDProduct $cdProduct) 
    {
        $string = "CDProduct <br> 
        Title: {$cdProduct->getTitle()} <br> Weight: {$cdProduct->getWeight()} kg <br> Amount: {$cdProduct->getAmount()} <br> Price: {$cdProduct->getPrice()} <br> <br>
        Cover Link: {$cdProduct->getCoverLink()} <br> Length: {$cdProduct->getLength()} <br> Type: {$cdProduct->getTitle()} <br> Author: {$cdProduct->getAuthor()}
        <br> <br>";
        print($string);
    }

    public function showBookProduct(BookProduct $bookProduct) 
    {
        $string = "BookProduct <br> 
        Title: {$bookProduct->getTitle()} <br> Weight: {$bookProduct->getWeight()} kg <br> Amount: {$bookProduct->getAmount()} <br> Price: {$bookProduct->getPrice()} <br> <br>
        Author: {$bookProduct->getAuthor()} <br> Genre: {$bookProduct->getGenre()} <br> Page Amount: {$bookProduct->getPageAmount()} <br> Rating: {$bookProduct->getRating()} <br> SRN: {$bookProduct->getSerialNumber()}
        <br> <br>";
        print($string);
    }
}

$page = new Program();

$shopProduct = new ShopProduct("Test Product", 15.0, 1, 15000.23);
$page->showProductInfo($shopProduct);

$cdProduct = new CDProduct("The End", 15.0, 1, 307827.84, "img/test.jpg", 15.23, "CD-RW", "Testoviy Chelovek");
$page->showCDProduct($cdProduct);

$bookProduct = new BookProduct("Testovaya Knishka", 15.0, 1, 1231.41, "Lousville", 22, "YBSNW-2823", 5, "Drama");
$page->showBookProduct($bookProduct);