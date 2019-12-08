<?php

namespace App\Http\Controllers;

use App\Builders\PaginationBuilder;
use App\Models\User;
use App\Repositories\Criterias\Common\Where;

class UserController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('users.index');
    }


    public function pagination()
    {
        $pagination = new PaginationBuilder();

//        $pagination->repository($this->repository)
//            ->defaultOrderBy('name')
//            ->criterias([
//                new Where('name', 'ilike','josa'),
//            ])
//            ->resource($this->resource);

        $users = [
          new User([
              'name' => 'José da silva',
              'email' => 'jose@silva.com',
              'created_at' => now(),
              'updated_at' => now(),
          ]),

            new User([
                'name' => 'Tiago Francisco',
                'email' => 'ti@ago.com',
                'created_at' => now(),
                'updated_at' => now(),
            ])
        ];
        $pagination->collection(collect($users))
            ->defaultOrderBy('name');
        return $pagination->build();
    }

    /**
     * Configura a paginação.
     *
     * @param PaginationBuilder $pagination
     * @return void
     */
    protected function getPagination($pagination)
    {
        // TODO: Implement getPagination() method.
    }
}
