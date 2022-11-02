<?php

namespace App\Domain\Repositories;

use App\Domain\Contracts\Contract;

trait RepositoryEloquent
{

    public function getByNotificationId($notificationId)
    {
        return $this->model::where(Contract::NOTIFICATION_ID,$notificationId)->get();
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
