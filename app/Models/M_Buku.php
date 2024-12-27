<?php
namespace App\Models;
use CodeIgniter\Model;
 
class M_Buku extends Model
{
    protected $table = 'tb_buku';

    public function getDataBuku($where = false)
    {
        if ($where === false) {
            $builder = $this->db->table($this->table);
            $builder->select('*');
            $builder->orderBy('judul_buku','ASC');
            return $query = $builder->get();
        } else {
            $builder = $this->db->table($this->table);
            $builder->select('*');
            $builder->where($where);
            $builder->orderBy('judul_buku','ASC');
            return $query = $builder->get();
        }
    }
 
    public function getDataBukuJoin($where = false)
    {
        if ($where === false) {
            $builder = $this->db->table($this->table);
            $builder->select('*');
            $builder->join('tb_kategori', 'tb_kategori.id_kategori = tb_buku.id_kategori', 'LEFT');
            $builder->join('tb_rak', 'tb_rak.id_rak = tb_buku.id_rak', 'LEFT');
            $builder->orderBy('tb_buku.judul_buku','ASC');
            return $query = $builder->get();
        } else {
            $builder = $this->db->table($this->table);
            $builder->select('*');
            $builder->where($where);
            $builder->join('tb_kategori', 'tb_kategori.id_kategori = tb_buku.id_kategori', 'LEFT');
            $builder->join('tb_rak', 'tb_rak.id_rak = tb_buku.id_rak', 'LEFT');
            $builder->orderBy('tb_buku.judul_buku','ASC');
            return $query = $builder->get();
        }
    }
    
    public function saveDataBuku($data)
    {
        $builder = $this->db->table($this->table);
        return $builder->insert($data);
    }

    public function updateDataBuku($data, $where)
    {
        $builder = $this->db->table($this->table);
        $builder->where($where);
        return $builder->update($data);
    }
    
    public function autoNumber() {
        $builder = $this->db->table($this->table);
        $builder->select("id_buku");
        $builder->orderBy("id_buku", "DESC");
        $builder->limit(1);
        return $query = $builder->get();
	}
}
?>