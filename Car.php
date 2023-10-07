<?php
class Car
{
    public $brand;
    public $model;

    public function __construct($brand, $model)
    {
        $this->brand = $brand;
        $this->model = $model;
    }

    public function startEngine()
    {
        return "Engine Started!";
    }
}

class SportsCar extends Car
{
    public function turboMode()
    {
        return "Turbo mode activated!";
    }
}

// $carHonda = new Car("Honda", "CRV");
// echo $carHonda->startEngine();

$sportCar = new SportsCar("Honda", "CRV");
echo $sportCar->turboMode();
echo "<br>";
echo $sportCar->startEngine();
