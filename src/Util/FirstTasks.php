<?php
/**
 * Created by PhpStorm.
 * User: alameddincelik
 * Date: 19.05.2020
 * Time: 22:50
 */

namespace App\Util;


class FirstTasks extends ExternalTask implements TaskInterface
{
    public function __construct()
    {
        $this->url = 'http://www.mocky.io/v2/5d47f24c330000623fa3ebfa';
        $this->mappingArray = [
            'id' => 'title',
            'sure' => 'duration',
            'zorluk' => 'level',
        ];
        parent::__construct($this->url);
    }

    protected function fetchTasks()
    {
        return parent::fetchTasks();
    }

    protected function filterTasks()
    {
        parent::filterTasks();
        $responseArray = [];
        foreach ($this->response as $key => $value) {
            $tempArray['id'] = $key;
            foreach ($value as $subKey => $subValue) {
                $tempArray[$this->mappingArray[$subKey]] = $subValue;
            }
            array_push($responseArray, $tempArray);
        }
        $this->response = $responseArray;
        return $this;
    }

    public function getResponse()
    {
        return parent::getResponse();
    }
}