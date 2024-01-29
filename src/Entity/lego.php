<?php 

    namespace App\Entity;

    class Lego {
        private $collection;
        private $id;
        private $name;
        private $description;
        private $price;
        private $pieces;
        private $boxImage;
        private $legoImage;

        public function __construct($collection, $id, $name) {
            $this->collection = $collection;
            $this->id = $id;
            $this->name = $name;
        }

        // Getters
        public function getCollection(): string {
            return $this->collection;
        }

        public function getId(): int {
            return $this->id;
        }

        public function getName(): string {
            return $this->name;
        }

        public function getDescription(): string {
            return $this->description;
        }

        public function getPrice(): float {
            return $this->price;
        }

        public function getPieces(): int {
            return $this->pieces;
        }

        public function getBoxImage(): string {
            return $this->boxImage;
        }

        public function getLegoImage(): string {
            return $this->legoImage;
        }

        // Setters

        public function setCollection(string $collection) {
            $this->collection = $collection;
        }

        public function setId(int $id) {
            $this->id = $id;
        }

        public function setName(string $name) {
            $this->name = $name;
        }

        public function setDescription(string $description) {
            $this->description = $description;
        }

        public function setPrice(float $price) {
            $this->price = $price;
        }

        public function setPieces(int $pieces) {
            $this->pieces = $pieces;
        }

        public function setBoxImage(string $boxImage) {
            $this->boxImage = $boxImage;
        }

        public function setLegoImage(string $legoImage) {
            $this->legoImage = $legoImage;
        }
    }

