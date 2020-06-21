<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\Repositories\RepositoryException;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\Company;
use App\Repositories\Criterias\Common\Where;

use App\Builders\PaginationBuilder;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

class UserCompanyController extends Controller
{
    /**
     * Show the application dashboard.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:users_company view')->only(['index', 'show']);
        $this->middleware('permission:users_company create')->only(['create', 'store']);
        $this->middleware('permission:users_company update')->only(['edit', 'update']);
        $this->middleware('permission:users_company delete')->only('destroy');
    }

    public function index(Company $company)
    {
        return view('admin.company_users.index', compact('company'));
    }

    public function create(Company $company)
    {
        return view('admin.company_users.create', compact('company'));
    }

    public function store($companyId, UserRequest $request)
    {
        $data = $request->validated();
        $data['company_id'] = $companyId;
        $userRepository = new UserRepository();
        $userRepository->createUser($data);
        return $this->chooseReturn('success', 'Usuario criado com sucesso', 'admin.users.index', $companyId);
    }

    public function edit(Company $company)
    {
        return view('admin.company_users.edit', compact('company'));
    }

    public function update($companyId, $userId, UserRequest $request)
    {
        $data = $request->validated();
        $data['company_id'] = $companyId;
        $userRepository = new UserRepository();
        $userRepository->updateUser($userId, $data);
        return $this->chooseReturn('success', 'Usuario criado com sucesso', 'admin.users.index', $companyId);
    }

    /**
     * Configura a paginação.
     *
     * @param PaginationBuilder $pagination
     * @return void
     * @throws RepositoryException
     */
    protected function getPagination($pagination)
    {
        $pagination->repository(new UserRepository())
            ->defaultOrderBy('name')
            ->criterias([
                new Where('is_admin', false),
                new Where('company_id', request('company'))
            ])
            ->resource(UserResource::class);

    }
}
