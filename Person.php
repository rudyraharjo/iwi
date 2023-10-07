<?php
class Person
{
    public $name;
    public $age;

    public function __construct($name, $age)
    {
        $this->name = $name;
        $this->age = $age;
    }

    public function introduce()
    {
        return "Hello, my name is " . $this->name . " and I am " . $this->age . " years old.";
    }
}

$person1 = new Person("Rudy Raharjo", 31);
echo $person1->introduce();
