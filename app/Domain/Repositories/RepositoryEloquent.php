<?php

namespace App\Domain\Repositories;

use App\Domain\Contracts\Contract;
use App\Domain\Scopes\IsPaid;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

trait RepositoryEloquent
{
    public function getByRole($role)
    {
        return $this->model::where(Contract::ROLE, $role)->get();
    }

    public function firstByQuestionId($questionId)
    {
        return $this->model::where(Contract::QUESTION_ID, $questionId)->withoutGlobalScope(IsPaid::class)->first();
    }

    public function firstByKey($key)
    {
        return $this->model::where(Contract::KEY, $key)->first();
    }

    public function forceDeleteById($id): void
    {
        $this->model::where(Contract::ID,$id)
            ->forceDelete();
    }

    public function firstByIp($ip)
    {
        return $this->model::where([
            [Contract::IP,$ip],
            [Contract::STATUS,true]
        ])->first();
    }

    public function firstByEmail($email)
    {
        return $this->model::where(Contract::EMAIL,$email)->first();
    }

    public function update($id, $data)
    {
        DB::table($this->model->getTable())->where(Contract::ID, $id)->update($data);
        //$this->model::where(Contract::ID, $id)->withoutGlobalScope(IsPaid::class)->update($data);
        return $this->firstById($id);
    }

    public function insert($data)
    {
        DB::table($this->model->getTable())->insert($data);
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
        $this->model::where(Contract::PHONE, $phone)->first()->update($data);
        return $this->firstByPhone($phone);
    }

    public function firstByPhone($phone)
    {
        return $this->model::where(Contract::PHONE,$phone)->first();
    }

    public function firstByOperationId($operationId)
    {
        return $this->model::where(Contract::OPERATION_ID, $operationId)->first();
    }

    public function firstById($id)
    {
        return $this->model::where(Contract::ID,$id)->withoutGlobalScope(IsPaid::class)->first();
    }

    public function getByUserId($userId)
    {
        return $this->model::where(Contract::USER_ID, $userId)->get();
    }

    public function get()
    {
        return $this->model::get();
    }

    public function firstWhere($where)
    {
        return $this->model::where($where)->first();
    }

    public function getWhereWith($where,$with)
    {
        return $this->model::with($with)->where($where)->get();
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
