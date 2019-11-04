<?php

namespace App\Libs;

class Validator
{
    private $filters = [
        'text'    => '/^[a-zA-Z]+$/',
        'num'     => '/^[\d]+$/',
        'textnum' => '/^[\w]+$/',
        'email'   => '/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/',
        'url'     => '/^http(s)?:\/\/([\w]{1,20}\.)?[a-z0-9-]{2,65}(\.[a-z]{2,10}){1,2}(\/)?$/',
        'tel'     => '/^[\d]+$/'
    ];

    private $error_msg = [];
    private $name;

    public function val($data = "", $name = '', $required = false, $type = "text", $min = null, $max = null)
    {
        $this->name = $name;

        if ($required && empty($data)) {
            $this->setError(0);
            return false;
        }

        if ($min !== null && strlen($data) < $min) {
            $this->setError(1, $min);
            return false;
        }

        if ($max !== null && strlen($data) > $max) {
            $this->setError(2, $max);
            return false;
        }

        if (array_key_exists($type, $this->filters)) {
            if (! preg_match($this->filters[$type], $data)) {
                $this->setError(3);
                return false;
            }
        }
    }

    public function check($data1, $data2)
    {
        if (is_array($data1) && is_array($data2)) {
            if ($data1[0] !== $data2[0]) {
                $this->setError(4, [$data1[1], $data2[1]]);
                return false;
            }
        }
    }

    public function setError($error, $opt = null)
    {
        switch ($error) {
            case 0:
                array_push($this->error_msg, "{$this->name} ist ein Pflichtfeld!");
                break;
            case 1:
                array_push($this->error_msg, "{$this->name} hat zu wenig Zeichen! Mindestens $opt!");
                break;
            case 2:
                array_push($this->error_msg, "{$this->name} hat zu viele Zeichen! Maximal $opt!");
                break;
            case 3:
                array_push($this->error_msg, "{$this->name} ist falsch!");
                break;
            case 4:
                array_push($this->error_msg, "{$opt[0]} und {$opt[1]} sind nicht gleich!");
                break;
            case 5:
                array_push($this->error_msg, "Username ist bereits vergeben.");
                break;
            case 6:
                array_push($this->error_msg, "E-Mailadresse ist bereits vergeben.");
                break;
            default:
                array_push($this->error_msg, "{$this->name} ist nicht valide!");
        }

    }

    public function getErrors()
    {
        return (count($this->error_msg) > 0) ? $this->error_msg : false;
    }
}