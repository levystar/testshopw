<?php
/**
 * Created by PhpStorm.
 * User: dude
 * Date: 1/28/2018
 * Time: 5:22 PM
 */

namespace App\Entities;


class Staff
{
    protected $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}
