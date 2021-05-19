<?php


namespace App\Http\Services;


use App\Exceptions\CannotDeleteUserWithBalanceException;
use App\Exceptions\CannotDeleteUserWithTransactionsException;
use App\Exceptions\CannotRegisterUnderAgeUserException;
use App\Http\Resources\GenericCollection;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserService
{

    private  $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(){

        return $this->userRepository;

    }

    public function show($id){

        return $this->userRepository->getById($id);

    }

    public function destroy($id){

        if(app(TransactionRepository::class)->userHasTransactions($id))
            throw new CannotDeleteUserWithTransactionsException();

        if($this->userRepository->getById($id)->balance > 0)
            throw new CannotDeleteUserWithBalanceException();


        return $this->userRepository->destroy($id);

    }

    public function create(array $data){

        $eighteenYearAgo = Carbon::now()->subYears(18);
        $newUserBirthDay = new Carbon($data['birthday']);

        $canRegister = $newUserBirthDay->lte($eighteenYearAgo);

        if(!$canRegister)
            throw new CannotRegisterUnderAgeUserException();

        return $this->userRepository->create($data);
    }

    public function updateUserBalance($id, $newBalance){
        return $this->userRepository->update(['balance' => $newBalance],$id);
    }

    public function sumTransactionsAndBalance($id){
         $totalTransacted = app(TransactionService::class)->sumUserTransactions($id) + $this->userRepository->getById($id)->balance;

         return $totalTransacted;
    }

    public function getUserBalance($id){

        $inicialBalance = $this->show($id)->balance;

        $totalCredit = Transaction::where('user_id',$id)
            ->where('transaction_type','credit')
            ->sum('amount')/100;

        $totalDebit = Transaction::where('user_id',$id)
            ->where('transaction_type','debit')
            ->sum('amount')/100;

        $totalReversal = Transaction::where('user_id',$id)
            ->where('transaction_type','reversal')
            ->sum('amount')/100;

        $total = $inicialBalance + $totalCredit + $totalDebit + $totalReversal;

        return $total;

    }


}
