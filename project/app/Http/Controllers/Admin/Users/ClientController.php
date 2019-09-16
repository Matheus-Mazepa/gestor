<?php

namespace App\Http\Controllers\Admin\Users;

use App\Builders\PaginationBuilder;
use App\Enums\UserRolesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserClientRequest;
use App\Http\Resources\UserClientResource;
use App\Models\Address;
use App\Models\UserInfo;
use App\Notifications\VerifyEmail;
// use App\Repositories\BaseRepository;
use App\Repositories\Criterias\Common\UserNameCriteria;
use App\Repositories\Criterias\User\FilterByUsers;
use App\Repositories\StatesRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Response;

class ClientController extends Controller
{
    private $userInfoRepository;

    public function __construct()
    {
        $this->repository = new UserRepository();
        $this->resource = UserAdminResource::class;

        $this->middleware('permission:users create')->only(['create', 'store']);
        $this->middleware('permission:users update')->only(['edit', 'update']);
        $this->middleware('permission:users delete')->only(['destroy']);
    }

    public function index()
    {
        return view('admin.users.client.index');
    }

    public function create()
    {
        $states = (new StatesRepository())->getStatesToSelect()->toJson();
        $user = collect([]);
        $address = collect([]);

        return view('admin.users.client.create', compact('states', 'user', 'address'));
    }

    public function store(UserClientRequest $request)
    {
        $userData = $request->validated([
            'email',
            'password',
            'clinic_id',
        ]);

        $userInfoData = $request->validated([
            'name',
            'cpf',
            'born_date',
            'gender',
            'crmv',
            'phone',
            'is_vet',
        ]);

        $userAddresData = data_get(
            $request->validated([
                'address.cep',
                'address.district',
                'address.street',
                'address.state_id',
                'address.city_id',
                'address.complement',
                'address.number',
            ]),
            'address'
        );

        \DB::transaction(function () use ($userData, $userInfoData, $userAddresData) {
            $user = $this->repository->createUser($userData);
            $userInfo = $user->userInfo()->create($userInfoData);
            $userInfo->address()->create($userAddresData);

            $user->assignRole(UserRolesEnum::CLIENT);
        });

        $message = _m('user.success.create');
        return $this->chooseReturn('success', $message, 'admin.users.client.index');
    }

    public function edit($id)
    {
        try {
            $user = $this->repository->findOrFail($id);
            $address = collect($user->userInfo->address)
                ->merge(['state_id' => $user->userInfo->address->city->state_id]);

            $states = (new StatesRepository())->getStatesToSelect()->toJson();

            return view('admin.users.client.edit', compact('user', 'states', 'address'));
        } catch (\Exception $e) {
            flash()->error(__('flash.user.error.not_found'));
            return redirect(route('admin.users.vet.index'), Response::HTTP_PERMANENTLY_REDIRECT);
        }
    }

    public function update(UserClientRequest $request, $id)
    {
        $userData = $request->validated([
            'email',
            'password',
            'clinic_id',
        ]);

        $userInfoData = $request->validated([
            'name',
            'cpf',
            'born_date',
            'gender',
            'crmv',
            'phone',
            'is_vet',
        ]);

        $userAddresData = data_get(
            $request->validated([
                'address.cep',
                'address.district',
                'address.street',
                'address.state_id',
                'address.city_id',
                'address.complement',
                'address.number',
            ]),
            'address'
        );

        \DB::transaction(function () use ($userData, $userInfoData, $userAddresData, $id) {
            $user = $this->repository->updateUser($id, $userData);
            $userInfo = $this->userInfoRepository->update($user->userInfo->id, $userInfoData);
            $this->addressRepository->update($userInfo->address->id, $userAddresData);

            $user->notify((new VerifyEmail()));
        });

        $message = _m('user.success.update');
        return $this->chooseReturn('success', $message, 'admin.users.client.index', $id);
    }

    public function show($id)
    {
        try {
            $user = $this->repository->findOrFail($id);

            return view('admin.users.client.show', compact('user'));
        } catch (\Exception $e) {
            flash()->error(__('flash.user.error.not_found'));
            return redirect(route('admin.users.vet.index'), Response::HTTP_PERMANENTLY_REDIRECT);
        }
    }

    public function destroy($id)
    {
        try {
            $this->repository->delete($id);
            return $this->chooseReturn('success', _m('user.success.destroy'), 'admin.users.client.index');
        } catch (\Exception $e) {
            return $this->chooseReturn('error', _m('user.error.destroy'), 'admin.users.client.index');
        }
    }

    public function pagination()
    {
        $pagination = new PaginationBuilder();

        $pagination->repository($this->repository)
            ->criterias([
                new FilterByUsers(UserRolesEnum::CLIENT),
                new UserNameCriteria(),
            ])
            ->resource($this->resource)
            ->defaultOrderBy('user_infos.name');

        return $pagination->build();
    }
}
