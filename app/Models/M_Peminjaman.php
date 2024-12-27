<?php
namespace App\Models;
use CodeIgniter\Model;
 
class M_Peminjaman extends Model
{
    protected $table = 'tb_peminjaman';
    protected $tableTmp = 'tb_temp_peminjaman';
    protected $tableDetail = 'tb_detail_peminjaman';

    public function getDataPeminjaman($where = false)
    {
        if ($where === false) {
            $builder = $this->db->table($this->table);
            $builder->select('*');
            $builder->orderBy('no_peminjaman','DESC');
            return $query = $builder->get();
        } else {
            $builder = $this->db->table($this->table);
            $builder->select('*');
            $builder->where($where);
            $builder->orderBy('no_peminjaman','DESC');
            return $query = $builder->get();
        }
    }

    public function getDataTemp($where = false)
    {
        if ($where === false) {
            $builder = $this->db->table($this->tableTmp);
            $builder->select('*');
            $builder->orderBy('id_anggota','DESC');
            return $query = $builder->get();
        } else {
            $builder = $this->db->table($this->tableTmp);
            $builder->select('*');
            $builder->where($where);
            $builder->orderBy('id_anggota','DESC');
            return $query = $builder->get();
        }
    }
 
    public function getDataPeminjamanJoin($where = false)
    {
        if ($where === false) {
            $builder = $this->db->table($this->table);
            $builder->select('*');
            $builder->join('tb_anggota', 'tb_anggota.id_anggota = tb_peminjaman.id_anggota', 'LEFT');
            $builder->join('tb_admin', 'tb_admin.id_admin = tb_peminjaman.id_admin', 'LEFT');
            $builder->orderBy('tb_peminjaman.no_peminjaman','DESC');
            return $query = $builder->get();
        } else {
            $builder = $this->db->table($this->table);
            $builder->select('*');
            $builder->where($where);
            $builder->join('tb_anggota', 'tb_anggota.id_anggota = tb_peminjaman.id_anggota', 'LEFT');
            $builder->join('tb_admin', 'tb_admin.id_admin = tb_peminjaman.id_admin', 'LEFT');
            $builder->orderBy('tb_peminjaman.no_peminjaman','DESC');
            return $query = $builder->get();
        }
    }

    public function getDataTempJoin($where = false)
    {
        if ($where === false) {
            $builder = $this->db->table($this->tableTmp);
            $builder->select('*');
            $builder->join('tb_anggota','tb_anggota.id_anggota = tb_temp_peminjaman.id_anggota','LEFT');
            $builder->join('tb_buku','tb_buku.id_buku = tb_temp_peminjaman.id_buku','LEFT');
            $builder->orderBy('tb_temp_peminjaman.id_anggota','DESC');
            return $query = $builder->get();
        } else {
            $builder = $this->db->table($this->tableTmp);
            $builder->select('*');
            $builder->where($where);
            $builder->join('tb_anggota','tb_anggota.id_anggota = tb_temp_peminjaman.id_anggota','LEFT');
            $builder->join('tb_buku','tb_buku.id_buku = tb_temp_peminjaman.id_buku','LEFT');
            $builder->orderBy('tb_temp_peminjaman.id_anggota','DESC');
            return $query = $builder->get();
        }
    }

    public function getDetailPeminjamanJoin($where = false)
    {
        if ($where === false) {
            $builder = $this->db->table($this->tableDetail);
            $builder->select('*');
            $builder->join('tb_buku','tb_buku.id_buku = tb_detail_peminjaman.id_buku','LEFT');
            $builder->orderBy('tb_detail_peminjaman.no_peminjaman','DESC');
            return $query = $builder->get();
        } else {
            $builder = $this->db->table($this->tableDetail);
            $builder->select('*');
            $builder->where($where);
            $builder->join('tb_buku','tb_buku.id_buku = tb_detail_peminjaman.id_buku','LEFT');
            $builder->orderBy('tb_detail_peminjaman.no_peminjaman','DESC');
            return $query = $builder->get();
        }
    }
    
    public function saveDataPeminjaman($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insert($data);
    }

    public function updateDataPeminjaman($data, $where)
    {
        $builder = $this->db->table($this->table);
        $builder->where($where);
        return $builder->update($data);
    }



    public function saveDataTemp($data)
    {
        $builder = $this->db->table($this->tableTmp);
        return $builder->insert($data);
    }

    public function updateDataTempPeminjam($data, $where)
    {
        $builder = $this->db->table($this->tableTmp);
        $builder->where($where);
        return $builder->update($data);
    }

    public function saveDataDetail($data)
    {
        $builder = $this->db->table($this->tableDetail);
        return $builder->insert($data);
    }

    public function updateDataDetail($data, $where)
    {
        $builder = $this->db->table($this->tableDetail);
        $builder->where($where);
        return $builder->update($data);
    }

    public function hapusDataTemp($data)
    {
        $builder = $this->db->table($this->tableTmp);
        return $builder->delete($data);
    }

    public function hapusDataPeminjaman($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->delete($data);
    }
}
?>