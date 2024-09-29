<?php 
namespace App\test;
class test {
    private static int $number;
    public function __construct(private $amount)
    {
        
    }
    public function __destruct()
    {
        echo "hello";
    }
    public function kek($num){
        $this->amount += $num;
        return $this;
    }
    public function getAmount()
    {
        return $this->amount;
    }
    public static function setAmount($num){
        self::$number = $num;
        return self::$number;
    }
}
echo "test";
$test = (new test(1))->kek(2)->getAmount();
var_dump($test);


// class testt{
//     const TEST = "CONSTANT VALUE";
//     public function hi(){
//         echo "hi";
//     }
//     public static function hello(){
//         echo "hello";
//     }
// }
// $testt = new testt();
// echo(testt::TEST);
// $num = 2;
// $x = true;
// $y = true;
// var_dump($x XOR $y);
// $array = array(1,2);

// $arrayElementCount = array_push($array, 1);

// var_dump($array);
// var_dump($arrayElementCount);

// function ke(int &$num){
//     $num += 1;
// }
// $n1 = 1;
// echo $n1;
// ke($n1);
// echo $n1;

// $curl = curl_init();

// curl_setopt($curl, CURLOPT_URL, 'http://localhost/MVC_API/api/user');
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// $response = curl_exec($curl);

// curl_close($curl);

// $response = json_decode($response);
// print_r($response);
// print_r($response);
// var_dump($curl);

$json = json_encode(["hello"=> "hellos"]);

$startMemory = memory_get_usage();

// Define your variable
// $variable = ['example' => 'data', 'more' => 'data', 'numbers' => range(1, 1000)];
$json = gzcompress('{
  "user": {
    "id": 12345,
    "name": "Edward Kenzo Rivas",
    "email": "edward.rivas@example.com",
    "location": {
      "city": "Quezon City",
      "country": "Philippines"
    },
    "education": {
      "college": "Quezon City University",
      "campus": "San Bartolome",
      "degree": "Bachelor\'s Degree",
      "graduation_year": 2024
    },
    "skills": [
      "JavaScript",
      "Python",
      "Data Analysis",
      "Web Development"
    ],
    "experience": [
      {
        "job_title": "Intern",
        "company": "Tech Solutions Inc.",
        "start_date": "2023-06-01",
        "end_date": "2023-09-01",
        "responsibilities": [
          "Assisted in web development projects",
          "Created and tested APIs",
          "Participated in code reviews"
        ]
      }
    ],
    "hobbies": [
      "Photography",
      "Gaming",
      "Traveling"
    ]
  }
}');

$endMemory = memory_get_usage();

$memoryUsage = $endMemory - $startMemory;
// echo $memoryUsage;
echo gzcompress($json);
// echo gzuncompress($json);