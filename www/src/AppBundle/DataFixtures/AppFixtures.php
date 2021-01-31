<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Attribute;
use AppBundle\Entity\AttributeType;
use AppBundle\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $attributes = $this->createAttribute($manager);
        $this->createProducts($manager, $attributes);
    }

    private function createProducts(ObjectManager $manager, $attributes)
    {
        $names = ['Samsung', 'Samsung max','Lg', 'Minolta', 'Dewops', 'Clima', 'Bosh', 'Canon'];

        foreach ($names as $name) {
            $product = new Product();
            $product->setName($name);
            $product->setPrice(100*mt_rand(1, 1000));
            $product->addAttribute($attributes['Color'][rand(0, 4)]);
            $product->addAttribute($attributes['Scuare'][rand(0, 4)]);
            $manager->persist($product);
        }

        $manager->flush();
    }

    private function createAttribute(ObjectManager $manager)
    {
        $attrArray = [];
        $types = [
            'Color' => ['red', 'white', 'black', 'yellow', 'grey'],
            'Scuare' => [20, 30, 40, 100, 500],
        ];

        foreach ($types as $type => $values) {
            $attributeType = new AttributeType();
            $attributeType->setName($type);
            $manager->persist($attributeType);
            $manager->flush();

            foreach ($values as $value) {
                $attribute = new Attribute();
                $attribute->setType($attributeType);
                $attribute->setValue($value);
                $manager->persist($attribute);

                $attrArray[$type][] = $attribute;
            }
        }
        $manager->flush();

        return $attrArray;
    }
}