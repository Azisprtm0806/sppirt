<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_Model extends CI_Model
{
    public function get_pengajuan()
    {
        $role_id = $this->session->userdata('userData')['id_role'];
        $nib = $this->session->userdata('userData')['nib'];
        $id_kota  = $this->session->userdata('userData')['id_kota'];
        $id_prov = $this->session->userdata('userData')['id_prov'];
        if ($role_id == 1) {
            $hasil = $this->db->get('tb_pengajuan_sppirt')->num_rows();
        } else if ($role_id == 2) {
            $hasil = $this->db->get_where('tb_pengajuan_sppirt', ['nib' => $nib])->num_rows();
        } else if ($role_id == 3 & $role_id == 4) {
            $hasil = $this->db->get_where('tb_pengajuan_sppirt', ['id_kota' => $id_kota])->num_rows();
        } else if ($role_id == 5) {
            $hasil = $this->db->get_where('tb_pengajuan_sppirt', ['id_prov' => $id_prov])->num_rows();
        }
        return $hasil;
    }
    public function get_terbit()
    {
        $role_id = $this->session->userdata('userData')['id_role'];
        $nib = $this->session->userdata('userData')['nib'];
        $id_kota  = $this->session->userdata('userData')['id_kota'];
        $id_prov = $this->session->userdata('userData')['id_prov'];
        if ($role_id == 1) {
            $hasil = $this->db->get_where('tb_pengajuan_sppirt', ['status_pengajuan' => '2'])->num_rows();
        } else if ($role_id == 2) {
            $hasil = $this->db->get_where('tb_pengajuan_sppirt', ['nib' => $nib, 'status_pengajuan' => '2'])->num_rows();
        } else if ($role_id == 3 & $role_id == 4) {
            $hasil = $this->db->get_where('tb_pengajuan_sppirt', ['id_kota' => $id_kota, 'status_pengajuan' => '2'])->num_rows();
        } else if ($role_id == 5) {
            $hasil = $this->db->get_where('tb_pengajuan_sppirt', ['id_prov' => $id_prov, 'status_pengajuan' => '2'])->num_rows();
        }
        return $hasil;
    }
    public function get_ditangguhkan()
    {
        $role_id = $this->session->userdata('userData')['id_role'];
        $nib = $this->session->userdata('userData')['nib'];
        $id_kota  = $this->session->userdata('userData')['id_kota'];
        $id_prov = $this->session->userdata('userData')['id_prov'];
        if ($role_id == 1) {
            $hasil = $this->db->get_where('tb_pengajuan_sppirt', ['status_pengajuan' => '1'])->num_rows();
        } else if ($role_id == 2) {
            $hasil = $this->db->get_where('tb_pengajuan_sppirt', ['nib' => $nib, 'status_pengajuan' => '1'])->num_rows();
        } else if ($role_id == 3 & $role_id == 4) {
            $hasil = $this->db->get_where('tb_pengajuan_sppirt', ['id_kota' => $id_kota, 'status_pengajuan' => '1'])->num_rows();
        } else if ($role_id == 5) {
            $hasil = $this->db->get_where('tb_pengajuan_sppirt', ['id_prov' => $id_prov, 'status_pengajuan' => '1'])->num_rows();
        }
        return $hasil;
    }
    public function get_ditolak()
    {
        $role_id = $this->session->userdata('userData')['id_role'];
        $nib = $this->session->userdata('userData')['nib'];
        $id_kota  = $this->session->userdata('userData')['id_kota'];
        $id_prov = $this->session->userdata('userData')['id_prov'];
        if ($role_id == 1) {
            $hasil = $this->db->get_where('tb_pengajuan_sppirt', ['status_pengajuan' => '0'])->num_rows();
        } else if ($role_id == 2) {
            $hasil = $this->db->get_where('tb_pengajuan_sppirt', ['nib' => $nib, 'status_pengajuan' => '0'])->num_rows();
        } else if ($role_id == 3 & $role_id == 4) {
            $hasil = $this->db->get_where('tb_pengajuan_sppirt', ['id_kota' => $id_kota, 'status_pengajuan' => '0'])->num_rows();
        } else if ($role_id == 5) {
            $hasil = $this->db->get_where('tb_pengajuan_sppirt', ['id_prov' => $id_prov, 'status_pengajuan' => '0'])->num_rows();
        }
        return $hasil;
    }
}
