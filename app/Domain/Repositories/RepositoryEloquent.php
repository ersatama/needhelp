<?php

namespace App\Domain\Repositories;

use App\Domain\Contracts\Contract;
use Illuminate\Database\Eloquent\Collection;

trait RepositoryEloquent
{
    public function update($id, $data)
    {
        $this->model::where(Contract::ID, $id)->update($data);
        return $this->firstById($id);
    }

    public function create($data)
    {
        return $this->model::create($data);
    }

    public function all()
    {
        return $this->model::get();
    }

    public function search($searchColumns,$data): Collection|array
    {
        $query  =   $this->model::query();
        foreach($searchColumns as &$column) {
            $query->orWhere($column, Contract::LIKE, $data . '%');
        }
        return $query->get();
    }

    public function count($where)
    {
        return $this->model::where($where)
            ->count();
    }

    public function getByNotificationId($notificationId)
    {
        return $this->model::where(Contract::NOTIFICATION_ID,$notificationId)->get();
    }

    public function updateByPhone($phone, $data)
    {
        $this->model::where(Contract::PHONE, $phone)->update($data);
        return $this->firstByPhone($phone);
    }

    public function firstByPhone($phone)
    {
        return $this->model::where(Contract::PHONE,$phone)->first();
    }

    public function firstById($id)
    {
        return $this->model::where(Contract::ID,$id)->first();
    }

    public function getByUserId($userId)
    {
        return $this->model::where(Contract::USER_ID,$userId)->get();
    }

    public function get()
    {
        return $this->model::get();
    }

    public function getByCountryId($countryId)
    {
        return $this->model::where(Contract::COUNTRY_ID,$countryId)->get();
    }

    public function getByRegionId($regionId)
    {
        return $this->model::where(Contract::REGION_ID,$regionId)->get();
    }
}
