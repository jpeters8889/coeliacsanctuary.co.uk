<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers;

use Coeliac\Modules\Member\Models\User;
use Illuminate\Contracts\Auth\Access\Gate;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Member\Models\UserAddress;
use Illuminate\Contracts\Auth\Authenticatable;
use Coeliac\Modules\Member\Requests\UpdateAddressRequest;
use Illuminate\Database\Eloquent\Collection;

class AddressController extends BaseController
{
    public function list(Authenticatable $user): Collection
    {
        /** @var User $user */
        return $user->addresses->sortByDesc('updated_at')->values();
    }

    public function update(UpdateAddressRequest $request, Gate $gate, UserAddress $address): void
    {
        $gate->authorize('modify-address', $address);

        $address->update($request->validated());
    }

    public function delete(Gate $gate, UserAddress $address): void
    {
        $gate->authorize('modify-address', $address);

        $address->delete();
    }
}
