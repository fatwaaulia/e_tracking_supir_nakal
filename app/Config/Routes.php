<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->set404Override(
    function() {
        $data['title'] = '404';
        $data['content'] = view('errors/page_404');

        $uri_1 = service('uri')->getSegment(1);
        $role = model('Role')->findColumn('slug');
        if (session()->isLogin === true && in_array($uri_1, $role)) {
            $data['sidebar'] = view('dashboard/sidebar');
            return view('dashboard/header', $data);
        } else {
            $data['navbar'] = view('landingpage/navbar');
            $data['footer'] = view('landingpage/footer');
            return view('landingpage/header', $data);
        }
    }
);

/*--------------------------------------------------------------
  # Landing Page
--------------------------------------------------------------*/
$routes->get('/', 'Landingpage::beranda');
$routes->get('kebijakan-privasi', 'Landingpage::kebijakanPrivasi');
$routes->get('syarat-ketentuan', 'Landingpage::syaratKetentuan');

/*--------------------------------------------------------------
  # Autentikasi
--------------------------------------------------------------*/
// login
$routes->get('login', 'Auth::login');
$routes->post('login-process', 'Auth::loginProcess');
$routes->get('logout', 'Auth::logout');
// register
$routes->get('register', 'Auth::register');
$routes->post('register-process', 'Auth::registerProcess');
$routes->get('aktivasi-akun', 'Auth::aktivasiAkun');
// email layout
$routes->get('email-layout', 'AppSettings::emailLayout');

/*--------------------------------------------------------------
  # API
--------------------------------------------------------------*/
$routes->post('webhook/xendit', 'Webhook::xendit');

/*--------------------------------------------------------------
  # Dashboard & Profil
--------------------------------------------------------------*/
$user_session = model('Users')->where('id', session()->get('id_user'))->first();
if ($user_session) {
    $user_role = model('Role')->where('id', $user_session['id_role'])->first()['slug'];
    $routes->get($user_role . '/dashboard', 'Dashboard::dashboard', ['filter' => 'EnsureIsLogin']);
    $routes->group($user_role . '/profile', ['filter' => 'EnsureIsLogin'], static function ($routes) {
        $routes->get('/', 'Users::profile');
        $routes->post('update', 'Users::updateProfile');
        $routes->post('update/password', 'Users::updatePassword');
        $routes->post('delete/image', 'Users::deleteProfilePhoto');
    });
}

/*--------------------------------------------------------------
  # Superadmin
--------------------------------------------------------------*/
$routes->group('superadmin/app-settings', ['filter' => 'EnsureSuperAdmin'], static function ($routes) {
    $routes->get('/', 'AppSettings::index');
    $routes->get('menu', 'AppSettings::menu');
    $routes->post('update/(:segment)', 'AppSettings::update/$1');
    $routes->post('send-email', 'AppSettings::sendEmail');
});
$routes->group('superadmin/users', ['filter' => 'EnsureSuperAdmin'], static function ($routes) {
    $routes->get('get-data', 'Users::getData');
    $routes->get('/', 'Users::index');
    $routes->get('new', 'Users::new');
    $routes->post('create', 'Users::create');
    $routes->get('edit/(:segment)', 'Users::edit/$1');
    $routes->post('update/(:segment)', 'Users::update/$1');
    $routes->post('delete/(:segment)', 'Users::delete/$1');
    $routes->post('delete/image/(:segment)', 'Users::deleteImg/$1');
});
$routes->group('superadmin/pengajuan-perusahaan', ['filter' => 'EnsureSuperAdmin'], static function ($routes) {
    $routes->get('get-data', 'PengajuanPerusahaan::getData');
    $routes->get('/', 'PengajuanPerusahaan::index');
    $routes->get('edit/(:segment)', 'PengajuanPerusahaan::edit/$1');
    $routes->post('update/(:segment)', 'PengajuanPerusahaan::update/$1');
    $routes->post('delete/(:segment)', 'PengajuanPerusahaan::delete/$1');
});
$routes->group('superadmin/perusahaan', ['filter' => 'EnsureSuperAdmin'], static function ($routes) {
    $routes->get('get-data', 'PengajuanPerusahaan::getDataPerusahaanAktif');
    $routes->get('/', 'PengajuanPerusahaan::perusahaanAktif');
    $routes->get('detail/(:segment)', 'PengajuanPerusahaan::detailPerusahaanAktif/$1');
});
$routes->group('superadmin/lapor-temuan', ['filter' => 'EnsureSuperAdmin'], static function ($routes) {
    $routes->get('get-data', 'Temuan::getData');
    $routes->get('/', 'Temuan::index');
    $routes->get('edit/(:segment)', 'Temuan::edit/$1');
    $routes->post('update/(:segment)', 'Temuan::update/$1');
    $routes->post('delete/(:segment)', 'Temuan::delete/$1');
});
$routes->group('superadmin/riwayat-pencarian', ['filter' => 'EnsureSuperAdmin'], static function ($routes) {
    $routes->get('get-data', 'RiwayatPencarian::getData');
    $routes->get('/', 'RiwayatPencarian::index');
});
$routes->group('superadmin/paket-langganan', ['filter' => 'EnsureSuperAdmin'], static function ($routes) {
    $routes->get('get-data', 'PaketLangganan::getData');
    $routes->get('/', 'PaketLangganan::index');
    $routes->get('new', 'PaketLangganan::new');
    $routes->post('create', 'PaketLangganan::create');
    $routes->get('edit/(:segment)', 'PaketLangganan::edit/$1');
    $routes->post('update/(:segment)', 'PaketLangganan::update/$1');
    $routes->post('delete/(:segment)', 'PaketLangganan::delete/$1');
});

/*--------------------------------------------------------------
  # Admin
--------------------------------------------------------------*/
$routes->group('admin/pengajuan-perusahaan', ['filter' => 'EnsureAdmin'], static function ($routes) {
    $routes->get('get-data', 'PengajuanPerusahaan::getData');
    $routes->get('/', 'PengajuanPerusahaan::index');
    $routes->get('edit/(:segment)', 'PengajuanPerusahaan::edit/$1');
    $routes->post('update/(:segment)', 'PengajuanPerusahaan::update/$1');
    $routes->post('delete/(:segment)', 'PengajuanPerusahaan::delete/$1');
});
$routes->group('admin/perusahaan', ['filter' => 'EnsureAdmin'], static function ($routes) {
    $routes->get('get-data', 'PengajuanPerusahaan::getDataPerusahaanAktif');
    $routes->get('/', 'PengajuanPerusahaan::perusahaanAktif');
    $routes->get('detail/(:segment)', 'PengajuanPerusahaan::detailPerusahaanAktif/$1');
});
$routes->group('admin/lapor-temuan', ['filter' => 'EnsureAdmin'], static function ($routes) {
    $routes->get('get-data', 'Temuan::getData');
    $routes->get('/', 'Temuan::index');
    $routes->get('edit/(:segment)', 'Temuan::edit/$1');
    $routes->post('update/(:segment)', 'Temuan::update/$1');
    $routes->post('delete/(:segment)', 'Temuan::delete/$1');
});
$routes->group('admin/riwayat-pencarian', ['filter' => 'EnsureAdmin'], static function ($routes) {
    $routes->get('get-data', 'RiwayatPencarian::getData');
    $routes->get('/', 'RiwayatPencarian::index');
});
$routes->group('admin/paket-langganan', ['filter' => 'EnsureAdmin'], static function ($routes) {
    $routes->get('get-data', 'PaketLangganan::getData');
    $routes->get('/', 'PaketLangganan::index');
    $routes->get('new', 'PaketLangganan::new');
    $routes->post('create', 'PaketLangganan::create');
    $routes->get('edit/(:segment)', 'PaketLangganan::edit/$1');
    $routes->post('update/(:segment)', 'PaketLangganan::update/$1');
    $routes->post('delete/(:segment)', 'PaketLangganan::delete/$1');
});

/*--------------------------------------------------------------
  # Perusahaan
--------------------------------------------------------------*/
$routes->group('perusahaan/pengajuan-perusahaan', ['filter' => 'EnsurePerusahaan'], static function ($routes) {
    $routes->get('/', 'PengajuanPerusahaan::kirimPengajuan');
    $routes->post('update', 'PengajuanPerusahaan::prosesKirimPengajuan');
});
$routes->group('perusahaan/lapor-temuan', ['filter' => ['EnsurePerusahaan', 'EnsurePoinPerusahaan']], static function ($routes) {
    $routes->get('get-data', 'Temuan::getData');
    $routes->get('/', 'Temuan::index');
    $routes->get('new', 'Temuan::new');
    $routes->post('create', 'Temuan::create');
    $routes->get('edit/(:segment)', 'Temuan::edit/$1');
    $routes->post('update/(:segment)', 'Temuan::update/$1');
    $routes->post('delete/(:segment)', 'Temuan::delete/$1');
});
$routes->group('perusahaan/cari-temuan', ['filter' => ['EnsurePerusahaan', 'EnsurePoinPerusahaan']], static function ($routes) {
    $routes->get('/', 'Temuan::cariTemuan');
    $routes->get('unduh-pdf', 'Temuan::unduhPdf');
});
$routes->group('perusahaan/riwayat-pencarian', ['filter' => 'EnsurePerusahaan'], static function ($routes) {
    $routes->get('get-data', 'RiwayatPencarian::getData');
    $routes->get('/', 'RiwayatPencarian::index');
});
$routes->group('perusahaan/berlangganan', ['filter' => 'EnsurePerusahaan'], static function ($routes) {
    $routes->get('get-data', 'Berlangganan::getData');
    $routes->get('/', 'Berlangganan::index');
});
$routes->group('perusahaan/transaksi-langganan', ['filter' => 'EnsurePerusahaan'], static function ($routes) {
    $routes->get('get-data', 'TransaksiLangganan::getData');
    $routes->get('/', 'TransaksiLangganan::index');
    $routes->post('create', 'TransaksiLangganan::create');
    $routes->get('detail', 'TransaksiLangganan::detail');
});