<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{

    protected $settings_data = [
        [   
            'name' => 'site_title',
            'value' => 'Inventory Management System',
        ],
        [   
            'name' => 'currency_code',
            'value' => 'BDT',
        ],
        [   
            'name' => 'currency_symbol',
            'value' => 'TK',
        ],
        [   
            'name' => 'currency_direction',
            'value' => 'right',
        ],
        [   
            'name' => 'site_logo',
            'value' => '',
        ],
        [   
            'name' => 'site_favicon',
            'value' => '',
        ],


        [   
            'name' => 'mail_mailler',
            'value' => 'smtp',
        ],
        [   
            'name' => 'mail_host',
            'value' => '',
        ],
        [   
            'name' => 'mail_port',
            'value' => '',
        ],
        [   
            'name' => 'mail_username',
            'value' => '',
        ],
        [   
            'name' => 'mail_password',
            'value' => '',
        ],
        [   
            'name' => 'mail_encryption',
            'value' => '',
        ],
        [   
            'name' => 'mail_form_address',
            'value' => '',
        ],
        [   
            'name' => 'mail_form_name',
            'value' => '',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::insert(
            $this->settings_data
        );
    }
}
