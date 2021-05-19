<?php


namespace App\Repositories;


use App\Exceptions\GenericModelNotFoundException;
use Carbon\Carbon;
use Carbon\Traits\Creator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;

abstract class AbstractRepository
{

    public $model;

    public function __construct($model){
        $this->model = $model;
    }

    /**
     * Search a model by its id
     * @param $id
     * @return Model
     *
     * @throws \Exception
     */
    public function getById($id){
        try{
            return $this->model->findOrFail($id);

        }catch(\Exception $e){

            $className = class_basename($this->model);

            throw new GenericModelNotFoundException($id,$className);
        }

    }

    /**
     * creates a model
     *
     * @param $data
     * @return Model
     */
    public function create($data)
    {
        $newModel = $this->model->create($data);

        return $newModel;
    }

    public function update($data,$id){
        try {
            $model = $this->model->findOrFail($id);
        }catch(\Exception $e){
            throw new GenericModelNotFoundException($id,class_basename($this->model));

        }

        $model->update($data);

        return $this->model->find($id);

    }

    public function destroy($id) {

        $this->getById($id)->delete();

        return true;
    }


    /**
     * Seleciona os campos de acordo com os campos passados como parametro
     *
     * @$fields espera uma string com o valor dos campos a serem
     * recuperados separados por virgula(`,`)
     */
    public function selectFilter($fields){
        $this->model = $this->model->selectRaw($fields);
    }
    /**
     * Seleciona os campos de acordo com as expressoes passadas como parametro
     *
     * @$conditions espera uma string com as condicoes da busca na DB,
     * cada exprecao logica deve estar no formato ex: price:>:2 com os elementos
     * dentro das exprecoes separados por `:` e cada expressao separada por `;`
     * ex: price:>:2;nome:=:matheus
     */
    public function selectConditions($conditions){

        $expressions = explode(";",$conditions);

        foreach($expressions as $e){

            $temp = explode(':',$e);

            if($temp[0] == 'password') continue;

            $this->model = $this->model->where($temp[0],$temp[1],$temp[2]);
        }
    }
    /**
     * Retorna os models correspondentes de acordo com a data minima passada no created_at
     * formato da data: 2021-04-01
     */
    public function fromDate($date){
        $d = new Carbon($date);
        $this->model = $this->model->whereDate('created_at','>=',$d->utc());
    }
    /**
     * Retorna os models correspondentes de acordo com a data maxima passada no created_at
     * formato da data: 2021-05-01
     */
    public function tillDate($date){

        $d = new Carbon($date);

        $this->model = $this->model->whereDate('created_at','<=',$d->utc());
    }


    public function getResult(){

        return $this->model;
    }

    public function paginated($png = 10){

        return $this->model->paginate($png);
    }

}
