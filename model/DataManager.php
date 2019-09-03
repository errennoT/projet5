<?php

namespace Projet5\Model;

class DataManager
{
    protected function hydrate(array $data)
    {
            foreach ($data as $key => $value) {

                $method = 'set' . ucfirst($key);

                if (method_exists($this, $method)) {
                    $this->$method($value);
                }
            }
    }
}
