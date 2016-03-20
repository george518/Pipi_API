<?php 
namespace Common;
use Common\Db\Pdo as Pdos;

class Model
{
    protected $model;
    protected $table;
    protected $fields = '*';
    protected $order  = '';
    protected $limit  = '';
    protected $where  = ''; 
    protected $data   = array();

    public function __construct($table='')
    {
        $this->table = $table;
        $this->model = Pdos::getInstance();
    }


    public function select()
    {
        $sql  = 'SELECT ';
        $sql .= $this->fields;
        $sql .= ' FROM '.$this->table;
        $sql .= $this->where ? ' WHERE '.$this->where : ''; 
        $sql .= $this->order ? ' ORDER BY '.$this->order : '';
        $sql .= $this->limit ? ' LIMIT '.$this->limit : '';
        $res  = $this->model->query($sql);
        $res->setFetchMode(C('FETCH_TYPE'));
        $data = $res->fetchAll();
        return $data;
    }

    public function add()
    {
        $sql    = 'INSERT INTO ';
        $sql   .= $this->table;

        $keys   = '';
        $values = '';
        foreach ($this->data as $key => $value) {
            $keys   .= '`'.$key.'`,';
            $values .= '"'.$value.'",';
        }

        $keys   = rtrim($keys,',');
        $values = rtrim($values,',');
        
        $sql .= '('.rtrim($keys,',').')';
        $sql .= ' VALUES('.$values.')';

        $this->model->exec($sql);
        return $this->model->lastInsertId(); 
    }

    /**
     * [save 修改]
     * @return [type] [影响条数0-n OR false]
     */
    public function save()
    {
        $sql    = 'UPDATE ';
        $sql   .= $this->table;
        $sql   .= ' SET ';
        foreach ($this->data as $key => $value) {
            $sql    .= '`'.$key.'`="'.$value.'",';
        }
        $sql    = rtrim($sql,',');
        $sql   .= ' WHERE '.$this->where;
        return $this->model->exec($sql);
    }
    /**
     * [delete description]
     * @return [type] [false 或影响条数]
     */
    public function delete()
    {
        $sql    = 'DELETE FROM ';
        $sql   .= $this->table;
        $sql   .= ' WHERE '.$this->where;
        echo $sql;
        return $this->model->exec($sql);
    }
    
    public function sqlQuery($sql)
    {
        if (strpos(strtolower($sql),'select')!==false) {
            $res = $this->model->query($sql);
            $res->setFetchMode(C('FETCH_TYPE'));
            return $res->fetchAll();
        }else
        {
            return $this->model->exec($sql);
        }
    }

    public function data($data)
    {
        $this->data = $data;
        return $this;
    }

    

    public function fields($fields="*")
    {
        $this->fields = $fields;
        return $this;
    }

    public function order($order='')
    {
        $this->order = $order;
        return $this;
    }

    public function limit($limit='')
    {
        $this->limit = $limit;
        return $this;
    }

    public function where($where='')
    {
        $this->where = $where;
        return $this;
    }
}