<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\GenericCollection;
use App\Http\Services\UserService;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $service){
        $this->userService= $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return GenericCollection
     */
    public function index(Request $request){

        $currentPage = $request->has('page') ? $request->get('page') :  0 ;

        return new GenericCollection($this->userService->index()->paginated($request->get('png'),$currentPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserStoreRequest $request){

        return response()->json([
            'status'  => 200,
            'success' => true,
            'data' => $this->userService->create($request->all())
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id){

        return response()->json([
            'status'  => 200,
            'success' => true,
            'data' => $this->userService->show($id)
        ],200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id){

        return response()->json([
            'status'  => 200,
            'success' => $this->userService->destroy($id)
        ],200);
    }

    public function updateBalance(Request $request,$id){
        return response()->json([
            'status'  => 200,
            'success' => true,
            'data' => $this->userService->updateUserBalance($id,$request->get('newBalance'))
        ],200);
    }

    public function sumUserTransactionsAndBalance($id){
        return response()->json([
            'status'  => 200,
            'success' => true,
            'data' => $this->userService->sumTransactionsAndBalance($id)

        ],200);
    }
}
