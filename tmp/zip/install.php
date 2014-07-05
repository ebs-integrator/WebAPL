<?php

DB::table('apl_module')->insert(
        array(
            'name' => 'First module',
            'extension' => 'newmodule',
            'enabled' => 1
        )
);