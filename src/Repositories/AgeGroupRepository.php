<?php

namespace VermontDevelopment\CdbSync\Repositories;

use VermontDevelopment\CdbSync\Models\AgeGroup;

class AgeGroupRepository
{
    protected $model;

    protected $default;

    public function __construct(AgeGroup $ageGroup)
    {
        $this->model = $ageGroup;
        $this->default = [

        ];
    }

    public function create($data)
    {
        $this->model->create($data);
    }

    public function insert($data)
    {
        $this->model->insert(array_merge($data, $this->default));
    }

    public function updateOrCreate($findBy, $data)
    {
        $data = array_merge($findBy, $data, $this->default);
        $this->model->updateOrCreate($findBy, $data);
    }

}
