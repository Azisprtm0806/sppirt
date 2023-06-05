<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
//$route['default_controller'] = 'Maintenance';
$route['404_override'] = 'Errors/error404';
$route['translate_uri_dashes'] = FALSE;



$route['login'] = 'AuthController';
$route['receive-token'] = 'AuthController/receive_token';
$route['receiveFileDS'] = 'AuthController/receive_file_ds';
$route['sertifikat/(:any)'] = 'AuthController/cetak/$1';
//$route['register'] = 'AuthController/cek_nib';
$route['action-cek-nib'] = 'AuthController/action_cek_nib';
$route['register/(:any)'] = 'AuthController/register/$1';
$route['cek-no-sppirt'] = 'AuthController/cek_no_sppirt';
$route['action-cek-no-sppirt'] = 'AuthController/action_cek_no_sppirt';
$route['forgot-password'] = 'AuthController/forgot_password';
$route['action-forgot-password'] = 'AuthController/action_forgot_password';
$route['forgot-password-sendmail'] = 'AuthController/forgot_password_sendmail';
$route['reset-password/(:any)'] = 'AuthController/reset_password/$1';
$route['action-reset-password/(:any)'] = 'AuthController/action_reset_password/$1';
$route['authentication'] = 'AuthController/doLogin';
$route['action-register/(:any)'] = 'AuthController/doRegister/$1';
$route['logout'] = 'AuthController/doLogout';
$route['load-kab-kota'] = 'AuthController/load_kab_kota';
$route['load-kecamatan'] = 'AuthController/load_kecamatan';
$route['load-desa'] = 'AuthController/load_desa';
$route['notif/read/(:any)'] = 'AuthController/read/$1';


$route['account'] = 'AccountController/account';
$route['account/save-profile'] = 'AccountController/save_profil';
$route['account/ubah-password'] = 'AccountController/ubah_password';
$route['account/upload-picture'] = 'AccountController/upload_picture';
$route['account/hapus-profile/(:any)'] = 'AccountController/hapus_profile/$1';

$route['backend/user'] = 'backend/UserController/index';
$route['user'] = 'backend/UserController/index';
$route['user/add'] = 'backend/UserController/add';
$route['user/save'] = 'backend/UserController/save';
$route['user/edit/(:any)'] = 'backend/UserController/get/$1';
$route['user/update/(:any)'] = 'backend/UserController/update/$1';
$route['user/ubah-password/(:any)'] = 'backend/UserController/get_data/$1';
$route['user/change-password/(:any)'] = 'backend/UserController/change_password/$1';
$route['user/delete/(:any)'] = 'backend/UserController/delete/$1';

$route['backend/verifikasi-produk'] = 'backend/VerifikasiProdukController/index';
$route['backend/verifikasi-produk'] = 'backend/VerifikasiProdukController/index';
$route['backend/verifikasi-produk/add'] = 'backend/VerifikasiProdukController/add';
$route['backend/verifikasi-produk/save'] = 'backend/VerifikasiProdukController/save';
$route['backend/verifikasi-produk/edit/(:any)'] = 'backend/VerifikasiProdukController/get/$1';
$route['backend/verifikasi-produk/update/(:any)'] = 'backend/VerifikasiProdukController/update/$1';
$route['backend/verifikasi-produk/delete/(:any)'] = 'backend/VerifikasiProdukController/delete/$1';

$route['backend/permohonan-pembatalan'] = 'backend/PermohonanPembatalanController/index';
$route['backend/pembatalan-disetujui'] = 'backend/PermohonanPembatalanController/pembatalan_disetujui';
$route['backend/pembatalan-ditolak'] = 'backend/PermohonanPembatalanController/pembatalan_ditolak';
$route['backend/permohonan-pembatalan/approve/(:any)'] = 'backend/PermohonanPembatalanController/approve/$1';
$route['backend/permohonan-pembatalan/cancel/(:any)'] = 'backend/PermohonanPembatalanController/cancel/$1';

$route['backend/pembatalan-akun/permohonan-pembatalan'] = 'backend/PembatalanCPPOBController/index';
$route['backend/pembatalan-akun/pengajuan-pembatalan'] = 'backend/PembatalanCPPOBController/pengajuan_pembatalan';
$route['backend/pembatalan-akun/pembatalan-disetujui'] = 'backend/PembatalanCPPOBController/pembatalan_disetujui';
$route['backend/pembatalan-akun/pembatalan-ditolak'] = 'backend/PembatalanCPPOBController/pembatalan_ditolak';
$route['backend/pembatalan-akun/approve/(:any)'] = 'backend/PembatalanCPPOBController/approve/$1';
$route['backend/pembatalan-akun/cancel/(:any)'] = 'backend/PembatalanCPPOBController/cancel/$1';
$route['backend/pembatalan-akun/search-nib'] = 'backend/PembatalanCPPOBController/search_nib';
$route['backend/pembatalan-akun/save-submission'] = 'backend/PembatalanCPPOBController/save_submission';

$route['backend/pembatalan-akun/reactivate-akun'] = 'backend/PembatalanCPPOBController/reactivate_akun';
$route['backend/pembatalan-akun/process-reactivate/(:any)'] = 'backend/PembatalanCPPOBController/process_reactivate/$1';

$route['backend/verifikasi-produk/pengajuan-pembatalan'] = 'backend/VerifikasiProdukController/pengajuan_pembatalan';
$route['backend/verifikasi-produk/rekomendasi-kategori-jenis-pangan'] = 'backend/VerifikasiProdukController/rekomendasi_kategori_jenis_pangan';
$route['backend/verifikasi-produk/rekomendasi-jenis-pangan'] = 'backend/VerifikasiProdukController/rekomendasi_jenis_pangan';
$route['backend/verifikasi-produk/rekomendasi-jumlah-btp'] = 'backend/VerifikasiProdukController/rekomendasi_jumlah_btp';
$route['backend/verifikasi-produk/rekomendasi-jenis-kemasan'] = 'backend/VerifikasiProdukController/rekomendasi_jenis_kemasan';
$route['backend/verifikasi-produk/approve/(:any)'] = 'backend/VerifikasiProdukController/approve/$1';
$route['backend/verifikasi-produk/pemenuhan-komitmen/(:any)'] = 'backend/VerifikasiProdukController/pemenuhan_komitmen/$1';
$route['backend/verifikasi-produk/upload-rekomendasi-pembatalan'] = 'backend/VerifikasiProdukController/upload_rekomendasi_pembatalan';

$route['backend/verifikasi-produk/verifikasi/(:any)'] = 'backend/VerifikasiProdukController/verifikasi/$1';
$route['backend/verifikasi-produk/verifikasi-data/(:any)/(:any)'] = 'backend/VerifikasiProdukController/verifikasi_data/$1/$2';
$route['backend/verifikasi-produk/verifikasi-data/(:any)/(:any)/(:any)'] = 'backend/VerifikasiProdukController/verifikasi_data/$1/$2/$3';


$route['backend/verifikasi-label'] = 'backend/VerifikasiLabelController/index';
$route['backend/verifikasi-label'] = 'backend/VerifikasiLabelController/index';
$route['backend/verifikasi-label/add'] = 'backend/VerifikasiLabelController/add';
$route['backend/verifikasi-label/save'] = 'backend/VerifikasiLabelController/save';
$route['backend/verifikasi-label/edit/(:any)'] = 'backend/VerifikasiLabelController/get/$1';
$route['backend/verifikasi-label/update/(:any)'] = 'backend/VerifikasiLabelController/update/$1';
$route['backend/verifikasi-label/delete/(:any)'] = 'backend/VerifikasiLabelController/delete/$1';

$route['backend/verifikasi-label/verifikasi/(:any)'] = 'backend/VerifikasiLabelController/verifikasi/$1';
$route['backend/verifikasi-label/verifikasi-data'] = 'backend/VerifikasiLabelController/prosesVerifikasi';


$route['backend/rekomendasi-label'] = 'backend/RekomendasiLabelController/index';
$route['backend/rekomendasi-label/verifikasi/(:any)'] = 'backend/RekomendasiLabelController/verifikasi/$1';
$route['backend/rekomendasi-label/verifikasi-data'] = 'backend/RekomendasiLabelController/prosesVerifikasi';


$route['backend/hasil-verifikasi/pirt-dibatalkan'] = 'backend/HasilVerifikasiController/pirt_dibatalkan';


$route['backend/verifikasi-pkp'] = 'backend/VerifikasiPkpController/index';
$route['backend/verifikasi-pkp'] = 'backend/VerifikasiPkpController/index';
$route['backend/verifikasi-pkp/add'] = 'backend/VerifikasiPkpController/add';
$route['backend/verifikasi-pkp/save'] = 'backend/VerifikasiPkpController/save';
$route['backend/verifikasi-pkp/edit/(:any)'] = 'backend/VerifikasiPkpController/get/$1';
$route['backend/verifikasi-pkp/update/(:any)'] = 'backend/VerifikasiPkpController/update/$1';
$route['backend/verifikasi-pkp/delete/(:any)'] = 'backend/VerifikasiPkpController/delete/$1';

$route['backend/verifikasi-pkp/verifikasi/(:any)'] = 'backend/VerifikasiPkpController/verifikasi/$1';
$route['backend/verifikasi-pkp/verifikasi-data'] = 'backend/VerifikasiPkpController/prosesVerifikasi';

$route['backend/sertifikat-pkp'] = 'backend/VerifikasiPkpController/sertifikat_pkp';
$route['backend/sertifikat-pkp/save'] = 'backend/VerifikasiPkpController/sertifikat_pkp_save';

$route['backend/verifikasi-cara-pembuatan'] = 'backend/VerifikasiCaraPembuatanController/index';
$route['backend/verifikasi-cara-pembuatan'] = 'backend/VerifikasiCaraPembuatanController/index';
$route['backend/verifikasi-cara-pembuatan/add'] = 'backend/VerifikasiCaraPembuatanController/add';
$route['backend/verifikasi-cara-pembuatan/save'] = 'backend/VerifikasiCaraPembuatanController/save';
$route['backend/verifikasi-cara-pembuatan/edit/(:any)'] = 'backend/VerifikasiCaraPembuatanController/get/$1';
$route['backend/verifikasi-cara-pembuatan/update/(:any)'] = 'backend/VerifikasiCaraPembuatanController/update/$1';
$route['backend/verifikasi-cara-pembuatan/delete/(:any)'] = 'backend/VerifikasiCaraPembuatanController/delete/$1';

$route['backend/verifikasi-cara-pembuatan/pengajuan-pembatalan'] = 'backend/VerifikasiCaraPembuatanController/pengajuan_pembatalan';
$route['backend/verifikasi-cara-pembuatan/verifikasi/(:any)'] = 'backend/VerifikasiCaraPembuatanController/verifikasi/$1';
$route['backend/verifikasi-cara-pembuatan/verifikasi-data'] = 'backend/VerifikasiCaraPembuatanController/prosesVerifikasi';
$route['backend/verifikasi-cara-pembuatan/verifikasi-data/(:any)/(:any)'] = 'backend/VerifikasiCaraPembuatanController/verifikasi_data/$1/$2';
$route['backend/verifikasi-cara-pembuatan/verifikasi-data/(:any)/(:any)/(:any)'] = 'backend/VerifikasiCaraPembuatanController/verifikasi_data/$1/$2/$3';
$route['backend/verifikasi-cara-pembuatan/upload-rekomendasi-pembatalan'] = 'backend/VerifikasiCaraPembuatanController/upload_rekomendasi_pembatalan';

$route['backend/status-pemenuhan-komitmen'] = 'backend/StatusPemenuhanKomitmenController/index';

$route['backend/403'] = 'Errors/error403';

$route['backend/irtp/(:any)'] = 'backend/Irtp/index/$1';
$route['export-excel'] = 'backend/Irtp/exportexcel';
$route['cekNamaProduk'] = 'backend/Irtp/cekNamaProduk';

$route['backend/pengawasan/(:any)'] = 'backend/Pengawasan/index/$1';
$route['backend/pengawasan/(:any)/(:any)'] = 'backend/Pengawasan/verifikasi/$1/$1';

$route['backend/hasil-pengawasan'] = 'backend/Pengawasan/hasilPengawasan';
$route['backend/hasil-pengawasan/(:any)'] = 'backend/Pengawasan/hasilPengawasan/$1';

$route['backend/monitoring/(:any)'] = 'backend/Monitoring/index/$1';

$route['getRowDataIrtp/(:any)'] = 'backend/Pengawasan/getRowData/$1';

$route['loadTestimoni'] = 'General/loadTestimoni';
$route['loadBerita'] = 'General/loadBerita';
$route['loadData/(:any)'] = 'General/loadAccordion/$1';
$route['loadFaq'] = 'General/loadFaq';

$route['regulasi'] = 'Home/regulasi';
$route['panduan'] = 'Home/panduan';
$route['kontak'] = 'Home/kontak';
$route['berita'] = 'Home/berita';
$route['galeri'] = 'Home/galeri';
$route['faq'] = 'Home/faq';
$route['register'] = 'Home/error_register_oss';

$route['backend/rekap/pelaku-usaha'] = 'backend/RekapController/pelaku_usaha';
$route['backend/rekap/data-pirt'] = 'backend/RekapController/rekap_data_pirt';

$route['backend/rekap/(:any)'] = 'backend/RekapController/detailProduk/$1';


if(!in_array($_SERVER['REMOTE_ADDR'], $this->config->item('maintenance_ips')) && $this->config->item('maintenance_mode')) {
    $route['default_controller'] = "Maintenance/maintenance";
    $route['(:any)'] = "Maintenance/maintenance";
    $route['register/(:any)'] = 'Maintenance/maintenance';
    $route['register'] = 'Maintenance/maintenance';
    //$route['login'] = 'Maintenance/maintenance';
}