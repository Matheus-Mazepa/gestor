<?php

namespace App\Http\Controllers\Admin;

use App\Action\Admin\CreateUserAdminAction;
use App\Http\Requests\Admin\UserAdminRequest;
use App\Http\Resources\Admin\CompanyResource;
use App\Models\Company;
use App\Repositories\CompanyRepository;
use App\Repositories\Criterias\Common\Where;
use Illuminate\Http\Request;

use App\Builders\PaginationBuilder;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UserResource;
use App\Repositories\UserRepository;

class CompanyController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:companies view')->only(['index', 'show']);
        $this->middleware('permission:companies create')->only(['create', 'store']);
        $this->middleware('permission:companies update')->only(['edit', 'update']);
        $this->middleware('permission:companies delete')->only('destroy');
    }

    public function index()
    {
        return view('admin.companies.index');
    }

    public function create()
    {
        $company = new Company([
            'name' => 'teste',
            'cpf_cnpj'  => 'teste',
            'corporate_name' => 'teste',
            'phone' => 'teste',
            'ie_municipal' => 'teste',
            'ie_estadual' => 'teste',
            'is_legal_person'  => true,
        ]);
        return view('admin.companies.create');
    }

    public function store(CreateUserAdminAction $createUserAdminAction, UserAdminRequest $request)
    {
        $data = $request->validated();
        $createUserAdminAction->execute($data);
        return $this->chooseReturn('success', 'Empresa criado com sucesso', 'admin.companies.index');
    }

    /**
     * Configura a paginação.
     *
     * @param PaginationBuilder $pagination
     * @return void
     * @throws \App\Exceptions\Repositories\RepositoryException
     */
    protected function getPagination($pagination)
    {
        $pagination->repository(new CompanyRepository())
            ->defaultOrderBy('name')
            ->resource(CompanyResource::class);

    }
}
