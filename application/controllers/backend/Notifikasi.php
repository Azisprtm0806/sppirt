<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notifikasi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        cekLogin();
        $this->load->model('Datatable_Model');
    }
    function list($status)
    {
        $data = [
            'title' => 'Notifikasi IRTP ' . $status,
            'breadcrumb' => breadcrumb('Notifikasi IRTP ' . $status, 'backend/irtp/notifikasi/' . $status)
        ];
        $this->template->load('template/backend', 'backend/irtp/notifikasi-' . $status, $data);
    }


    var $column_order = [null, 'no_sppirt', 'nama_produk_pangan', 'nama_jenis_pangan', 'nama_kemasan', 'tb_pengajuan_sppirt.created_at', 'status_pengajuan'];
    var $column_search = ['no_sppirt', 'nama_produk_pangan', 'nama_jenis_pangan', 'nama_kemasan', 'tb_pengajuan_sppirt.created_at', 'status_pengajuan'];
    var $order = ['tb_pengajuan_sppirt.created_at' => 'DESC'];

    function getData($status)
    {
        if ($this->input->is_ajax_request()) {

            $role_id = $this->session->userdata('userData')['id_role'];
            $sessionkab = $this->session->userdata("userData")['id_kota'];
            $sessionprov = $this->session->userdata("userData")['id_prov'];
            if ($role_id == 1) {
                $where['tb_notifikasi.notifikasi_admin'] = '0';
            } else if ($role_id == 3) {
                $where['tb_notifikasi.notifikasi_dinkeskab'] = '0';
                $where['tb_notifikasi.id_kab'] = $sessionkab;
            } else if ($role_id == 4) {
                $where['tb_notifikasi.notifikasi_ptsp'] = '0';
                $where['tb_notifikasi.id_kab'] = $sessionkab;
            } else if ($role_id == 5) {
                $where['tb_notifikasi.notifikasi_dinkesprov'] = '0';
                $where['tb_notifikasi.id_prov'] = $sessionprov;
            }

            if ($status == 2) {
                $where['tb_pengajuan_sppirt.deleted_at'] = null;
                $where['status_pengajuan'] = $status;
            } else {
                $where['tb_pengajuan_sppirt.deleted_at'] = null;
                $where['status_pengajuan !='] = '2';
            }
            $tipe = $this->input->post('tipe');
            $query = [
                'table' => 'tb_pengajuan_sppirt',
                'select' => '*',
                'where' => $where,
                'join' => [
                    ['tb_input_data_produk', 'tb_input_data_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan', 'inner'],
                    ['tb_jenis_pangan', 'tb_jenis_pangan.id_jenis_pangan = tb_input_data_produk.id_jenis_pangan', 'inner'],
                    ['tb_jenis_kemasan', 'tb_jenis_kemasan.id_jenis_kemasan = tb_input_data_produk.id_jenis_kemasan', 'inner'],
                    ['tb_notifikasi', 'tb_notifikasi.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan', 'inner'],
                    ['tb_user', 'tb_user.id_user = tb_pengajuan_sppirt.id_user', 'RIGHT']
                ]
            ];
            $sppirt = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
            $data = [];
            $no = @$_POST['start'];
            foreach ($sppirt as $irtp) {
                $no++;
                $row = [];
                $row[] = $no . ".";
                if ($status == 2) {
                    $row[] = $irtp->no_sppirt;
                    $row[] = $irtp->nama_produk_pangan;
                }
                $row[] = $irtp->nama_jenis_pangan;
                $row[] = $irtp->nama_kemasan;
                $row[] = date('Y', strtotime($irtp->created_at)) + 5;
                if ($irtp->status_pengajuan == 0) {
                    $status_pengajuan = '<button type="button" class="badge badge-danger">DITOLAK</button>';
                } else if ($irtp->status_pengajuan == 1) {
                    $status_pengajuan = '<button type="button" class="badge badge-warning">DITUNDA</button>';
                } else {
                    $status_pengajuan = '<button type="button" class="badge badge-success">DITERBITKAN</button>';
                }
                $button = '
                <div class="">
                    <a href="' . base_url('backend/Notifikasi/detail/') . encrypt_decrypt('encrypt', $irtp->id_pengajuan) . '" type="button" class="btn btn-info shadow btn-xs sharp mr-1"><i class="fa fa-eye"></i></a>

              </div>
      ';
                $row[] = $status_pengajuan;
                $row[] = $button;
                $data[] = $row;
            }
            $output = [
                'draw' => @$_POST['draw'],
                'recordsTotal' => $this->Datatable_Model->countAll($query),
                'recordsFiltered' => $this->Datatable_Model->countFilters($query, $this->column_order, $this->column_search, $this->order),
                'data' => $data,
            ];


            echo json_encode($output);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
    function detail($id_pengajuan)
    {
        $id_pengajuan = strip_tags($id_pengajuan);
        $id_pengajuan = encrypt_decrypt('decrypt', $id_pengajuan);
        $session = $this->session->userdata('userData')['id_role'];
        $sessionprov = $this->session->userdata('userData')['id_prov'];
        $sessionkota = $this->session->userdata('userData')['id_kota'];

        if ($session == 1) {
            $data = [
                'notifikasi_admin' => '1'
            ];
            $this->db->where(['notifikasi_admin' => '0', 'id_pengajuan' => $id_pengajuan]);
            $this->db->update('tb_notifikasi', $data);
        } else if ($session == 3) {
            $data = [
                'notifikasi_dinkeskab' => '1'
            ];

            $this->db->where(['id_kab', $sessionkota, 'id_pengajuan' => $id_pengajuan]);
            $this->db->update('tb_notifikasi', $data);
        } else if ($session == 4) {
            $data = [
                'notifikasi_ptsp' => '1'
            ];
            $this->db->where(['id_kab', $sessionkota, 'id_pengajuan' => $id_pengajuan]);
            $this->db->update('tb_notifikasi', $data);
        } else if ($session == 5) {
            $data = [
                'notifikasi_dinkesprov' => '1'
            ];

            $this->db->where(['id_prov', $sessionprov, 'id_pengajuan' => $id_pengajuan]);
            $this->db->update('tb_notifikasi', $data);
        }
        $this->db->select('*')
            ->join('tb_user', 'tb_user.id_user = tb_pengajuan_sppirt.id_user')
            ->join('tb_input_data_produk', 'tb_input_data_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan')
            ->join('tb_input_label_produk', 'tb_input_label_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan')
            ->join('tb_jenis_kemasan', 'tb_jenis_kemasan.id_jenis_kemasan = tb_input_data_produk.id_jenis_kemasan')
            ->join('tb_jenis_pangan', 'tb_jenis_pangan.id_jenis_pangan = tb_input_data_produk.id_jenis_pangan')
            ->join('tb_proses_produksi', 'tb_proses_produksi.id_proses_produksi = tb_input_data_produk.id_proses_produksi')
            ->join('tb_penyimpanan', 'tb_penyimpanan.id_penyimpanan = tb_input_data_produk.id_penyimpanan')
            ->join('tb_kategori_jenis_pangan', 'tb_jenis_pangan.id_kategori_jenis_pangan = tb_kategori_jenis_pangan.id_kategori_jenis_pangan')
            ->where('tb_pengajuan_sppirt.id_pengajuan', $id_pengajuan);
        $irtp = $this->db->get('tb_pengajuan_sppirt')->row();
        // var_dump($irtp);die;
        $data = [
            'title' => 'Detail Pengajuan',
            'irtp' => $irtp,
            'breadcrumb' => breadcrumb('Detail Pengajuan', 'backend/irtp/detail/' . encrypt_decrypt('encrypt', $id_pengajuan))
        ];
        $this->template->load('template/backend', 'backend/irtp/detail-pengajuan', $data);
    }
    function markall($status)
    {
        $session = $this->session->userdata('userData')['id_role'];
        $sessionprov = $this->session->userdata('userData')['id_prov'];
        $sessionkota = $this->session->userdata('userData')['id_kota'];

        if ($session == 1) {
            $data = [
                'notifikasi_admin' => '1'
            ];
            $this->db->where(['notifikasi_admin' => '0', 'status' => $status]);
            $this->db->update('tb_notifikasi', $data);
        } else if ($session == 3) {
            $data = [
                'notifikasi_dinkeskab' => '1'
            ];
            $this->db->where(['id_kab', $sessionkota, 'status' => $status]);
            $this->db->update('tb_notifikasi', $data);
        } else if ($session == 4) {
            $data = [
                'notifikasi_ptsp' => '1'
            ];
            $this->db->where(['id_kab', $sessionkota, 'status' => $status]);
            $this->db->update('tb_notifikasi', $data);
        } else if ($session == 5) {
            $data = [
                'notifikasi_dinkesprov' => '1'
            ];
            $this->db->where(['id_prov', $sessionprov, 'status' => $status]);
            $this->db->update('tb_notifikasi', $data);
        }
        $response =  [
            'success' => true,
            'msg' => 'Semua Berhasil Dibaca'
        ];
        echo json_encode($response);
    }
}
