<?php
namespace App\Repositories;

use App\Models\PaymentForm;

class PaymentFormRepository extends Repository
{
    protected function getClass()
    {
        return PaymentForm::class;
    }

    public function toVSelect()
    {
        $paymentForms = $this->all(['id', 'name']);

        $paymentForms = $paymentForms->map(function ($paymentForm) {
            return ['label' => $paymentForm->name, 'id' => $paymentForm->id];
        });

        $paymentForms = $paymentForms->sortBy('label')->values();

        return $paymentForms;
    }

}
