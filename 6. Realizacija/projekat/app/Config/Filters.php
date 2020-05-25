<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
	// Makes reading things below nicer,
	// and simpler to change out script that's used.
	public $aliases = [
		'csrf'     => \CodeIgniter\Filters\CSRF::class,
		'toolbar'  => \CodeIgniter\Filters\DebugToolbar::class,
		'honeypot' => \CodeIgniter\Filters\Honeypot::class,
                'gost'     => \App\Filters\GostFilter::class,
                'citalac'  => \App\Filters\CitalacFilter::class,
                'pisac'    => \App\Filters\PisacFilter::class,
                'recenzent'=> \App\Filters\RecenzentFilter::class,
                'admin'    => \App\Filters\AdminFilter::class
	];

	// Always applied before every request
	public $globals = [
		'before' => [
			//'honeypot'
			// 'csrf',
		],
		'after'  => [
			'toolbar',
			//'honeypot'
		],
	];

	// Works on all of a particular HTTP method
	// (GET, POST, etc) as BEFORE filters only
	//     like: 'post' => ['CSRF', 'throttle'],
	public $methods = [];

	// List filter aliases and any before/after uri patterns
	// that they should run on, like:
	//    'isLoggedIn' => ['before' => ['account/*', 'profiles/*']],
	public $filters = [
            'gost'     => ['before' => ['Gost/*', '/', 'Gost']],
            'citalac'  => ['before' => ['Citalac/*', 'Citalac']],
            'pisac'    => ['before' => ['Pisac/*', 'Pisac']],
            'recenzent'=> ['before' => ['Recenzent/*', 'Recenzent']],
            'admin'    => ['before' => ['Admin/*', 'Admin']]
        ];
}
