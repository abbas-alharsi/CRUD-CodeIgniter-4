<?php
namespace App\Models;
use CodeIgniter\Model;
use App\Config\Database;

class MyModel extends Model {
    protected $db;
    protected $input;
    public function __construct() {
        $this->db = \Config\Database::connect();
        $this->input = \Config\Services::request();
    }
    public function getData($id = false) {
        if($id) {
            return $this->db->table('products')->where('id',$id)->get()->getResult();
        } else {
            return $this->db->table('products')->get()->getResult();
        }
    }
    public function insertData() {
        $data = array(
            'product'=>$this->input->getPost('product'),
            'category'=>$this->input->getPost('category'),
            'qty'=>$this->input->getPost('qty'),
            'price'=>$this->input->getPost('price')
        );
        $this->db->table('products')->insert($data);
        return $this->getData();
    }
    public function deleteData() {
        $id = $this->input->getPost('deleteId');
        $this->db->table('products')->where('id',$id)->delete();
        return $this->getData();
    }
    public function updateData() {
        $id = $this->input->getPost('editId');
        $updateData = array(
            'product'=>$this->input->getPost('newProduct'),
            'category'=>$this->input->getPost('newCategory'),
            'qty'=>$this->input->getPost('newQty'),
            'price'=>$this->input->getPost('newPrice')
        );
        $this->db->table('products')->where('id', $id)->update($updateData);
        return $this->getData();
    }
}