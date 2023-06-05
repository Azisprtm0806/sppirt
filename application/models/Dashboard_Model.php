<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_Model extends CI_Model
{
    public function get_pengajuan()
    {
        $role_id = $this->session->userdata('userData')['id_role'];
        $nib = $this->session->userdata('userData')['id'];
        $id_kota  = $this->session->userdata('userData')['id_kota'];
        $id_prov = $this->session->userdata('userData')['id_prov'];
        $this->db->select('count(tb_pengajuan_sppirt.status_pengajuan) AS pengajuan');
        $this->db->from('tb_pengajuan_sppirt');
        $this->db->join('tb_input_data_produk', 'tb_input_data_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan', 'inner');
        $this->db->join('tb_jenis_pangan', 'tb_jenis_pangan.id_jenis_pangan = tb_input_data_produk.id_jenis_pangan', 'inner');
        $this->db->join('tb_kategori_jenis_pangan', 'tb_kategori_jenis_pangan.id_kategori_jenis_pangan = tb_jenis_pangan.id_kategori_jenis_pangan', 'inner');
        $this->db->join('tb_jenis_kemasan', 'tb_jenis_kemasan.id_jenis_kemasan = tb_input_data_produk.id_jenis_kemasan', 'inner');
        $this->db->join('tb_user', 'tb_user.id_user = tb_pengajuan_sppirt.id_user', 'inner');

        if ($role_id == 2) {
            $this->db->where('tb_pengajuan_sppirt.id_user', $nib);
        } else if ($role_id == 3 || $role_id == 4) {
            $this->db->join('tb_kota', 'tb_kota.id_kota = tb_user.id_kota');
            $this->db->where('tb_user.id_kota', $id_kota);
        } else if ($role_id == 5) {
            $this->db->join('tb_provinsi', 'tb_provinsi.id_prov = tb_user.id_prov');
            $this->db->where('tb_user.id_prov', $id_prov);
        }
        else if ($role_id == 8) {
            $this->db->join('tb_provinsi', 'tb_provinsi.id_prov = tb_user.id_prov');
            $this->db->where('tb_user.id_prov', $id_prov);
        }
        return $this->db->get()->row_array();
    }
    public function get_terbit()
    {
        $role_id = $this->session->userdata('userData')['id_role'];
        $nib = $this->session->userdata('userData')['id'];
        $id_kota  = $this->session->userdata('userData')['id_kota'];
        $id_prov = $this->session->userdata('userData')['id_prov'];
        $this->db->select('count(tb_pengajuan_sppirt.status_pengajuan) AS pengajuan');
        $this->db->from('tb_pengajuan_sppirt');
        $this->db->join('tb_input_data_produk', 'tb_input_data_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan', 'inner');
        $this->db->join('tb_jenis_pangan', 'tb_jenis_pangan.id_jenis_pangan = tb_input_data_produk.id_jenis_pangan', 'inner');
        $this->db->join('tb_kategori_jenis_pangan', 'tb_kategori_jenis_pangan.id_kategori_jenis_pangan = tb_jenis_pangan.id_kategori_jenis_pangan', 'inner');
        $this->db->join('tb_jenis_kemasan', 'tb_jenis_kemasan.id_jenis_kemasan = tb_input_data_produk.id_jenis_kemasan', 'inner');
        $this->db->join('tb_user', 'tb_user.id_user = tb_pengajuan_sppirt.id_user', 'inner');

        if ($role_id == 1 || $role_id == 6 ) {
            $this->db->where('tb_pengajuan_sppirt.status_pengajuan', '2');
        } else  if ($role_id == 2) {
            $this->db->where(['tb_pengajuan_sppirt.id_user'=>$nib,'tb_pengajuan_sppirt.status_pengajuan' => '2']);
        } else if ($role_id == 3 || $role_id == 4) {
            $this->db->where(['tb_user.id_kota' => $id_kota, 'tb_pengajuan_sppirt.status_pengajuan' => '2']);
        } else if ($role_id == 5) {
            $this->db->where(['tb_user.id_prov' => $id_prov, 'tb_pengajuan_sppirt.status_pengajuan' => '2']);
        }
        else if ($role_id == 8) {
            $this->db->where(['tb_user.id_prov' => $id_prov, 'tb_pengajuan_sppirt.status_pengajuan' => '2']);
        }
        return $this->db->get()->row_array();
    }
    public function get_ditangguhkan()
    {
        $role_id = $this->session->userdata('userData')['id_role'];
        $nib = $this->session->userdata('userData')['id'];
        $id_kota  = $this->session->userdata('userData')['id_kota'];
        $id_prov = $this->session->userdata('userData')['id_prov'];
        $this->db->select('count(tb_pengajuan_sppirt.status_pengajuan) AS pengajuan');
        $this->db->from('tb_pengajuan_sppirt');
        $this->db->join('tb_input_data_produk', 'tb_input_data_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan', 'inner');
        $this->db->join('tb_jenis_pangan', 'tb_jenis_pangan.id_jenis_pangan = tb_input_data_produk.id_jenis_pangan', 'inner');
        $this->db->join('tb_kategori_jenis_pangan', 'tb_kategori_jenis_pangan.id_kategori_jenis_pangan = tb_jenis_pangan.id_kategori_jenis_pangan', 'inner');
        $this->db->join('tb_jenis_kemasan', 'tb_jenis_kemasan.id_jenis_kemasan = tb_input_data_produk.id_jenis_kemasan', 'inner');
        $this->db->join('tb_user', 'tb_user.id_user = tb_pengajuan_sppirt.id_user', 'inner');

        if ($role_id == 1 || $role_id == 6 ) {
            $this->db->where('tb_pengajuan_sppirt.status_pengajuan', '1');
        } else  if ($role_id == 2) {
            $this->db->where(['tb_pengajuan_sppirt.id_user'=> $nib,'tb_pengajuan_sppirt.status_pengajuan' => '1']);
        } else if ($role_id == 3 || $role_id == 4) {
            $this->db->join('tb_kota', 'tb_kota.id_kota = tb_user.id_kota');
            $this->db->where(['tb_user.id_kota' => $id_kota, 'tb_pengajuan_sppirt.status_pengajuan' => '1']);
        } else if ($role_id == 5) {
            $this->db->join('tb_provinsi', 'tb_provinsi.id_prov = tb_user.id_prov');
            $this->db->where(['tb_user.id_prov' => $id_prov, 'tb_pengajuan_sppirt.status_pengajuan' => '1']);
        }
        else if ($role_id == 8) {
            $this->db->join('tb_provinsi', 'tb_provinsi.id_prov = tb_user.id_prov');
            $this->db->where(['tb_user.id_prov' => $id_prov, 'tb_pengajuan_sppirt.status_pengajuan' => '1']);
        }
        return $this->db->get()->row_array();
        return $this->db->query($hasil)->row_array();
    }
    public function get_ditolak()
    {
        $role_id = $this->session->userdata('userData')['id_role'];
        $nib = $this->session->userdata('userData')['id'];
        $id_kota  = $this->session->userdata('userData')['id_kota'];
        $id_prov = $this->session->userdata('userData')['id_prov'];
        $this->db->select('count(tb_pengajuan_sppirt.status_pengajuan) AS pengajuan');
        $this->db->from('tb_pengajuan_sppirt');
        $this->db->join('tb_input_data_produk', 'tb_input_data_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan', 'inner');
        $this->db->join('tb_jenis_pangan', 'tb_jenis_pangan.id_jenis_pangan = tb_input_data_produk.id_jenis_pangan', 'inner');
        $this->db->join('tb_kategori_jenis_pangan', 'tb_kategori_jenis_pangan.id_kategori_jenis_pangan = tb_jenis_pangan.id_kategori_jenis_pangan', 'inner');
        $this->db->join('tb_jenis_kemasan', 'tb_jenis_kemasan.id_jenis_kemasan = tb_input_data_produk.id_jenis_kemasan', 'inner');
        $this->db->join('tb_user', 'tb_user.id_user = tb_pengajuan_sppirt.id_user', 'inner');

        if ($role_id == 1 || $role_id == 6 ) {
            $this->db->where('tb_pengajuan_sppirt.status_pengajuan', '0');
        } else  if ($role_id == 2) {
            $this->db->where(['tb_pengajuan_sppirt.id_user'=>$nib,'tb_pengajuan_sppirt.status_pengajuan' => '0']);
        } else if ($role_id == 3 || $role_id == 4) {
            $this->db->join('tb_kota', 'tb_kota.id_kota = tb_user.id_kota');
            $this->db->where(['tb_user.id_kota' => $id_kota, 'tb_pengajuan_sppirt.status_pengajuan' => '0']);
        } else if ($role_id == 5) {
            $this->db->join('tb_provinsi', 'tb_provinsi.id_prov = tb_user.id_prov');
            $this->db->where(['tb_user.id_prov' => $id_prov, 'tb_pengajuan_sppirt.status_pengajuan' => '0']);
        }
        else if ($role_id == 8) {
            $this->db->join('tb_provinsi', 'tb_provinsi.id_prov = tb_user.id_prov');
            $this->db->where(['tb_user.id_prov' => $id_prov, 'tb_pengajuan_sppirt.status_pengajuan' => '0']);
        }
        return $this->db->get()->row_array();
    }
	
	public function get_dibatalkan()
    {
        $role_id = $this->session->userdata('userData')['id_role'];
        $nib = $this->session->userdata('userData')['id'];
        $id_kota  = $this->session->userdata('userData')['id_kota'];
        $id_prov = $this->session->userdata('userData')['id_prov'];
        $this->db->select('count(tb_pengajuan_sppirt.status_pengajuan) AS pengajuan');
        $this->db->from('tb_pengajuan_sppirt');
        $this->db->join('tb_input_data_produk', 'tb_input_data_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan', 'inner');
        $this->db->join('tb_jenis_pangan', 'tb_jenis_pangan.id_jenis_pangan = tb_input_data_produk.id_jenis_pangan', 'inner');
        $this->db->join('tb_kategori_jenis_pangan', 'tb_kategori_jenis_pangan.id_kategori_jenis_pangan = tb_jenis_pangan.id_kategori_jenis_pangan', 'inner');
        $this->db->join('tb_jenis_kemasan', 'tb_jenis_kemasan.id_jenis_kemasan = tb_input_data_produk.id_jenis_kemasan', 'inner');
        $this->db->join('tb_user', 'tb_user.id_user = tb_pengajuan_sppirt.id_user', 'inner');

        if ($role_id == 1 || $role_id == 6 ) {
            $this->db->where('tb_pengajuan_sppirt.status_pengajuan', '3');
        } else  if ($role_id == 2) {
            $this->db->where(['tb_pengajuan_sppirt.id_user'=>$nib,'tb_pengajuan_sppirt.status_pengajuan' => '3']);
        } else if ($role_id == 3 || $role_id == 4) {
            $this->db->join('tb_kota', 'tb_kota.id_kota = tb_user.id_kota');
            $this->db->where(['tb_user.id_kota' => $id_kota, 'tb_pengajuan_sppirt.status_pengajuan' => '3']);
        } else if ($role_id == 5) {
            $this->db->join('tb_provinsi', 'tb_provinsi.id_prov = tb_user.id_prov');
            $this->db->where(['tb_user.id_prov' => $id_prov, 'tb_pengajuan_sppirt.status_pengajuan' => '3']);
        }
        else if ($role_id == 8) {
            $this->db->join('tb_provinsi', 'tb_provinsi.id_prov = tb_user.id_prov');
            $this->db->where(['tb_user.id_prov' => $id_prov, 'tb_pengajuan_sppirt.status_pengajuan' => '3']);
        }
        return $this->db->get()->row_array();
    }

    public function get_notifications(){
        $id = $this->session->userdata('userData')['id'];
        $role_id = $this->session->userdata('userData')['id_role'];
        $id_kota  = $this->session->userdata('userData')['id_kota'];
        $id_prov = $this->session->userdata('userData')['id_prov'];

        $this->db->from('tb_notification');
        $this->db->where('read', 0);
        $this->db->order_by("created_at", "DESC");

        //ROLE ADMIN (ROLE = 1) DAPET SEMUA
        //ROLE PU || DINKES KABKOT || PTSP KABKOT (ROLE = 2 || ROLE = 3|| ROLE = 4) DAPET SESUAI USER_ID
        if ($role_id == 2 || $role_id == 3 || $role_id == 4) {
            $this->db->where('user_id', $id);
        }
        //ROLE DINKES PROV || PTSP PROV ( ROLE = 5 || ROLE = 8) DAPET UNDER SEMUA YG UNDER PROVINSINYA
        // if ($role_id == 5 || $role_id == 8) {
        //     $this->db->where('user_id', $id);
        // }

        return $this->db->get()->result_array();
    }

    public function update_notification($type, $datas=""){
        $id = $this->session->userdata('userData')['id'];
        $role_id = $this->session->userdata('userData')['id_role'];

        if ($type != 'all') { $this->db->where_in('id', $datas); }
        if ($type == 'all' && $role_id != 1) { $this->db->where('user_id', $id); }
        $this->db->update("tb_notification",array('read'=>1));

        return $this->db->error();
    }
}
