<?php
/**
 * Clint Scott
 * CSD440 Server-Side Scripting
 * Module 6 Programming Assignment
 * 2/8/2026
 *
 * This program:
 * - Defines a class named ClintMyInteger that stores a single integer
 * - Provides methods to check even, odd, and prime values
 * - Includes getter and setter methods
 * - Creates two instances and tests all class methods
 */

class ClintMyInteger {
    private int $value;

    /**
     * Constructor
     *
     * @param int $value Initial integer value
     */
    public function __construct(int $value) {
        $this->value = $value;
    }

    /**
     * Getter for the stored value
     *
     * @return int
     */
    public function getValue(): int {
        return $this->value;
    }

    /**
     * Setter for the stored value
     *
     * @param int $value
     */
    public function setValue(int $value): void {
        $this->value = $value;
    }

    /**
     * Determines if a given integer is even
     *
     * @param int $int
     * @return bool
     */
    public function isEven(int $int): bool {
        return $int % 2 === 0;
    }

    /**
     * Determines if a given integer is odd
     *
     * @param int $int
     * @return bool
     */
    public function isOdd(int $int): bool {
        return $int % 2 !== 0;
    }

    /**
     * Determines if the stored value is prime
     *
     * @return bool
     */
    public function isPrime(): bool {
        if ($this->value <= 1) {
            return false;
        }

        for ($i = 2; $i <= sqrt($this->value); $i++) {
            if ($this->value % $i === 0) {
                return false;
            }
        }

        return true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Clint Scott | Module 6 Assignment</title>
    <style>
        body {
            font-family: sans-serif;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f4f4f9;
        }
        h1 {
            border-bottom: 3px solid #3498db;
            padding-bottom: 10px;
        }
        .test-case {
            background: #fff;
            padding: 15px;
            margin-bottom: 20px;
            border-left: 5px solid #3498db;
        }
        hr {
            border: 0;
            height: 1px;
            background: #ddd;
            margin: 15px 0;
        }
    </style>
</head>
<body>

<h1>MyInteger Class Testing</h1>

<?php
// ---------------------------------
// Instance 1: Odd and Prime Number
// ---------------------------------
$int1 = new ClintMyInteger(17);
echo "<div class='test-case'>";
echo "<h2>Instance 1 (Value: {$int1->getValue()})</h2>";
echo "Is Even? " . ($int1->isEven($int1->getValue()) ? "Yes" : "No") . "<br>";
echo "Is Odd? " . ($int1->isOdd($int1->getValue()) ? "Yes" : "No") . "<br>";
echo "Is Prime? " . ($int1->isPrime() ? "Yes" : "No") . "<br>";
echo "</div>";

// ---------------------------------
// Instance 2: Even and Not Prime
// ---------------------------------
$int2 = new ClintMyInteger(4);
echo "<div class='test-case'>";
echo "<h2>Instance 2 (Value: {$int2->getValue()})</h2>";
echo "Is Even? " . ($int2->isEven($int2->getValue()) ? "Yes" : "No") . "<br>";
echo "Is Odd? " . ($int2->isOdd($int2->getValue()) ? "Yes" : "No") . "<br>";
echo "Is Prime? " . ($int2->isPrime() ? "Yes" : "No") . "<br>";

echo "<hr>";
echo "Updating value to 13...<br>";
$int2->setValue(13);
echo "New Value: {$int2->getValue()}<br>";
echo "Is Prime? " . ($int2->isPrime() ? "Yes" : "No") . "<br>";
echo "</div>";
?>

</body>
</html>