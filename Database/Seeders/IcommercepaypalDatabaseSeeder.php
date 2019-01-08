<?php

namespace Modules\Icommercepaypal\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Icommerce\Entities\PaymentMethod;

class IcommercepaypalDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $options['mainimage'] = "";
        $options['clientid'] = "";
        $options['clientsecret'] = "";
        $options['mode'] = "sandbox"; //live
        $options['endpoint'] = "https://api.sandbox.paypal.com"; // https://api.paypal.com

        $params = array(
            'title' => trans('icommercepaypal::icommercepaypals.single'),
            'description' => trans('icommercepaypal::icommercepaypals.description'),
            'name' => config('asgard.icommercepaypal.config.paymentName'),
            'status' => 0,
            'options' => json_encode($options)
        );

        PaymentMethod::create($params);

    }
}
