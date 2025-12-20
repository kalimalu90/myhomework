<?php
// ========== التعاريف الأساسية ==========

// 1. المتغيرات
$integer = 100;
$float = 99.99;
$string = "Hello PHP";
$boolean = true;
$array = [1, 2, 3];
$assoc_array = ['name' => 'John', 'age' => 25];
$null = null;

// 2. الثوابت
define("SITE_NAME", "MyWebsite");
const VERSION = "1.0.0";

// ========== العبارات الشرطية ==========

// if
if ($boolean) {
  echo "Boolean is true<br>";
}

// if...else
if ($integer > 50) {
  echo "Integer is greater than 50<br>";
} else {
  echo "Integer is 50 or less<br>";
}

// if...elseif...else
$score = 85;
if ($score >= 90) {
  echo "Grade: A<br>";
} elseif ($score >= 80) {
  echo "Grade: B<br>";
} elseif ($score >= 70) {
  echo "Grade: C<br>";
} else {
  echo "Grade: F<br>";
}

// switch
$role = "editor";
switch ($role) {
  case "admin":
    echo "Welcome Admin<br>";
    break;
  case "editor":
    echo "Welcome Editor<br>";
    break;
  case "author":
    echo "Welcome Author<br>";
    break;
  default:
    echo "Welcome Guest<br>";
}

// العامل الثلاثي
$age = 20;
$status = ($age >= 18) ? "Adult" : "Minor";
echo "Status: $status<br>";

// ========== الحلقات ==========

// for
echo "for loop: ";
for ($i = 0; $i < 5; $i++) {
  echo $i . " ";
}
echo "<br>";

// while
echo "while loop: ";
$j = 0;
while ($j < 3) {
  echo $j . " ";
  $j++;
}
echo "<br>";

// do...while
echo "do...while loop: ";
$k = 0;
do {
  echo $k . " ";
  $k++;
} while ($k < 3);
echo "<br>";

// break في حلقة متداخلة
echo "break example: ";
for ($a = 0; $a < 5; $a++) {
  if ($a == 3) {
    break;
  }
  echo $a . " ";
}
echo "<br>";

// continue
echo "continue example: ";
for ($b = 0; $b < 5; $b++) {
  if ($b == 2) {
    continue;
  }
  echo $b . " ";
}
echo "<br>";

// ========== العمليات على النصوص ==========

// دمج النصوص
$greeting = "Hello" . " " . "World";
echo "Concatenation: $greeting<br>";

// طول النص
$text = "PHP Programming";
echo "Length: " . strlen($text) . "<br>";

// البحث في النص
echo "Position of 'Pro': " . strpos($text, "Pro") . "<br>";

// تحويل الحالة
echo "Uppercase: " . strtoupper($text) . "<br>";
echo "Lowercase: " . strtolower($text) . "<br>";

// استخراج جزء من النص
echo "Substring: " . substr($text, 0, 3) . "<br>";

// ========== العمليات على المصفوفات ==========

// دمج عناصر المصفوفة إلى نص
$colors = ["red", "green", "blue"];
echo "Imploded: " . implode(", ", $colors) . "<br>";

// تقسيم النص إلى مصفوفة
$data = "apple,banana,orange";
$fruits = explode(",", $data);
echo "Exploded: ";
print_r($fruits);
echo "<br>";

// ========== العوامل ==========

// الرياضية
$x = 10;
$y = 3;
echo "Addition: " . ($x + $y) . "<br>";
echo "Modulus: " . ($x % $y) . "<br>";

// المقارنة
echo "Equal: " . ($x == 10) . "<br>";
echo "Identical: " . ($x === 10) . "<br>";

// المنطقية
$condition1 = true;
$condition2 = false;
echo "AND: " . ($condition1 && $condition2) . "<br>";
echo "OR: " . ($condition1 || $condition2) . "<br>";
echo "NOT: " . (!$condition2) . "<br>";

// التعيين
$total = 0;
$total += 10;
$total *= 2;
echo "Total after operations: $total<br>";

// الزيادة والنقصان
$counter = 5;
echo "Pre-increment: " . (++$counter) . "<br>";
echo "Post-increment: " . ($counter++) . "<br>";
echo "After increment: $counter<br>";

// ========== دوال التصحيح ==========

// var_dump
echo "<pre>";
var_dump($array);
echo "</pre>";

// die بعد var_dump
// $debug = true;
// $debug && var_dump($array) && die();

// ========== فصل المنطق عن العرض ==========
$page_title = "PHP Tutorial";
$page_content = "This is a comprehensive PHP tutorial.";

// ملف العرض (view)
?>
<!DOCTYPE html>
<html>

<head>
  <title><?= $page_title ?></title>
</head>

<body>
  <h1><?= $page_title ?></h1>
  <p><?= $page_content ?></p>

  <?php if ($boolean): ?>
    <p>Boolean is true</p>
  <?php endif; ?>

  <ul>
    <?php foreach ($colors as $color): ?>
      <li><?= $color ?></li>
    <?php endforeach; ?>
  </ul>
</body>

</html>
<?php
// array in array
$matrix = [
  [1, 2, 3],
  [4, 5, 6],
  [7, 8, 9]
];
echo "<pre>";
var_dump($matrix);
echo "</pre>";


// ========== نهاية الكود ==========
?>