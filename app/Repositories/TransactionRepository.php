<?php


namespace App\Repositories;


use App\Models\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class TransactionRepository extends AbstractRepository
{
    public function __construct($model = null)
    {
        if($model == null) $model = app(Transaction::class);
        parent::__construct($model);
    }

    public function create($data)
    {
        if(!isset($data['user_id'])) $data['user_id'] = app(UserRepository::class)->getByEmail($data['user_email'])->id;

        Cache::tags('transaction')->flush();

        return parent::create($data);
    }

    public function fromMonthAndYear($date){
        $date = explode('-',$date);

        $this->model =  $this->model->whereMonth('created_at',$date[1])->whereYear('created_at','20'.$date[0]);

    }

    public function getResult()
    {

        $this->model = $this->model->with('user');

        return parent::getResult();


    }

    public function paginated($png = 10, $page = 0)
    {
        $key = 'transactions_'.$page.'_'.$png;
        $expiration = 60 * 24;


        return Cache::tags(['transaction'])->remember($key,$expiration,function () use ($png){

            $this->model = $this->model->with('user');
            $this->model = $this->model->orderByDesc('created_at');
            return parent::paginated($png);
        });

    }

    public function destroy($id)
    {
        Cache::tags('transaction')->flush();

        return parent::destroy($id);
    }

    public function userHasTransactions($id){
       return $this->model->where('user_id',$id)->exists();
    }




}
